from fastapi import FastAPI
from fastapi.responses import JSONResponse, StreamingResponse
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

from ultralytics import YOLO

import cv2
import os
import time
import threading
import subprocess
import shutil
import numpy as np
import yt_dlp


# =========================================================
# FASTAPI
# =========================================================

app = FastAPI(
    title="WASKARA CCTV YOLOv11",
    description="API CCTV / ATCS dengan YOLOv11",
    version="1.0.0"
)


# =========================================================
# CORS
# =========================================================

app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://127.0.0.1:8000",
        "http://localhost:8000",
    ],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# =========================================================
# PATH MODEL
# =========================================================

BASE_DIR = os.path.dirname(
    os.path.abspath(__file__)
)

MODEL_PATH = os.path.join(
    BASE_DIR,
    "best.pt"
)


# =========================================================
# PATH FFMPEG
# =========================================================
# FFmpeg yang sudah berhasil kamu install
# =========================================================

FFMPEG_PATH = (
    r"E:\Skripsi\ffmpeg-9.0.1-essentials_build"
    r"\bin\ffmpeg.exe"
)


# =========================================================
# CEK FFMPEG
# =========================================================

def get_ffmpeg_path():

    # Prioritas pertama:
    # path FFmpeg milik WASKARA

    if os.path.isfile(FFMPEG_PATH):

        return FFMPEG_PATH

    # Jika tidak ditemukan,
    # coba cari dari PATH Windows

    ffmpeg_from_path = shutil.which(
        "ffmpeg"
    )

    if ffmpeg_from_path:

        return ffmpeg_from_path

    return None


# =========================================================
# LOAD MODEL
# =========================================================

model = YOLO(
    MODEL_PATH
)


print("========================================")
print(
    "CCTV - Model YOLOv11 berhasil dimuat."
)
print(
    "Class:",
    model.names
)
print(
    "FFmpeg:",
    get_ffmpeg_path()
)
print("========================================")


# =========================================================
# CCTV REQUEST
# =========================================================

class CCTVRequest(BaseModel):

    url: str


# =========================================================
# CCTV STATE
# =========================================================

cctv_state = {

    "url": None,

    "original_url": None,

    "source_type": "direct",

    "headers": {},

    "connected": False,

    "stop": False,

    "fps": 0.0,

    "with_helmet": 0,

    "without_helmet": 0,

    "total": 0

}


cctv_lock = threading.Lock()


# =========================================================
# TEST API
# =========================================================

@app.get("/")
def home():

    return {

        "success": True,

        "message":
            "WASKARA CCTV YOLOv11 API aktif",

        "model":
            "YOLOv11",

        "classes":
            model.names,

        "ffmpeg_available":
            get_ffmpeg_path() is not None

    }


# =========================================================
# SOURCE HELPERS
# =========================================================

def is_youtube_url(url):

    url = url.lower().strip()

    return (

        "youtube.com/" in url

        or

        "youtu.be/" in url

        or

        "youtube-nocookie.com/" in url

    )


# =========================================================
# RESOLVE YOUTUBE
# =========================================================

def resolve_youtube_stream(url):
    """
    Resolve YouTube Live menjadi URL stream yang benar-benar tersedia.

    Jangan memaksa format="best" karena pada beberapa YouTube Live
    saat ini selector tersebut dapat menghasilkan:
    "Requested format is not available".

    Kita ambil daftar format dari yt-dlp lalu pilih format video
    yang memiliki URL, dengan prioritas HLS/m3u8.
    """

    options = {
        "quiet": True,
        "no_warnings": True,
        "noplaylist": True,
        "skip_download": True,
    }

    try:
        with yt_dlp.YoutubeDL(options) as ydl:
            info = ydl.extract_info(
                url,
                download=False
            )

        formats = info.get("formats") or []

        # -----------------------------------------------------
        # PILIH FORMAT VIDEO
        # Prioritas:
        # 1. m3u8 / HLS
        # 2. format video lain yang memiliki URL
        # -----------------------------------------------------
        video_formats = []

        for fmt in formats:
            candidate = fmt.get("url")
            if not candidate:
                continue

            # Harus memiliki video
            if fmt.get("vcodec") in (None, "none"):
                continue

            video_formats.append(fmt)

        if not video_formats:
            # Beberapa hasil extractor menyediakan URL langsung
            direct_url = info.get("url")
            if direct_url:
                return {
                    "url": direct_url,
                    "headers": info.get("http_headers", {}) or {}
                }

            raise RuntimeError(
                "YouTube tidak menyediakan URL video yang dapat digunakan. "
                "Coba update yt-dlp dan pastikan YouTube Live dapat diputar "
                "normal di browser."
            )

        # Prioritaskan HLS/m3u8 karena paling cocok untuk FFmpeg Live
        hls_formats = [
            fmt for fmt in video_formats
            if "m3u8" in str(fmt.get("protocol", "")).lower()
            or ".m3u8" in str(fmt.get("url", "")).lower()
        ]

        candidates = hls_formats or video_formats

        # Pilih resolusi tertinggi yang tersedia.
        # Jika height tidak tersedia, dianggap 0.
        selected = max(
            candidates,
            key=lambda fmt: (
                int(fmt.get("height") or 0),
                int(fmt.get("width") or 0),
                float(fmt.get("tbr") or 0)
            )
        )

        stream_url = selected.get("url")

        if not stream_url:
            raise RuntimeError(
                "URL stream YouTube tidak ditemukan."
            )

        headers = (
            selected.get("http_headers")
            or info.get("http_headers")
            or {}
        )

        print(
            "YouTube format terpilih:",
            selected.get("format_id"),
            selected.get("protocol"),
            selected.get("width"),
            "x",
            selected.get("height")
        )

        return {
            "url": stream_url,
            "headers": headers
        }

    except Exception as e:
        raise RuntimeError(
            "YouTube Live tidak dapat diakses: "
            + str(e)
        )


# =========================================================
# BUILD FFMPEG COMMAND
# =========================================================

def build_ffmpeg_command(
    stream_url,
    headers=None
):

    ffmpeg = get_ffmpeg_path()


    if not ffmpeg:

        raise RuntimeError(

            "FFmpeg tidak ditemukan. "
            "Pastikan path FFmpeg benar."

        )


    # =====================================================
    # COMMAND DASAR
    # =====================================================

    command = [

        ffmpeg,

        "-hide_banner",

        "-loglevel",
        "error",

        "-fflags",
        "nobuffer",

        "-flags",
        "low_delay",

        "-reconnect",
        "1",

        "-reconnect_streamed",
        "1",

        "-reconnect_delay_max",
        "5",

    ]


    # =====================================================
    # HEADER UNTUK YOUTUBE
    # =====================================================

    if headers:

        header_text = ""


        for key, value in headers.items():

            if key.lower() in [

                "user-agent",

                "referer",

                "origin"

            ]:

                header_text += (

                    f"{key}: "
                    f"{value}\r\n"

                )


        if header_text:

            command.extend([

                "-headers",

                header_text

            ])


    # =====================================================
    # INPUT
    # =====================================================

    command.extend([

        "-i",

        stream_url,

        "-an",

        "-f",

        "image2pipe",

        "-vcodec",

        "mjpeg",

        "-q:v",

        "5",

        "-"

    ])


    return command


# =========================================================
# OPEN FFMPEG STREAM
# =========================================================

def open_ffmpeg_stream(
    stream_url,
    headers=None
):

    command = build_ffmpeg_command(

        stream_url,

        headers

    )


    print()
    print("========================================")
    print("MENJALANKAN FFMPEG")
    print("========================================")

    print(
        "Source:",
        stream_url[:200]
    )

    print("========================================")


    try:

        process = subprocess.Popen(

            command,

            stdout=subprocess.PIPE,

            stderr=subprocess.PIPE,

            bufsize=0

        )

    except Exception as e:

        raise RuntimeError(

            "FFmpeg gagal dijalankan: "

            + str(e)

        )


    return process


# =========================================================
# READ JPEG FROM FFMPEG
# =========================================================

def read_jpeg_from_process(
    process,
    buffer
):

    while True:

        # ---------------------------------------------
        # Cari awal JPEG
        # ---------------------------------------------

        start = buffer.find(
            b"\xff\xd8"
        )


        if start == -1:

            chunk = process.stdout.read(
                4096
            )


            if not chunk:

                return None, buffer


            buffer += chunk

            continue


        # ---------------------------------------------
        # Cari akhir JPEG
        # ---------------------------------------------

        end = buffer.find(

            b"\xff\xd9",

            start + 2

        )


        if end == -1:

            chunk = process.stdout.read(
                4096
            )


            if not chunk:

                return None, buffer


            buffer += chunk

            continue


        # ---------------------------------------------
        # Ambil JPEG lengkap
        # ---------------------------------------------

        end += 2


        jpeg_data = buffer[
            start:end
        ]


        buffer = buffer[
            end:
        ]


        return (
            jpeg_data,
            buffer
        )


# =========================================================
# TEST STREAM
# =========================================================

def test_stream(

    stream_url,

    headers=None,

    timeout_seconds=15

):

    process = open_ffmpeg_stream(

        stream_url,

        headers

    )


    buffer = bytearray()


    start_time = time.time()


    try:

        while (

            time.time()
            -
            start_time
            <
            timeout_seconds

        ):

            jpeg_data, buffer = (

                read_jpeg_from_process(

                    process,

                    buffer

                )

            )


            if jpeg_data is None:

                break


            frame = cv2.imdecode(

                np.frombuffer(

                    jpeg_data,

                    dtype=np.uint8

                ),

                cv2.IMREAD_COLOR

            )


            if frame is not None:

                return True


    finally:

        try:

            process.kill()

        except Exception:

            pass


        try:

            process.wait(
                timeout=2
            )

        except Exception:

            pass


    return False


# =========================================================
# CONNECT CCTV
# =========================================================

@app.post("/cctv/connect")
def connect_cctv(
    data: CCTVRequest
):

    original_url = data.url.strip()


    # =====================================================
    # VALIDASI URL
    # =====================================================

    if not original_url:

        return JSONResponse(

            status_code=400,

            content={

                "success": False,

                "message":
                    "URL sumber tidak boleh kosong."

            }

        )


    # =====================================================
    # CEK FFMPEG
    # =====================================================

    if not get_ffmpeg_path():

        return JSONResponse(

            status_code=500,

            content={

                "success": False,

                "message":
                    "FFmpeg tidak ditemukan."

            }

        )


    # =====================================================
    # TENTUKAN JENIS SUMBER
    # =====================================================

    source_type = (

        "youtube"

        if is_youtube_url(
            original_url
        )

        else

        "direct"

    )


    stream_url = original_url

    headers = {}


    # =====================================================
    # YOUTUBE
    # =====================================================

    if source_type == "youtube":

        try:

            youtube_result = (

                resolve_youtube_stream(

                    original_url

                )

            )


            stream_url = (

                youtube_result[
                    "url"
                ]

            )


            headers = (

                youtube_result[
                    "headers"
                ]

            )


        except Exception as e:

            return JSONResponse(

                status_code=400,

                content={

                    "success": False,

                    "message":
                        str(e)

                }

            )


    # =====================================================
    # TEST STREAM
    # =====================================================

    print()

    print(
        "Mencoba menghubungkan:",
        source_type
    )

    print(
        "Original URL:",
        original_url
    )


    try:

        stream_ok = test_stream(

            stream_url,

            headers,

            timeout_seconds=15

        )


    except Exception as e:

        return JSONResponse(

            status_code=400,

            content={

                "success": False,

                "message":
                    "Gagal menjalankan FFmpeg.",

                "error":
                    str(e)

            }

        )


    # =====================================================
    # STREAM GAGAL
    # =====================================================

    if not stream_ok:

        return JSONResponse(

            status_code=400,

            content={

                "success": False,

                "message": (

                    "Stream tidak dapat dibuka "
                    "atau frame tidak dapat dibaca. "
                    "Pastikan URL benar dan stream "
                    "masih aktif."

                ),

                "source_type":
                    source_type

            }

        )


    # =====================================================
    # SIMPAN STATE
    # =====================================================

    with cctv_lock:

        cctv_state[
            "url"
        ] = stream_url


        cctv_state[
            "original_url"
        ] = original_url


        cctv_state[
            "source_type"
        ] = source_type


        cctv_state[
            "headers"
        ] = headers


        cctv_state[
            "connected"
        ] = True


        cctv_state[
            "stop"
        ] = False


        cctv_state[
            "fps"
        ] = 0.0

        cctv_state[
            "with_helmet"
        ] = 0

        cctv_state[
            "without_helmet"
        ] = 0

        cctv_state[
            "total"
        ] = 0


    return {

        "success": True,

        "message":
            "Sumber berhasil terhubung.",

        "source_type":
            source_type,

        "stream_url":
            "/cctv/stream"

    }


# =========================================================
# CCTV STREAM
# =========================================================

@app.get("/cctv/stream")
def cctv_stream():

    with cctv_lock:

        if not cctv_state[
            "connected"
        ]:

            return JSONResponse(

                status_code=400,

                content={

                    "success": False,

                    "message":
                        "CCTV belum terhubung."

                }

            )


        url = cctv_state[
            "url"
        ]


        headers = dict(

            cctv_state[
                "headers"
            ]

        )


        cctv_state[
            "stop"
        ] = False


    return StreamingResponse(

        generate_cctv(

            url,

            headers

        ),

        media_type=(

            "multipart/x-mixed-replace;"

            " boundary=frame"

        )

    )


# =========================================================
# GENERATE CCTV
# =========================================================

def generate_cctv(

    url,

    headers=None

):

    process = None


    try:

        # =================================================
        # START FFMPEG
        # =================================================

        process = open_ffmpeg_stream(

            url,

            headers

        )


        buffer = bytearray()


        # =================================================
        # LOOP STREAM
        # =================================================

        while True:

            # ---------------------------------------------
            # CEK STOP
            # ---------------------------------------------

            with cctv_lock:

                if cctv_state[
                    "stop"
                ]:

                    break


            # ---------------------------------------------
            # BACA FRAME
            # ---------------------------------------------

            jpeg_data, buffer = (

                read_jpeg_from_process(

                    process,

                    buffer

                )

            )


            if jpeg_data is None:

                print(
                    "Frame CCTV gagal dibaca."
                )

                break


            # ---------------------------------------------
            # JPEG → OPENCV
            # ---------------------------------------------

            frame = cv2.imdecode(

                np.frombuffer(

                    jpeg_data,

                    dtype=np.uint8

                ),

                cv2.IMREAD_COLOR

            )


            if frame is None:

                continue


            # =================================================
            # YOLO
            # =================================================

            start_time = (

                time.perf_counter()

            )


            results = model(

                frame,

                conf=0.50,

                imgsz=640,

                verbose=False

            )


            inference_time = (

                time.perf_counter()

                -

                start_time

            )


            # =================================================
            # FPS
            # =================================================

            fps = 0


            if inference_time > 0:

                fps = (

                    1
                    /
                    inference_time

                )


            # =================================================
            # COUNTER
            # =================================================

            with_helmet = 0

            without_helmet = 0


            # =================================================
            # DETECTION
            # =================================================

            for result in results:

                if result.boxes is None:

                    continue


                for box in result.boxes:

                    # -----------------------------------------
                    # COORDINATE
                    # -----------------------------------------

                    x1, y1, x2, y2 = (

                        box.xyxy[
                            0
                        ].tolist()

                    )


                    # -----------------------------------------
                    # CONFIDENCE
                    # -----------------------------------------

                    confidence = float(

                        box.conf[
                            0
                        ]

                    )


                    # -----------------------------------------
                    # CLASS
                    # -----------------------------------------

                    class_id = int(

                        box.cls[
                            0
                        ]

                    )


                    class_name = (

                        model.names[
                            class_id
                        ]

                    )


                    # -----------------------------------------
                    # COUNT
                    # -----------------------------------------

                    if (

                        class_name
                        ==
                        "With_helmet"

                    ):

                        with_helmet += 1


                        box_color = (

                            0,
                            200,
                            0

                        )


                    elif (

                        class_name
                        ==
                        "without_helmet"

                    ):

                        without_helmet += 1


                        box_color = (

                            0,
                            0,
                            255

                        )


                    else:

                        box_color = (

                            255,
                            255,
                            0

                        )


                    # -----------------------------------------
                    # BOUNDING BOX
                    # -----------------------------------------

                    cv2.rectangle(

                        frame,

                        (

                            int(x1),
                            int(y1)

                        ),

                        (

                            int(x2),
                            int(y2)

                        ),

                        box_color,

                        2

                    )


                    # -----------------------------------------
                    # LABEL
                    # -----------------------------------------

                    label = (

                        f"{class_name} "

                        f"{confidence * 100:.1f}%"

                    )


                    cv2.putText(

                        frame,

                        label,

                        (

                            int(x1),

                            max(

                                int(y1) - 10,

                                20

                            )

                        ),

                        cv2.FONT_HERSHEY_SIMPLEX,

                        0.6,

                        box_color,

                        2

                    )


            # =================================================
            # SIMPAN STATISTIK REALTIME
            # =================================================

            total_detections = (
                with_helmet
                + without_helmet
            )

            with cctv_lock:

                cctv_state[
                    "fps"
                ] = float(fps)

                cctv_state[
                    "with_helmet"
                ] = int(with_helmet)

                cctv_state[
                    "without_helmet"
                ] = int(without_helmet)

                cctv_state[
                    "total"
                ] = int(total_detections)


            # =================================================
            # INFO PANEL
            # =================================================

            cv2.rectangle(

                frame,

                (10, 10),

                (350, 115),

                (0, 0, 0),

                -1

            )


            cv2.putText(

                frame,

                f"With Helmet: {with_helmet}",

                (20, 40),

                cv2.FONT_HERSHEY_SIMPLEX,

                0.7,

                (0, 255, 0),

                2

            )


            cv2.putText(

                frame,

                f"Without Helmet: {without_helmet}",

                (20, 70),

                cv2.FONT_HERSHEY_SIMPLEX,

                0.7,

                (0, 0, 255),

                2

            )


            cv2.putText(

                frame,

                f"FPS: {fps:.1f}",

                (20, 100),

                cv2.FONT_HERSHEY_SIMPLEX,

                0.7,

                (255, 255, 255),

                2

            )


            # =================================================
            # ENCODE JPEG
            # =================================================

            success, buffer_jpg = (

                cv2.imencode(

                    ".jpg",

                    frame,

                    [

                        int(

                            cv2.IMWRITE_JPEG_QUALITY

                        ),

                        85

                    ]

                )

            )


            if not success:

                continue


            frame_bytes = (

                buffer_jpg.tobytes()

            )


            # =================================================
            # SEND FRAME
            # =================================================

            yield (

                b"--frame\r\n"

                b"Content-Type: image/jpeg\r\n\r\n"

                +

                frame_bytes

                +

                b"\r\n"

            )


    except Exception as e:

        print(

            "Error generate CCTV:",

            e

        )


    finally:

        # =====================================================
        # CLOSE FFMPEG
        # =====================================================

        if process is not None:

            try:

                process.kill()

            except Exception:

                pass


            try:

                process.wait(
                    timeout=2
                )

            except Exception:

                pass


        with cctv_lock:

            cctv_state[
                "connected"
            ] = False


# =========================================================
# REALTIME CCTV STATS
# =========================================================

@app.get("/cctv/stats")
def cctv_stats():

    with cctv_lock:

        return {
            "success": True,
            "connected": bool(
                cctv_state["connected"]
            ),
            "fps": round(
                float(cctv_state["fps"]),
                2
            ),
            "with_helmet": int(
                cctv_state["with_helmet"]
            ),
            "without_helmet": int(
                cctv_state["without_helmet"]
            ),
            "total": int(
                cctv_state["total"]
            )
        }


# =========================================================
# DISCONNECT CCTV
# =========================================================

@app.post("/cctv/disconnect")
def disconnect_cctv():

    with cctv_lock:

        cctv_state[
            "stop"
        ] = True


        cctv_state[
            "connected"
        ] = False


        cctv_state[
            "url"
        ] = None


        cctv_state[
            "original_url"
        ] = None


        cctv_state[
            "source_type"
        ] = "direct"


        cctv_state[
            "headers"
        ] = {}


        cctv_state[
            "fps"
        ] = 0.0

        cctv_state[
            "with_helmet"
        ] = 0

        cctv_state[
            "without_helmet"
        ] = 0

        cctv_state[
            "total"
        ] = 0


    return {

        "success": True,

        "message":
            "CCTV berhasil diputuskan."

    }
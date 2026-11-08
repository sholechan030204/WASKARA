from fastapi import FastAPI, UploadFile, File
from fastapi.responses import JSONResponse, StreamingResponse
from fastapi.middleware.cors import CORSMiddleware

from ultralytics import YOLO

import cv2
import numpy as np
import os
import uuid
import time
import threading


# =========================================================
# FASTAPI
# =========================================================

app = FastAPI(
    title="WASKARA YOLOv11 API",
    description="API deteksi helm menggunakan YOLOv11",
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
# PATH
# =========================================================

BASE_DIR = os.path.dirname(
    os.path.abspath(__file__)
)

MODEL_PATH = os.path.join(
    BASE_DIR,
    "best.pt"
)

VIDEO_DIR = os.path.join(
    BASE_DIR,
    "videos"
)

os.makedirs(
    VIDEO_DIR,
    exist_ok=True
)


# =========================================================
# LOAD MODEL
# =========================================================

try:

    model = YOLO(
        MODEL_PATH
    )

    print(
        "========================================"
    )

    print(
        "Model YOLOv11 berhasil dimuat."
    )

    print(
        "Class:",
        model.names
    )

    print(
        "========================================"
    )

except Exception as e:

    print(
        "GAGAL MEMUAT MODEL YOLOv11:"
    )

    print(e)

    raise


# =========================================================
# VIDEO STORAGE
# =========================================================

videos = {}

videos_lock = threading.Lock()

# =========================================================
# HOME / TEST API
# =========================================================

@app.get("/")
def home():

    return {

        "success": True,

        "message":
            "WASKARA YOLOv11 API aktif",

        "model":
            "YOLOv11",

        "classes":
            model.names

    }


# =========================================================
# WEBCAM / IMAGE DETECTION
# =========================================================

@app.post("/detect")
async def detect(
    file: UploadFile = File(...)
):

    try:

        # -------------------------------------------------
        # BACA FILE
        # -------------------------------------------------

        contents = await file.read()

        if not contents:

            return JSONResponse(

                status_code=400,

                content={

                    "success":
                        False,

                    "message":
                        "File kosong."

                }

            )

        # -------------------------------------------------
        # UBAH KE NUMPY
        # -------------------------------------------------

        np_array = np.frombuffer(
            contents,
            np.uint8
        )

        # -------------------------------------------------
        # DECODE GAMBAR
        # -------------------------------------------------

        frame = cv2.imdecode(
            np_array,
            cv2.IMREAD_COLOR
        )

        if frame is None:

            return JSONResponse(

                status_code=400,

                content={

                    "success":
                        False,

                    "message":
                        "File gambar tidak dapat dibaca."

                }

            )

        # -------------------------------------------------
        # YOLO DETECTION
        # -------------------------------------------------

        results = model(

            frame,

            conf=0.50,

            imgsz=640,

            verbose=False

        )

        detections = []

        # -------------------------------------------------
        # BACA HASIL DETEKSI
        # -------------------------------------------------

        for result in results:

            if result.boxes is None:

                continue

            for box in result.boxes:

                # Bounding box

                x1, y1, x2, y2 = (
                    box.xyxy[0].tolist()
                )

                # Confidence

                confidence = float(
                    box.conf[0]
                )

                # Class ID

                class_id = int(
                    box.cls[0]
                )

                # Class name

                class_name = (
                    model.names[class_id]
                )

                detections.append({

                    "class_name":
                        class_name,

                    "confidence":
                        round(
                            confidence,
                            4
                        ),

                    "x1":
                        round(
                            x1,
                            2
                        ),

                    "y1":
                        round(
                            y1,
                            2
                        ),

                    "x2":
                        round(
                            x2,
                            2
                        ),

                    "y2":
                        round(
                            y2,
                            2
                        )

                })

        # -------------------------------------------------
        # RESPONSE
        # -------------------------------------------------

        return {

            "success":
                True,

            "message":
                "Deteksi berhasil.",

            "total_detections":
                len(detections),

            "detections":
                detections

        }

    except Exception as e:

        print(
            "ERROR /detect:",
            e
        )

        return JSONResponse(

            status_code=500,

            content={

                "success":
                    False,

                "message":
                    str(e)

            }

        )


# =========================================================
# VIDEO UPLOAD
# =========================================================

@app.post("/video/upload")
async def upload_video(
    file: UploadFile = File(...)
):

    try:

        # -------------------------------------------------
        # VALIDASI NAMA FILE
        # -------------------------------------------------

        if not file.filename:

            return JSONResponse(

                status_code=400,

                content={

                    "success":
                        False,

                    "message":
                        "Nama video tidak ditemukan."

                }

            )

        # -------------------------------------------------
        # BUAT ID VIDEO
        # -------------------------------------------------

        video_id = str(
            uuid.uuid4()
        )

        # -------------------------------------------------
        # EXTENSION
        # -------------------------------------------------

        extension = os.path.splitext(
            file.filename
        )[1]

        if not extension:

            extension = ".mp4"

        filename = (
            video_id +
            extension
        )

        video_path = os.path.join(
            VIDEO_DIR,
            filename
        )

        # -------------------------------------------------
        # SIMPAN VIDEO
        # -------------------------------------------------

        contents = await file.read()

        if not contents:

            return JSONResponse(

                status_code=400,

                content={

                    "success":
                        False,

                    "message":
                        "Video kosong."

                }

            )

        with open(
            video_path,
            "wb"
        ) as f:

            f.write(
                contents
            )

        # -------------------------------------------------
        # BUKA VIDEO
        # -------------------------------------------------

        cap = cv2.VideoCapture(
            video_path
        )

        if not cap.isOpened():

            if os.path.exists(
                video_path
            ):

                os.remove(
                    video_path
                )

            return JSONResponse(

                status_code=400,

                content={

                    "success":
                        False,

                    "message":
                        "Video tidak dapat dibuka."

                }

            )

        # -------------------------------------------------
        # INFORMASI VIDEO
        # -------------------------------------------------

        width = int(
            cap.get(
                cv2.CAP_PROP_FRAME_WIDTH
            )
        )

        height = int(
            cap.get(
                cv2.CAP_PROP_FRAME_HEIGHT
            )
        )

        fps = cap.get(
            cv2.CAP_PROP_FPS
        )

        total_frames = int(
            cap.get(
                cv2.CAP_PROP_FRAME_COUNT
            )
        )

        cap.release()

        # -------------------------------------------------
        # DEFAULT FPS
        # -------------------------------------------------

        if fps <= 0:

            fps = 30

        # -------------------------------------------------
        # SIMPAN DATA VIDEO
        # -------------------------------------------------

        with videos_lock:

            videos[video_id] = {

                "id":
                    video_id,

                "filename":
                    file.filename,

                "path":
                    video_path,

                "width":
                    width,

                "height":
                    height,

                "fps":
                    fps,

                "total_frames":
                    total_frames,

                "status":
                    "ready",

                "with_helmet":
                    0,

                "without_helmet":
                    0,

                "current_fps":
                    0,

                "frame_count":
                    0,

                "started":
                    False,

                "finished":
                    False,

                "stop":
                    False

            }

        print(
            "Video berhasil diupload:",
            file.filename
        )

        return {

            "success":
                True,

            "message":
                "Video berhasil diupload.",

            "video_id":
                video_id,

            "filename":
                file.filename,

            "width":
                width,

            "height":
                height,

            "fps":
                fps,

            "total_frames":
                total_frames

        }

    except Exception as e:

        print(
            "ERROR /video/upload:",
            e
        )

        return JSONResponse(

            status_code=500,

            content={

                "success":
                    False,

                "message":
                    str(e)

            }

        )


# =========================================================
# VIDEO STREAM
# =========================================================

@app.get(
    "/video/stream/{video_id}"
)
def video_stream(
    video_id: str
):

    with videos_lock:

        video = videos.get(
            video_id
        )

        if video is None:

            return JSONResponse(

                status_code=404,

                content={

                    "success":
                        False,

                    "message":
                        "Video tidak ditemukan."

                }

            )

        video["started"] = True

        video["status"] = (
            "detecting"
        )

        video["stop"] = False

        video["finished"] = False

        video_path = video["path"]

    return StreamingResponse(

        generate_video(
            video_id,
            video_path
        ),

        media_type=(
            "multipart/"
            "x-mixed-replace; "
            "boundary=frame"
        )

    )


# =========================================================
# GENERATE VIDEO
# =========================================================

def generate_video(
    video_id,
    video_path
):

    # -----------------------------------------------------
    # OPEN VIDEO
    # -----------------------------------------------------

    cap = cv2.VideoCapture(
        video_path
    )

    if not cap.isOpened():

        with videos_lock:

            if video_id in videos:

                videos[
                    video_id
                ][
                    "status"
                ] = "error"

        return

    # -----------------------------------------------------
    # SOURCE FPS
    # -----------------------------------------------------

    source_fps = cap.get(
        cv2.CAP_PROP_FPS
    )

    if source_fps <= 0:

        source_fps = 30

    frame_time = (
        1.0 /
        source_fps
    )

    last_time = time.time()

    # =====================================================
    # LOOP FRAME
    # =====================================================

    while True:

        # -------------------------------------------------
        # CEK STOP
        # -------------------------------------------------

        with videos_lock:

            if video_id not in videos:

                break

            if videos[
                video_id
            ][
                "stop"
            ]:

                break

        # -------------------------------------------------
        # BACA FRAME
        # -------------------------------------------------

        success, frame = (
            cap.read()
        )

        if not success:

            break

        # =================================================
        # YOLO INFERENCE
        # =================================================

        start_inference = (
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
            start_inference
        )

        # =================================================
        # FPS
        # =================================================

        current_fps = 0

        if inference_time > 0:

            current_fps = (
                1 /
                inference_time
            )

        # =================================================
        # COUNTER FRAME SAAT INI
        #
        # PENTING:
        # BUKAN MENJUMLAHKAN SEMUA FRAME
        # =================================================

        current_with_helmet = 0

        current_without_helmet = 0

        # =================================================
        # DETECTION
        # =================================================

        for result in results:

            if result.boxes is None:

                continue

            for box in result.boxes:

                # -------------------------------------------------
                # KOORDINAT
                # -------------------------------------------------

                x1, y1, x2, y2 = (
                    box.xyxy[0].tolist()
                )

                # -------------------------------------------------
                # CONFIDENCE
                # -------------------------------------------------

                confidence = float(
                    box.conf[0]
                )

                # -------------------------------------------------
                # CLASS ID
                # -------------------------------------------------

                class_id = int(
                    box.cls[0]
                )

                # -------------------------------------------------
                # CLASS NAME
                # -------------------------------------------------

                class_name = (
                    model.names[
                        class_id
                    ]
                )

                # =================================================
                # HITUNG OBJEK PADA FRAME INI
                # =================================================

                if class_name == "With_helmet":

                    current_with_helmet += 1

                elif class_name == "without_helmet":

                    current_without_helmet += 1

                # =================================================
                # WARNA BOUNDING BOX
                # =================================================

                if class_name == "With_helmet":

                    box_color = (
                        0,
                        200,
                        0
                    )

                else:

                    box_color = (
                        0,
                        0,
                        255
                    )

                # =================================================
                # BOUNDING BOX
                # =================================================

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

                # =================================================
                # LABEL
                # =================================================

                label = (
                    f"{class_name} "
                    f"{confidence * 100:.1f}%"
                )

                (
                    text_width,
                    text_height
                ), _ = cv2.getTextSize(

                    label,

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.7,

                    2

                )

                label_y = max(

                    int(y1) - 10,

                    text_height + 10

                )

                # -------------------------------------------------
                # LABEL BACKGROUND
                # -------------------------------------------------

                cv2.rectangle(

                    frame,

                    (
                        int(x1),

                        label_y
                        -
                        text_height
                        -
                        10
                    ),

                    (
                        int(x1)
                        +
                        text_width
                        +
                        10,

                        label_y
                    ),

                    box_color,

                    -1

                )

                # -------------------------------------------------
                # TEXT
                # -------------------------------------------------

                cv2.putText(

                    frame,

                    label,

                    (
                        int(x1) + 5,

                        label_y - 5
                    ),

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.7,

                    (
                        255,
                        255,
                        255
                    ),

                    2

                )

        # =================================================
        # UPDATE STATISTIK
        #
        # ANGKA SEKARANG = OBJEK PADA FRAME SAAT INI
        # =================================================

        with videos_lock:

            if video_id in videos:

                videos[
                    video_id
                ][
                    "with_helmet"
                ] = (
                    current_with_helmet
                )

                videos[
                    video_id
                ][
                    "without_helmet"
                ] = (
                    current_without_helmet
                )

                videos[
                    video_id
                ][
                    "current_fps"
                ] = round(

                    current_fps,

                    1

                )

                videos[
                    video_id
                ][
                    "frame_count"
                ] += 1

        # =================================================
        # ENCODE JPEG
        # =================================================

        success, buffer = (
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
            buffer.tobytes()
        )

        # =================================================
        # STREAM FRAME
        # =================================================

        yield (

            b"--frame\r\n"

            b"Content-Type: "
            b"image/jpeg\r\n\r\n"

            +
            frame_bytes

            +
            b"\r\n"

        )

        # =================================================
        # JAGA KECEPATAN VIDEO
        # =================================================

        elapsed = (
            time.time()
            -
            last_time
        )

        sleep_time = (
            frame_time
            -
            elapsed
        )

        if sleep_time > 0:

            time.sleep(
                sleep_time
            )

        last_time = time.time()

    # =====================================================
    # SELESAI
    # =====================================================

    cap.release()

    with videos_lock:

        if video_id in videos:

            if videos[
                video_id
            ][
                "stop"
            ]:

                videos[
                    video_id
                ][
                    "status"
                ] = "stopped"

            else:

                videos[
                    video_id
                ][
                    "status"
                ] = "completed"

            videos[
                video_id
            ][
                "finished"
            ] = True


# =========================================================
# VIDEO STATS
# =========================================================

@app.get(
    "/video/stats/{video_id}"
)
def video_stats(
    video_id: str
):

    with videos_lock:

        video = videos.get(
            video_id
        )

        if video is None:

            return JSONResponse(

                status_code=404,

                content={

                    "success":
                        False,

                    "message":
                        "Video tidak ditemukan."

                }

            )

        return {

            "success":
                True,

            "status":
                video[
                    "status"
                ],

            "with_helmet":
                video[
                    "with_helmet"
                ],

            "without_helmet":
                video[
                    "without_helmet"
                ],

            "fps":
                video[
                    "current_fps"
                ],

            "frame_count":
                video[
                    "frame_count"
                ],

            "total_frames":
                video[
                    "total_frames"
                ]

        }


# =========================================================
# DELETE / STOP VIDEO
# =========================================================

@app.delete(
    "/video/{video_id}"
)
def delete_video(
    video_id: str
):

    with videos_lock:

        video = videos.get(
            video_id
        )

        if video is None:

            return {

                "success":
                    True,

                "message":
                    "Video sudah tidak ada."

            }

        # -------------------------------------------------
        # STOP STREAM
        # -------------------------------------------------

        video[
            "stop"
        ] = True

        video[
            "status"
        ] = "stopped"

        video_path = (
            video[
                "path"
            ]
        )

    # -----------------------------------------------------
    # HAPUS FILE VIDEO
    # -----------------------------------------------------

    try:

        if os.path.exists(
            video_path
        ):

            os.remove(
                video_path
            )

    except Exception as e:

        print(
            "Gagal menghapus video:",
            e
        )

    # -----------------------------------------------------
    # HAPUS DATA
    # -----------------------------------------------------

    with videos_lock:

        videos.pop(
            video_id,
            None
        )

    return {

        "success":
            True,

        "message":
            "Video dihentikan dan dihapus."

    }
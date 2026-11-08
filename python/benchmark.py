from ultralytics import YOLO
import cv2
import time
import os

# =========================================================
# KONFIGURASI
# =========================================================

MODEL_PATH = "python/best.pt"

# Gunakan gambar dari dataset untuk pengujian
IMAGE_PATH = "python/test.jpg"

# Jumlah pengujian
WARMUP_RUNS = 10
BENCHMARK_RUNS = 100

# Confidence
CONFIDENCE = 0.50


# =========================================================
# CEK FILE
# =========================================================

if not os.path.exists(MODEL_PATH):
    print("ERROR: Model tidak ditemukan:")
    print(MODEL_PATH)
    raise SystemExit

if not os.path.exists(IMAGE_PATH):
    print("ERROR: Gambar pengujian tidak ditemukan:")
    print(IMAGE_PATH)
    print()
    print("Silakan masukkan satu gambar JPG/PNG")
    print("ke folder python dengan nama:")
    print("test.jpg")
    raise SystemExit


# =========================================================
# LOAD MODEL
# =========================================================

print("=" * 60)
print("YOLOv11 INFERENCE SPEED BENCHMARK")
print("=" * 60)

print()
print("Memuat model...")

model = YOLO(MODEL_PATH)

print("Model berhasil dimuat.")
print("Class:", model.names)


# =========================================================
# LOAD IMAGE
# =========================================================

frame = cv2.imread(IMAGE_PATH)

if frame is None:
    print()
    print("ERROR: Gambar tidak dapat dibaca.")
    raise SystemExit

print()
print("Ukuran gambar:")
print(
    f"{frame.shape[1]} x {frame.shape[0]}"
)


# =========================================================
# WARM-UP
# =========================================================

print()
print("Melakukan warm-up...")

for _ in range(WARMUP_RUNS):

    model.predict(
        source=frame,
        conf=CONFIDENCE,
        verbose=False
    )

print("Warm-up selesai.")


# =========================================================
# BENCHMARK
# =========================================================

print()
print(
    f"Melakukan pengujian sebanyak "
    f"{BENCHMARK_RUNS} kali..."
)

times = []

for i in range(BENCHMARK_RUNS):

    start_time = time.perf_counter()

    model.predict(
        source=frame,
        conf=CONFIDENCE,
        verbose=False
    )

    end_time = time.perf_counter()

    elapsed = end_time - start_time

    times.append(elapsed)


# =========================================================
# HASIL
# =========================================================

total_time = sum(times)

average_time = total_time / len(times)

min_time = min(times)

max_time = max(times)

fps = 1 / average_time

average_ms = average_time * 1000

min_ms = min_time * 1000

max_ms = max_time * 1000


# =========================================================
# OUTPUT
# =========================================================

print()
print("=" * 60)
print("HASIL BENCHMARK")
print("=" * 60)

print()

print(
    f"Jumlah pengujian     : "
    f"{BENCHMARK_RUNS}"
)

print(
    f"Rata-rata inference  : "
    f"{average_ms:.2f} ms/frame"
)

print(
    f"Inference tercepat   : "
    f"{min_ms:.2f} ms/frame"
)

print(
    f"Inference terlambat  : "
    f"{max_ms:.2f} ms/frame"
)

print(
    f"FPS model             : "
    f"{fps:.2f} FPS"
)

print()

print("=" * 60)
print("SELESAI")
print("=" * 60)
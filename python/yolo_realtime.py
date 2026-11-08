import cv2
from ultralytics import YOLO

# Load model YOLOv11
model = YOLO(r"python\best.pt")

print("Model YOLOv11 berhasil dimuat!")
print("Class:", model.names)

# Buka webcam
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("Webcam tidak dapat dibuka!")
    exit()

print("Webcam berhasil dibuka!")
print("Tekan Q untuk keluar.")

while True:
    ret, frame = cap.read()

    if not ret:
        print("Frame webcam tidak dapat dibaca!")
        break

    # Deteksi YOLO
    results = model(
    frame,
    conf=0.65,
    verbose=False
)

    # Tampilkan hasil deteksi
    annotated_frame = results[0].plot()

    cv2.imshow(
        "WASKARA - YOLOv11 Helmet Detection",
        annotated_frame
    )

    # Tekan Q untuk keluar
    if cv2.waitKey(1) & 0xFF == ord("q"):
        break

cap.release()
cv2.destroyAllWindows()

print("Program selesai.")
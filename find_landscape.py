from PIL import Image
import os

folder = 'wp-content/themes/rashtrotthana/assets/images/client/'
for filename in os.listdir(folder):
    if filename.lower().endswith(('.png', '.jpg', '.jpeg')):
        try:
            with Image.open(os.path.join(folder, filename)) as img:
                w, h = img.size
                if w > h:
                    print(f"{filename}: {w}x{h} (Landscape)")
        except Exception as e:
            pass

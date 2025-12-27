# Image Translation (Image to Text OCR)

Simple PHP + Bootstrap front-end that uses Tesseract.js in the browser to extract text from images.

- Supports batching multiple images at once; results are separated in the output box.
- Additional OCR languages available: English, Spanish, French, German, Italian, Portuguese, Hindi, and Simplified Chinese (more can be added via Tesseract data).
- OCR formatting is tuned to preserve spacing with a 300 DPI hint for improved fidelity.

## Getting started

1. Install PHP (any 8.x runtime is fine).
2. From the project root, start a local server:

   ```bash
   php -S localhost:8000
   ```

3. Open [http://localhost:8000](http://localhost:8000) in your browser.
4. Choose an image (PNG, JPG, JPEG, GIF, BMP, TIFF) and click **Extract Text** to run OCR fully on the client.

Processing stays in your browser—no images are uploaded to the server. The result can be copied or downloaded as a `.txt` file.

Tesseract.js worker/core assets are bundled locally in `assets/tesseract`. Language data is fetched by Tesseract.js as needed (defaults to English).

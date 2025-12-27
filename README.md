# Image Translation (Image to Text OCR)

Simple PHP + Bootstrap front-end that uses Tesseract.js in the browser to extract text from images.

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

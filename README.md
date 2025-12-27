# Image Translation (Image to Text OCR)

Simple Bootstrap front-end that uses Tesseract.js in the browser to extract text from images. You can serve it with PHP's built-in server or any static host.

- Supports batching multiple images at once; results are separated in the output box.
- Additional OCR languages available: English, Spanish, French, German, Italian, Portuguese, Hindi, and Simplified Chinese (more can be added via Tesseract data).
- OCR formatting is tuned to preserve spacing with a 300 DPI hint for improved fidelity.
- Client-side only: images never leave the browser.

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

## Advanced Tesseract.js options

The app sets a few defaults for accuracy:

- `preserve_interword_spaces: 1` keeps layout spacing.
- `tessedit_pageseg_mode: 3` uses automatic page segmentation.
- `user_defined_dpi: 300` hints a higher DPI for cleaner text.

Other useful options you can enable for specific scenarios:

- `oem`: choose the OCR engine mode (e.g., `1` for LSTM only).
- `tessedit_char_whitelist` / `tessedit_char_blacklist`: restrict or exclude characters for cleaner results.
- `tessedit_pageseg_mode`: switch PSM (e.g., `6` for uniform block of text, `13` for raw line).
- `dpi` or `user_defined_dpi`: increase for low-resolution scans.
- `workerPath`, `corePath`, `langPath`: point to self-hosted assets for offline use.
- `cachePath`: reuse language data between runs.
- `numWorkers` with the Tesseract.js `createScheduler` API: process multiple images in parallel when batching is large.

Example (multi-worker batching):

```js
import { createWorker, createScheduler } from 'tesseract.js';

const scheduler = createScheduler();
const workerCount = navigator.hardwareConcurrency
  ? Math.min(4, navigator.hardwareConcurrency) // cap to avoid overwhelming the CPU/system
  : 2;

for (let i = 0; i < workerCount; i++) {
  const worker = await createWorker({ workerPath, corePath, langPath, logger });
  await worker.loadLanguage('eng');
  await worker.initialize('eng');
  scheduler.addWorker(worker);
}

const jobs = files.map((file) => scheduler.addJob('recognize', file, { tessedit_pageseg_mode: 6 }));
const results = await Promise.all(jobs);
await scheduler.terminate();
```

> This sample uses the ESM build of `tesseract.js` (via a bundler or `<script type="module">`). When using the CDN build already present in this project, access the same APIs via `Tesseract.createWorker` and `Tesseract.createScheduler`.

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidance on running the project locally and submitting improvements.

<?php
$appName = 'Image to Text';
$year = date('Y');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($appName); ?> | OCR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="min-vh-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
      <div class="container">
        <span class="navbar-brand fw-semibold"><?php echo htmlspecialchars($appName); ?> OCR</span>
        <span class="navbar-text small text-white-50">Client-side image to text with Tesseract.js</span>
      </div>
    </nav>

    <main class="container py-5">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h1 class="h4 mb-3">Upload an image</h1>
              <p class="text-muted small mb-4">Supported formats: PNG, JPG, JPEG, GIF, BMP, TIFF. Processing happens in your browser—no files are uploaded to the server.</p>
              <div class="mb-3">
                <label for="imageInput" class="form-label fw-semibold">Choose image</label>
                <input class="form-control" type="file" id="imageInput" accept="image/*">
              </div>
              <div class="mb-3">
                <label for="languageSelect" class="form-label fw-semibold">Language</label>
                <select class="form-select" id="languageSelect">
                  <option value="eng" selected>English (eng)</option>
                  <option value="spa">Spanish (spa)</option>
                </select>
                <div class="form-text">Select the OCR language.</div>
              </div>
              <div id="previewArea" class="border border-dashed rounded p-3 text-center bg-white">
                <p class="text-muted mb-2" id="placeholderText">No image selected yet.</p>
                <img id="previewImage" class="img-fluid d-none rounded shadow-sm" alt="Preview">
              </div>
              <div class="d-flex flex-wrap gap-2 mt-4">
                <button id="extractBtn" class="btn btn-primary" disabled>
                  <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                  Extract Text
                </button>
                <button id="clearBtn" class="btn btn-outline-secondary">Clear</button>
              </div>
              <div class="progress mt-3 d-none" id="progressWrapper" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar" style="width: 0%;"></div>
              </div>
              <div class="text-muted small mt-2" id="statusText"></div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <div class="d-flex align-items-center mb-3">
                <h2 class="h4 mb-0">Extracted text</h2>
                <span class="badge bg-info-subtle text-info-emphasis ms-2">Tesseract.js</span>
              </div>
              <textarea id="resultText" class="form-control flex-grow-1 mb-3" rows="10" readonly placeholder="Your extracted text will appear here"></textarea>
              <div class="d-flex flex-wrap gap-2">
                <button id="copyBtn" class="btn btn-outline-primary" disabled>Copy</button>
                <button id="downloadBtn" class="btn btn-outline-success" disabled>Download</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="py-3 text-center text-muted small">
      &copy; <?php echo $year; ?> <?php echo htmlspecialchars($appName); ?> OCR. Powered by Bootstrap &amp; Tesseract.js.
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="assets/tesseract/tesseract.min.js"></script>
  <script>
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const placeholderText = document.getElementById('placeholderText');
    const extractBtn = document.getElementById('extractBtn');
    const clearBtn = document.getElementById('clearBtn');
    const progressWrapper = document.getElementById('progressWrapper');
    const progressBar = document.getElementById('progressBar');
    const statusText = document.getElementById('statusText');
    const resultText = document.getElementById('resultText');
    const copyBtn = document.getElementById('copyBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const languageSelect = document.getElementById('languageSelect');
    const workerPath = 'assets/tesseract/worker.min.js';
    const corePath = 'assets/tesseract/tesseract-core.wasm.js';

    function resetUI() {
      imageInput.value = '';
      previewImage.src = '';
      previewImage.classList.add('d-none');
      placeholderText.classList.remove('d-none');
      extractBtn.disabled = true;
      progressWrapper.classList.add('d-none');
      progressBar.style.width = '0%';
      statusText.textContent = '';
      resultText.value = '';
      copyBtn.disabled = true;
      downloadBtn.disabled = true;
      loadingSpinner.classList.add('d-none');
    }

    function updateButtonsState() {
      const hasResult = resultText.value.trim().length > 0;
      copyBtn.disabled = !hasResult;
      downloadBtn.disabled = !hasResult;
    }

    function showPreview(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.src = e.target.result;
        previewImage.classList.remove('d-none');
        placeholderText.classList.add('d-none');
      };
      reader.onerror = () => {
        statusText.textContent = 'Unable to read the selected file. Please try another image.';
      };
      reader.readAsDataURL(file);
    }

    imageInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (!file) {
        resetUI();
        return;
      }
      showPreview(file);
      extractBtn.disabled = false;
      statusText.textContent = '';
    });

    extractBtn.addEventListener('click', async () => {
      const file = imageInput.files[0];
      if (!file) {
        statusText.textContent = 'Please select an image first.';
        return;
      }

      extractBtn.disabled = true;
      loadingSpinner.classList.remove('d-none');
      progressWrapper.classList.remove('d-none');
      statusText.textContent = 'Initializing...';

      try {
        const language = languageSelect.value || 'eng';
        const { data: { text } } = await Tesseract.recognize(file, language, {
          workerPath,
          corePath,
          logger: (m) => {
            if (!m || !m.status) return;
            if (m.status === 'recognizing text' && m.progress) {
              const percentage = Math.round(m.progress * 100);
              progressBar.style.width = `${percentage}%`;
              statusText.textContent = `Processing... ${percentage}%`;
            } else {
              statusText.textContent = m.status;
            }
          }
        });

        resultText.value = text.trim();
        statusText.textContent = text.trim() ? 'Done!' : 'No text detected.';
        updateButtonsState();
      } catch (error) {
        console.error(error);
        statusText.textContent = 'There was a problem reading the image. Please try another file.';
      } finally {
        extractBtn.disabled = false;
        loadingSpinner.classList.add('d-none');
        progressWrapper.classList.add('d-none');
        progressBar.style.width = '0%';
      }
    });

    clearBtn.addEventListener('click', resetUI);

    copyBtn.addEventListener('click', async () => {
      if (!navigator.clipboard) {
        statusText.textContent = 'Clipboard not available. Please copy the text manually.';
        return;
      }
      try {
        await navigator.clipboard.writeText(resultText.value);
        statusText.textContent = 'Copied to clipboard.';
      } catch (err) {
        statusText.textContent = 'Unable to copy. Please copy manually.';
      }
    });

    downloadBtn.addEventListener('click', () => {
      const blob = new Blob([resultText.value], { type: 'text/plain' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = 'ocr-result.txt';
      document.body.appendChild(link);
      link.click();
      link.remove();
      URL.revokeObjectURL(url);
      statusText.textContent = 'Download started.';
    });

    resetUI();
  </script>
</body>
</html>

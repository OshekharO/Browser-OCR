# 📄 Browser OCR — Private, Client-Side Text Extraction

A fast, privacy-first OCR web application that extracts text from images **entirely in the browser** using **Tesseract.js**.
No uploads. No tracking. No servers.

Designed with **performance, accessibility, and real-world UX** in mind.

---

## ✨ Features

* 🖼 **Multi-image OCR** (batch processing)
* 🌍 **Multiple languages** (English, Hindi, French, Spanish, German, Chinese)
* 🧩 **OCR presets** for different image types

  * Scanned documents
  * Screenshots / UI
  * Notes / handwriting
  * Camera photos
* ⚡ **Smart image downscaling** (optional, improves speed & memory usage)
* 📊 **Real progress bar** with percentage
* ⏱ **ETA (estimated time remaining)**
* ⏹ **Cancel OCR at any time**
* ♿ **Accessible** (ARIA live status, keyboard shortcuts)
* 🧹 **Memory-safe** (object URL cleanup, mobile-friendly)
* 📋 **Copy & download extracted text**

---

## 🔒 Privacy by Design

* All OCR runs **locally in your browser**
* Images are **never uploaded**
* No analytics, no cookies, no tracking

This makes it suitable for **sensitive documents**.

---

## 🧠 OCR Presets (Why They Matter)

Presets adjust preprocessing and expectations for different image types:

| Preset                 | Best For                       |
| ---------------------- | ------------------------------ |
| 📄 Scanned Document    | PDFs, printed pages            |
| 🖥 Screenshot / UI     | Apps, tables, code             |
| 📝 Notes / Handwriting | Class notes, rough writing     |
| 📸 Camera Photo        | Mobile photos, uneven lighting |

Presets also power **status messaging**, so users understand what’s happening.

---

## ⚡ Smart Image Downscaling

Large images (e.g. phone photos) are automatically resized before OCR.

* Improves speed (often 2–4× faster)
* Reduces memory usage
* Prevents mobile browser crashes
* Can be turned **ON/OFF** in Advanced settings

---

## ♿ Accessibility & UX

* `aria-live` status updates for screen readers
* Keyboard shortcuts:

  * **Enter** → Start OCR
  * **Esc** → Cancel OCR
  * **Ctrl / Cmd + C** → Copy result
* Clear progress + ETA to reduce perceived waiting time

---

## 🧹 Performance & Memory Safety

* Object URLs are revoked after use
* Image previews cleaned up after OCR
* No persistent workers or leaked references
* Safe for mobile and low-memory devices

---

## 🛠 Tech Stack

* **HTML5**
* **CSS3**
* **Bootstrap 5**
* **Vanilla JavaScript**
* **Tesseract.js (WebAssembly OCR)**

No frameworks. No build step. No backend.

---

## 🚀 Getting Started

### 1️⃣ Clone or download

```bash
git clone https://github.com/OshekharO/Browser-OCR.git
```

### 2️⃣ Open in browser

Just open `index.html` in any modern browser
(Chrome, Edge, Firefox, Safari)

That’s it.

---

## 📦 Deployment

This app can be hosted as **static files**:

* GitHub Pages
* Netlify
* Vercel
* Any static hosting

No server configuration required.

---

## ⚠️ Limitations

* OCR accuracy depends on image quality
* Handwritten text may be inconsistent
* Very large batches can be slow on low-end devices

These are limitations of **client-side OCR**, not the app itself.

---

## 🧪 Tested On

* Chrome (Desktop & Android)
* Edge
* Firefox
* Mobile Chrome (Android)

---

## 📄 License

MIT License
Free to use, modify, and distribute.

---

## 🧠 Design Philosophy

> “Do the simplest thing that works — and make it robust.”

This project prioritizes:

* Stability over cleverness
* User trust over features
* Privacy over convenience
* Predictable UX over magic

---

## ⭐ If You Use This

If this project helped you:

* ⭐ Star the repo
* 🧑‍💻 Fork and improve it

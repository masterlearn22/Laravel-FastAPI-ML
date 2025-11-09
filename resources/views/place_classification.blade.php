<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prediksi Mamalia - AI Classification</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('layouts/style.css') }}">
</head>

<body>
  <div class="container">
    <!-- HEADER -->
    <header>
      <h1>Prediksi Tempat</h1>
      <p class="subtitle">Identifikasi jenis tempat berdasarkan gambar menggunakan AI</p>
    </header>


    <!-- ERROR MESSAGES -->
    @if ($errors->any())
      <div class="errors show">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- MAIN FORM -->
    <form action="{{ route('place.predict') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-section">
        <div class="form-group">
          <label for="image">Upload Gambar</label>
          <div class="upload-area" id="uploadArea">
            <span class="upload-icon">📸</span>
            <div class="upload-text">Klik atau drag gambar ke sini</div>
            <div class="upload-hint">Dukung format: JPG, PNG (Max 10MB)</div>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg" required>
          </div>

          <div id="preview">
            <img id="previewImg" alt="Preview">
            <div class="preview-name" id="previewName"></div>
          </div>

          <div class="info-box">
            <strong>💡 Tips:</strong>
            Upload foto mamalia yang jelas dan terang untuk hasil terbaik. Hindari gambar blur atau terlalu gelap.
          </div>
        </div>

        <div class="button-group">
          <button type="submit" class="btn-primary" id="submitBtn">Prediksi Sekarang</button>
          <button type="reset" class="btn-secondary" id="resetBtn">Hapus</button>
        </div>

        <!-- ACTION BUTTONS -->
        <button type="button" class="btn btn-action" id="viewResultsBtn" @if (!isset($showResultButton))
        style="display:none;" @endif>
          📊 Lihat Hasil Prediksi
        </button>


        <button type="button" class="btn btn-action" id="viewHistoryBtn">
          📜 Lihat Riwayat Prediksi
        </button>
      </div>
  </div>
  </form>
  </div>

  <!-- MODAL: RESULTS -->
  <div class="modal" id="resultsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Hasil Prediksi</h2>
        <button class="btn-close" onclick="closeModal('resultsModal')">&times;</button>
      </div>
      <div class="modal-body">
        <div id="resultsContent"></div>
      </div>
    </div>
  </div>

  <!-- MODAL: HISTORY -->
  <div class="modal" id="historyModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Riwayat Prediksi</h2>
        <button class="btn-close" onclick="closeModal('historyModal')">&times;</button>
      </div>
      <div class="modal-body">
        <div id="historyContent"></div>
      </div>
    </div>
  </div>

  <script>
    // ===== UPLOAD HANDLING =====
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const resetBtn = document.getElementById('resetBtn');
    const viewResultsBtn = document.getElementById('viewResultsBtn');
    const viewHistoryBtn = document.getElementById('viewHistoryBtn');

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadArea.classList.add('active');
    });

    uploadArea.addEventListener('dragleave', () => {
      uploadArea.classList.remove('active');
    });

    uploadArea.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadArea.classList.remove('active');
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        imageInput.files = files;
        handleFileSelect();
      }
    });

    uploadArea.addEventListener('click', () => {
      imageInput.click();
    });

    imageInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
      const file = imageInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImg.src = e.target.result;
          previewName.textContent = file.name;
          preview.style.display = 'block';
          resetBtn.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
      }
    }

    document.querySelector('form').addEventListener('reset', () => {
      preview.style.display = 'none';
      resetBtn.style.display = 'none';
    });

    // ===== MODAL FUNCTIONS =====
    function openModal(modalId) {
      document.getElementById(modalId).classList.add('show');
    }

    function closeModal(modalId) {
      document.getElementById(modalId).classList.remove('show');
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          closeModal(modal.id);
        }
      });
    });

    // ===== RESULTS HANDLING =====
    viewResultsBtn.addEventListener('click', () => {
      const resultsContent = document.getElementById('resultsContent');

      @if(isset($result) && isset($image))
        resultsContent.innerHTML = `
            <div class="results-grid">
              <div class="image-section">
                <div class="image-frame">
                  <img src="data:image/jpeg;base64,{{ $image }}" alt="Gambar prediksi">
                </div>
              </div>
              <div class="predictions-section">
                <h3>Prediksi Utama</h3>
                <div class="main-prediction">
                  <div class="prediction-label">{{ $result['label'] }}</div>
                  <div class="confidence-bar">
                    <div class="confidence-label">
                      <span>Confidence Score</span>
                      <span>{{ number_format($result['confidence'] * 100, 2) }}%</span>
                    </div>
                    <div class="bar">
                      <div class="bar-fill" style="width: {{ $result['confidence'] * 100 }}%"></div>
                    </div>
                  </div>
                </div>

                <h3>Top 5 Predictions</h3>
                <ul class="top5-list">
                  @foreach ($result['top5_labels'] as $index => $label)
                    <li class="top5-item">
                      <span class="top5-label">{{ $label }}</span>
                      <span class="top5-prob">{{ number_format($result['top5_probs'][$index] * 100, 2) }}%</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          `;
      @endif

      openModal('resultsModal');
    });


    // ===== HISTORY HANDLING =====
    viewHistoryBtn.addEventListener('click', () => {
      const historyContent = document.getElementById('historyContent');

      @if (count($history) === 0)
        historyContent.innerHTML = `
                    <div class="empty-state">
                      <span class="empty-state-icon">📭</span>
                      <div class="empty-state-text">Belum ada riwayat prediksi</div>
                    </div>
                  `;
      @else
        historyContent.innerHTML = `
                    <table class="history-table">
                      <thead>
                        <tr>
                          <th>Gambar</th>
                          <th>Label</th>
                          <th>Confidence</th>
                          <th>Tanggal</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($history as $item)
                          <tr>
                            <td><img src="{{ asset('storage/' . $item->image_path) }}" width="100"></td>
                            <td>{{ $item->label }}</td>
                            <td>{{ number_format($item->confidence * 100, 2) }}%</td>
                            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  `;
      @endif

      openModal('historyModal');
    });

    @if (isset($showResultButton) && $showResultButton)
      viewResultsBtn.style.display = "inline-block";
    @endif

    // Show results button after successful prediction (if needed)
    // This would be set by your Laravel backend after form submission
  </script>
</body>

</html>
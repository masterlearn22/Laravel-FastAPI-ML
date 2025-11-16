<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Analisis Sentimen - AI</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('layouts/style.css') }}">
</head>

<body>
  <div class="container">

    <!-- HEADER -->
    <header>
      <h1>Sentiment Analysis for Films Review</h1>
      <p class="subtitle">Detect whether the sentence has a positive or negative sentiment</p>
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
    <form action="{{ route('sentiment.predict') }}" method="POST">
      @csrf
      <div class="form-section">
        <label for="text_input">Enter a sentence or review</label>
        <textarea name="text_input" id="text_input" rows="5"
          placeholder ="Write using English. Example: I really enjoyed the movie."
          required>{{ old('text_input') }}</textarea>

        <div class="button-group">
          <button type="submit" class="btn-primary" id="submitBtn">Predict Now</button>
          <button type="reset" class="btn-secondary" id="resetBtn">Clear</button>
        </div>

        <!-- ACTION BUTTONS -->
        <button type="button" class="btn btn-action" id="viewResultsBtn"
          @if (!isset($showResultButton)) style="display:none;" @endif>
          📊 Lihat Hasil Prediksi
        </button>

        <button type="button" class="btn btn-action" id="viewHistoryBtn">
          📜 Lihat Riwayat Prediksi
        </button>
      </div>
    </form>
  </div>

  <!-- MODAL: HASIL PREDIKSI -->
  <div class="modal" id="resultsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Hasil Prediksi Sentimen</h2>
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
    const viewResultsBtn = document.getElementById('viewResultsBtn');
    const viewHistoryBtn = document.getElementById('viewHistoryBtn');

    // ===== MODAL FUNCTIONS =====
    function openModal(modalId) {
      document.getElementById(modalId).classList.add('show');
    }

    function closeModal(modalId) {
      document.getElementById(modalId).classList.remove('show');
    }

    document.querySelectorAll('.modal').forEach(modal => {
      modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal(modal.id);
      });
    });

    // ===== RESULTS HANDLING =====
    viewResultsBtn.addEventListener('click', () => {
      const resultsContent = document.getElementById('resultsContent');

      @if(isset($result))
        resultsContent.innerHTML = `
          <div class="results-grid">

            <div class="predictions-section">
              <h3>Prediksi Sentimen</h3>

              <div class="main-prediction">
                <div class="prediction-label">{{ strtoupper($result['label']) }}</div>

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
            </div>

          </div>
        `;
      @endif

      openModal('resultsModal');
    });

    // ===== HISTORY HANDLING =====
    viewHistoryBtn.addEventListener('click', () => {
      const historyContent = document.getElementById('historyContent');

      @if (count($history ?? []) === 0)
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
                <th>Teks</th>
                <th>Label</th>
                <th>Confidence</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($history as $item)
                <tr>
                  <td>{{ $item->text }}</td>
                  <td>{{ $item->label }}</td>
                  <td>{{ round($item->confidence * 100, 2) }}%%</td>
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
  </script>

</body>
</html>

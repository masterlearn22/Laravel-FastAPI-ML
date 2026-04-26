import { useState, useRef } from 'react';

export default function Places({ onBack }) {
  const [image, setImage] = useState(null);
  const [preview, setPreview] = useState(null);
  const [isPredicting, setIsPredicting] = useState(false);
  const [result, setResult] = useState(null);
  const [showModal, setShowModal] = useState(false);
  const fileInputRef = useRef(null);

  const mockLabels = ['Forest', 'Mountain', 'Beach', 'City', 'Desert'];

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setImage(file);
      const reader = new FileReader();
      reader.onload = (e) => setPreview(e.target.result);
      reader.readAsDataURL(file);
      setResult(null);
    }
  };

  const handlePredict = (e) => {
    e.preventDefault();
    if (!image) return;

    setIsPredicting(true);
    
    setTimeout(() => {
      const mainLabel = mockLabels[Math.floor(Math.random() * mockLabels.length)];
      const confidence = (Math.random() * (0.99 - 0.7) + 0.7);
      
      const top5 = mockLabels.map(label => ({
        label,
        prob: label === mainLabel ? confidence : Math.random() * (1 - confidence)
      })).sort((a, b) => b.prob - a.prob).slice(0, 5);

      setResult({
        label: mainLabel,
        confidence: confidence,
        top5_labels: top5.map(t => t.label),
        top5_probs: top5.map(t => t.prob)
      });
      setIsPredicting(false);
      setShowModal(true);
    }, 1500);
  };

  const handleReset = () => {
    setImage(null);
    setPreview(null);
    setResult(null);
    if (fileInputRef.current) fileInputRef.current.value = '';
  };

  return (
    <div className="container">
      <button 
        onClick={onBack} 
        style={{ background: 'transparent', border: 'none', color: '#a1a1aa', cursor: 'pointer', marginBottom: '20px', display: 'flex', alignItems: 'center', gap: '8px', fontSize: '14px', fontWeight: '600' }}
      >
        &larr; Back to Models
      </button>
      <div className="form-section">
        <h2 style={{marginBottom: '10px'}}>Prediksi Tempat</h2>
        <p className="subtitle" style={{marginBottom: '20px'}}>Identifikasi pemandangan menggunakan AI (Mock Data)</p>
        
        <form onSubmit={handlePredict}>
          <div className="form-group">
            <label>Upload Gambar Tempat</label>
            <div 
              className="upload-area" 
              onClick={() => fileInputRef.current?.click()}
            >
              <span className="upload-icon">🏞️</span>
              <div className="upload-text">Klik untuk memilih gambar</div>
              <div className="upload-hint">Dukung format: JPG, PNG</div>
              <input 
                type="file" 
                ref={fileInputRef} 
                onChange={handleFileChange} 
                accept="image/jpeg,image/png,image/jpg" 
                style={{ display: 'none' }} 
              />
            </div>

            {preview && (
              <div id="preview" style={{ display: 'block', marginTop: '20px', textAlign: 'center' }}>
                <img src={preview} alt="Preview" style={{ maxWidth: '100%', maxHeight: '300px', borderRadius: '12px' }} />
                <div className="preview-name">{image?.name}</div>
              </div>
            )}
          </div>

          <div className="button-group">
            <button type="submit" className="btn-primary" disabled={!image || isPredicting}>
              {isPredicting ? 'Memproses...' : 'Prediksi Sekarang'}
            </button>
            {preview && (
              <button type="button" className="btn-secondary" onClick={handleReset} style={{ display: 'inline-block' }}>
                Hapus
              </button>
            )}
          </div>
          
          {result && (
            <button type="button" className="btn btn-action" onClick={() => setShowModal(true)} style={{ display: 'inline-block' }}>
              📊 Lihat Hasil Prediksi
            </button>
          )}
        </form>
      </div>

      {showModal && result && (
        <div className="modal show" onClick={() => setShowModal(false)}>
          <div className="modal-content" onClick={e => e.stopPropagation()}>
            <div className="modal-header">
              <h2>Hasil Prediksi (Mock)</h2>
              <button className="btn-close" onClick={() => setShowModal(false)}>&times;</button>
            </div>
            <div className="modal-body">
              <div className="results-grid">
                <div className="image-section">
                  <div className="image-frame">
                    <img src={preview} alt="Gambar prediksi" />
                  </div>
                </div>
                <div className="predictions-section">
                  <h3>Prediksi Utama</h3>
                  <div className="main-prediction">
                    <div className="prediction-label">{result.label}</div>
                    <div className="confidence-bar">
                      <div className="confidence-label">
                        <span>Confidence Score</span>
                        <span>{(result.confidence * 100).toFixed(2)}%</span>
                      </div>
                      <div className="bar">
                        <div className="bar-fill" style={{ width: `${result.confidence * 100}%` }}></div>
                      </div>
                    </div>
                  </div>

                  <h3>Top 5 Predictions</h3>
                  <ul className="top5-list">
                    {result.top5_labels.map((label, index) => (
                      <li className="top5-item" key={index}>
                        <span className="top5-label">{label}</span>
                        <span className="top5-prob">{(result.top5_probs[index] * 100).toFixed(2)}%</span>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

import { useState } from 'react';

export default function Sentiment({ onBack }) {
  const [text, setText] = useState('');
  const [isPredicting, setIsPredicting] = useState(false);
  const [result, setResult] = useState(null);
  const [showModal, setShowModal] = useState(false);

  const mockLabels = ['Positive', 'Negative', 'Neutral'];

  const handlePredict = (e) => {
    e.preventDefault();
    if (!text.trim()) return;

    setIsPredicting(true);
    
    setTimeout(() => {
      const mainLabel = mockLabels[Math.floor(Math.random() * mockLabels.length)];
      const confidence = (Math.random() * (0.99 - 0.7) + 0.7);

      setResult({
        label: mainLabel,
        confidence: confidence
      });
      setIsPredicting(false);
      setShowModal(true);
    }, 1000);
  };

  const handleReset = () => {
    setText('');
    setResult(null);
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
        <h2 style={{marginBottom: '10px'}}>Analisis Sentimen</h2>
        <p className="subtitle" style={{marginBottom: '20px'}}>Analisis teks menggunakan AI (Mock Data)</p>
        
        <form onSubmit={handlePredict}>
          <div className="form-group">
            <label>Masukkan Teks</label>
            <textarea 
              value={text}
              onChange={(e) => setText(e.target.value)}
              placeholder="Tulis opini atau review di sini..."
              rows={5}
              style={{
                width: '100%',
                padding: '15px',
                borderRadius: '8px',
                border: '1px solid var(--border)',
                backgroundColor: 'var(--bg-tertiary)',
                color: 'var(--text-primary)',
                fontFamily: 'inherit',
                resize: 'vertical'
              }}
              required
            />
          </div>

          <div className="button-group">
            <button type="submit" className="btn-primary" disabled={!text.trim() || isPredicting}>
              {isPredicting ? 'Memproses...' : 'Analisis Sekarang'}
            </button>
            {text && (
              <button type="button" className="btn-secondary" onClick={handleReset} style={{ display: 'inline-block' }}>
                Hapus
              </button>
            )}
          </div>
          
          {result && (
            <button type="button" className="btn btn-action" onClick={() => setShowModal(true)} style={{ display: 'inline-block' }}>
              📊 Lihat Hasil Analisis
            </button>
          )}
        </form>
      </div>

      {showModal && result && (
        <div className="modal show" onClick={() => setShowModal(false)}>
          <div className="modal-content" onClick={e => e.stopPropagation()} style={{ maxWidth: '500px' }}>
            <div className="modal-header">
              <h2>Hasil Analisis Sentimen</h2>
              <button className="btn-close" onClick={() => setShowModal(false)}>&times;</button>
            </div>
            <div className="modal-body">
              <div className="main-prediction" style={{ textAlign: 'center' }}>
                <div className="prediction-label" style={{ 
                  color: result.label === 'Positive' ? 'var(--success)' : result.label === 'Negative' ? '#ef4444' : 'var(--text-primary)' 
                }}>
                  {result.label}
                </div>
                <div className="confidence-bar">
                  <div className="confidence-label">
                    <span>Confidence Score</span>
                    <span>{(result.confidence * 100).toFixed(2)}%</span>
                  </div>
                  <div className="bar">
                    <div className="bar-fill" style={{ 
                      width: `${result.confidence * 100}%`,
                      background: result.label === 'Positive' ? 'var(--success)' : result.label === 'Negative' ? '#ef4444' : 'var(--text-primary)'
                    }}></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

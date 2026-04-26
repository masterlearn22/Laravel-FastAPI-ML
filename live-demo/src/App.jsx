import { useState } from 'react'
import Mammals from './components/Mammals'
import Places from './components/Places'
import Sentiment from './components/Sentiment'

function App() {
  const [activeTab, setActiveTab] = useState('mammals')

  return (
    <div>
      <header style={{ marginBottom: '20px', paddingTop: '40px' }}>
        <h1 style={{ textAlign: 'center' }}>ML Prediction Hub - Live Demo</h1>
        <p className="subtitle" style={{ textAlign: 'center' }}>
          Simulasi antarmuka (UI) dari aplikasi klasifikasi AI. Data hasil prediksi di-mock (simulasi).
        </p>
        <div style={{ display: 'flex', justifyContent: 'center', gap: '10px', marginTop: '20px' }}>
          <button 
            className={`btn ${activeTab === 'mammals' ? 'btn-primary' : 'btn-secondary'}`}
            style={{ display: 'inline-flex' }}
            onClick={() => setActiveTab('mammals')}
          >
            Mammals
          </button>
          <button 
            className={`btn ${activeTab === 'places' ? 'btn-primary' : 'btn-secondary'}`}
            style={{ display: 'inline-flex' }}
            onClick={() => setActiveTab('places')}
          >
            Places
          </button>
          <button 
            className={`btn ${activeTab === 'sentiment' ? 'btn-primary' : 'btn-secondary'}`}
            style={{ display: 'inline-flex' }}
            onClick={() => setActiveTab('sentiment')}
          >
            Sentiment
          </button>
        </div>
      </header>

      <main>
        {activeTab === 'mammals' && <Mammals />}
        {activeTab === 'places' && <Places />}
        {activeTab === 'sentiment' && <Sentiment />}
      </main>
    </div>
  )
}

export default App

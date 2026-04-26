import React from 'react';
import { BarChart2, Target, TrendingUp, Zap, CheckCircle } from 'lucide-react';

export default function Dashboard({ onSelectModel }) {
  return (
    <div className="dashboard-container">
      {/* Top Nav Pills */}
      <div className="top-nav-pills">
        <button className="nav-pill active">
          <BarChart2 size={16} style={{marginRight: '8px'}} /> CLASSIFICATION
        </button>
        <button className="nav-pill">
          <Target size={16} style={{marginRight: '8px', color: '#ec4899'}} /> CLUSTERING
        </button>
        <button className="nav-pill">
          <TrendingUp size={16} style={{marginRight: '8px', color: '#6366f1'}} /> REGRESSION
        </button>
      </div>

      {/* Header Banner */}
      <div className="header-banner">
        <h1 className="gradient-text">Classification Models</h1>
        <p className="subtitle">Predict categorical outcomes using advanced neural networks</p>
      </div>

      {/* Model Cards */}
      <div className="model-cards-grid">
        {/* Mammals Card */}
        <div className="model-card">
          <div className="model-badge">CNN MODEL</div>
          <div className="model-icon">🐾</div>
          <h3>Mammals Detection</h3>
          <p>Identify and classify different mammal species using EfficientNetB0 architecture with high accuracy.</p>
          <button className="explore-btn" onClick={() => onSelectModel('mammals')}>
            EXPLORE MODEL &rarr;
          </button>
        </div>

        {/* Places Card */}
        <div className="model-card">
          <div className="model-badge">CNN MODEL</div>
          <div className="model-icon">🏞️</div>
          <h3>Place Classification</h3>
          <p>Classify images into location categories using ResNet50 for robust feature extraction.</p>
          <button className="explore-btn" onClick={() => onSelectModel('places')}>
            EXPLORE MODEL &rarr;
          </button>
        </div>

        {/* Sentiment Card */}
        <div className="model-card">
          <div className="model-badge" style={{ backgroundColor: 'rgba(99, 102, 241, 0.15)', color: '#818cf8', borderColor: 'rgba(99, 102, 241, 0.3)' }}>HYBRID MODEL</div>
          <div className="model-icon">💬</div>
          <h3>Sentiment Analysis</h3>
          <p>Analyze text emotions using CNN-LSTM architecture for context-aware predictions.</p>
          <button className="explore-btn" onClick={() => onSelectModel('sentiment')}>
            EXPLORE MODEL &rarr;
          </button>
        </div>
      </div>

      {/* Stats Section */}
      <div className="stats-container">
        <div className="stat-item">
          <div className="stat-value" style={{color: '#60a5fa'}}>12+</div>
          <div className="stat-label">ML MODELS</div>
        </div>
        <div className="stat-item">
          <div className="stat-value" style={{color: '#818cf8'}}>High</div>
          <div className="stat-label">ACCURACY</div>
        </div>
        <div className="stat-item">
          <Zap className="stat-icon" style={{color: '#f97316'}} size={32} />
          <div className="stat-label">REAL-TIME</div>
        </div>
        <div className="stat-item">
          <Target className="stat-icon" style={{color: '#ec4899'}} size={32} />
          <div className="stat-label">PRECISE RESULTS</div>
        </div>
      </div>
    </div>
  );
}

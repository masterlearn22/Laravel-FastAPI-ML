<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Prediction Dashboard</title>
    <style>
        /* ===== GLOBAL STYLES ===== */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        :root {
          --bg-primary: #0f0f0f;
          --bg-secondary: #1a1a1a;
          --bg-tertiary: #242424;
          --text-primary: #f5f5f5;
          --text-secondary: #a0a0a0;
          --accent: #6366f1;
          --accent-light: #818cf8;
          --border: #333333;
          --success: #10b981;
          --radius: 12px;
        }

        html {
          scroll-behavior: smooth;
        }

        body {
          background-color: var(--bg-primary);
          color: var(--text-primary);
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
          font-size: 16px;
          line-height: 1.6;
          font-weight: 400;
        }

        .container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 40px 20px;
        }

        /* ===== HEADER ===== */
        header {
          text-align: center;
          margin-bottom: 80px;
          padding-top: 60px;
        }

        h1 {
          font-size: 48px;
          font-weight: 700;
          letter-spacing: -0.5px;
          margin-bottom: 16px;
          background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        .subtitle {
          color: var(--text-secondary);
          font-size: 18px;
          font-weight: 400;
          max-width: 600px;
          margin: 0 auto;
        }

        /* ===== DASHBOARD GRID ===== */
        .dashboard-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 32px;
          margin-bottom: 60px;
        }

        .feature-card {
          background-color: var(--bg-secondary);
          border: 1px solid var(--border);
          border-radius: var(--radius);
          padding: 40px 32px;
          text-align: center;
          transition: all 0.3s ease;
          cursor: pointer;
          position: relative;
          overflow: hidden;
          text-decoration: none;
          color: inherit;
          display: flex;
          flex-direction: column;
          align-items: center;
        }

        .feature-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: -100%;
          width: 100%;
          height: 100%;
          background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 100%);
          transition: left 0.3s ease;
          pointer-events: none;
        }

        .feature-card:hover {
          border-color: var(--accent);
          background-color: rgba(99, 102, 241, 0.05);
          transform: translateY(-8px);
          box-shadow: 0 12px 24px rgba(99, 102, 241, 0.15);
        }

        .feature-card:hover::before {
          left: 100%;
        }

        .feature-icon {
          font-size: 64px;
          margin-bottom: 24px;
          display: block;
        }

        .feature-title {
          font-size: 24px;
          font-weight: 700;
          margin-bottom: 12px;
          color: var(--text-primary);
          letter-spacing: -0.5px;
        }

        .feature-description {
          color: var(--text-secondary);
          font-size: 14px;
          line-height: 1.6;
          margin-bottom: 24px;
          flex-grow: 1;
        }

        .feature-link {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 12px 24px;
          background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
          color: white;
          border: none;
          border-radius: 8px;
          font-size: 14px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          text-transform: uppercase;
          letter-spacing: 0.5px;
          text-decoration: none;
        }

        .feature-link:hover {
          transform: translateY(-2px);
          box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        /* ===== STATS SECTION ===== */
        .stats-section {
          background-color: var(--bg-secondary);
          border: 1px solid var(--border);
          border-radius: var(--radius);
          padding: 40px;
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 32px;
          text-align: center;
        }

        .stat-item h3 {
          font-size: 32px;
          font-weight: 700;
          color: var(--accent-light);
          margin-bottom: 8px;
        }

        .stat-item p {
          color: var(--text-secondary);
          font-size: 14px;
          text-transform: uppercase;
          letter-spacing: 0.5px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
          h1 {
            font-size: 36px;
          }

          .subtitle {
            font-size: 16px;
          }

          header {
            margin-bottom: 50px;
            padding-top: 30px;
          }

          .dashboard-grid {
            gap: 24px;
          }

          .feature-card {
            padding: 30px 24px;
          }

          .feature-icon {
            font-size: 48px;
            margin-bottom: 16px;
          }

          .feature-title {
            font-size: 20px;
          }
        }

        @media (max-width: 480px) {
          h1 {
            font-size: 28px;
          }

          .subtitle {
            font-size: 14px;
          }

          header {
            margin-bottom: 40px;
            padding-top: 20px;
          }

          .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 16px;
          }

          .feature-icon {
            font-size: 40px;
            margin-bottom: 12px;
          }

          .stats-section {
            grid-template-columns: 1fr;
            gap: 24px;
          }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>🚀 AI Prediction Hub</h1>
            <p class="subtitle">Powerful machine learning tools for classification and sentiment analysis</p>
        </header>

        <!-- Features Grid -->
        <div class="dashboard-grid">
            <!-- Mammals Card -->
            <a href="{{ route('mammals') }}" class="feature-card">
                <span class="feature-icon">🐾</span>
                <h2 class="feature-title">Mammals Detection <br>(CNN-EfficientNetB0)</h2>
                <p class="feature-description">Identify and classify different mammal species from images. Get instant predictions with confidence scores.</p>
                <button class="feature-link">Go to Mammals →</button>
            </a>

            <!-- Place Card -->
            <a href="{{ route('place') }}" class="feature-card">
                <span class="feature-icon">🏞️</span>
                <h2 class="feature-title">Place Classification <br>(CNN-ResNet50)</h2>
                <p class="feature-description">Classify images into different place categories. Perfect for location-based content analysis.</p>
                <button class="feature-link">Go to Places →</button>
            </a>

            <!-- Sentiment Card -->
            <a href="{{ route('sentiment') }}" class="feature-card">
                <span class="feature-icon">💬</span>
                <h2 class="feature-title">Sentiment Analysis <br>(CNN-LSTM)</h2>
                <p class="feature-description">Analyze text sentiment and understand emotions. Detect positive, negative, or neutral content.</p>
                <button class="feature-link">Go to Sentiment →</button>
            </a>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-item">
                <h3>3</h3>
                <p>ML Models</p>
            </div>
            <div class="stat-item">
                <h3>High</h3>
                <p>Accuracy</p>
            </div>
            <div class="stat-item">
                <h3>⚡</h3>
                <p>Instant Results</p>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('layouts/dashboard.css') }}">
    <title>AI Prediction Dashboard</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>🚀 AI Prediction Hub</h1>
            <p class="subtitle">Comprehensive machine learning platform for classification, clustering, and regression analysis</p>
        </header>

        <!-- Slider Navigation -->
        <div class="slider-nav">
            <button class="slider-btn active" onclick="changeSlide(0)">
                📊 Classification
            </button>
            <button class="slider-btn" onclick="changeSlide(1)">
                🎯 Clustering
            </button>
            <button class="slider-btn" onclick="changeSlide(2)">
                📈 Regression
            </button>
        </div>

        <!-- Slider Container -->
        <div class="slider-container">
            <div class="slider-content" id="sliderContent">
                
                <!-- CLASSIFICATION PANEL -->
                <div class="slider-panel">
                    <div class="category-header">
                        <h2 class="category-title">Classification Models</h2>
                        <p class="category-description">Predict categorical outcomes using advanced neural networks</p>
                    </div>
                    
                    <div class="dashboard-grid">
                        <!-- Mammals Card -->
                        <a href="{{ route('mammals') }}" class="feature-card">
                            <div class="feature-badge">CNN Model</div>
                            <span class="feature-icon">🐾</span>
                            <h2 class="feature-title">Mammals Detection</h2>
                            <p class="feature-description">Identify and classify different mammal species using EfficientNetB0 architecture with high accuracy.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a>

                        <!-- Place Card -->
                        <a href="{{ route('place') }}" class="feature-card">
                            <div class="feature-badge">CNN Model</div>
                            <span class="feature-icon">🏞️</span>
                            <h2 class="feature-title">Place Classification</h2>
                            <p class="feature-description">Classify images into location categories using ResNet50 for robust feature extraction.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a>

                        <!-- Sentiment Card -->
                        <a href="{{ route('sentiment') }}" class="feature-card">
                            <div class="feature-badge">Hybrid Model</div>
                            <span class="feature-icon">💬</span>
                            <h2 class="feature-title">Sentiment Analysis</h2>
                            <p class="feature-description">Analyze text emotions using CNN-LSTM architecture for context-aware predictions.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a>

                    </div>
                </div>

                <!-- CLUSTERING PANEL -->
                <div class="slider-panel">
                    <div class="category-header">
                        <h2 class="category-title">Clustering Algorithms</h2>
                        <p class="category-description">Discover hidden patterns and group similar data points</p>
                    </div>
                    
                    <div class="dashboard-grid">
                        <!-- K-Means Card -->
                        <a href="{{ route('spending_score') }}" class="feature-card">
                            <div class="feature-badge">Spending</div>
                            <span class="feature-icon">⭕</span>
                            <h2 class="feature-title">K-Means Clustering</h2>
                            <p class="feature-description">Fast and efficient clustering for large datasets with clear centroid-based groupings.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a>

                        <!-- Hierarchical Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Hierarchical</div>
                            <span class="feature-icon">🌳</span>
                            <h2 class="feature-title">Hierarchical Clustering</h2>
                            <p class="feature-description">Build dendrograms to understand data relationships at multiple granularity levels.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->

                        <!-- DBSCAN Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Density-Based</div>
                            <span class="feature-icon">🔵</span>
                            <h2 class="feature-title">DBSCAN</h2>
                            <p class="feature-description">Discover clusters of arbitrary shapes and identify outliers in noisy datasets.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->

                        <!-- Customer Segmentation -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Business Analytics</div>
                            <span class="feature-icon">👥</span>
                            <h2 class="feature-title">Customer Segmentation</h2>
                            <p class="feature-description">Segment customers based on behavior patterns for targeted marketing strategies.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->
                    </div>
                </div>

                <!-- REGRESSION PANEL -->
                <div class="slider-panel">
                    <div class="category-header">
                        <h2 class="category-title">Regression Models</h2>
                        <p class="category-description">Predict continuous numerical values with precision</p>
                    </div>
                    
                    <div class="dashboard-grid">
                        <!-- Linear Regression Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Linear Model</div>
                            <span class="feature-icon">📉</span>
                            <h2 class="feature-title">Linear Regression</h2>
                            <p class="feature-description">Simple yet powerful model for predicting linear relationships in your data.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->

                        <!-- Polynomial Regression Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Non-Linear Model</div>
                            <span class="feature-icon">〰️</span>
                            <h2 class="feature-title">Polynomial Regression</h2>
                            <p class="feature-description">Capture complex non-linear patterns with polynomial feature transformation.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->

                        <!-- Price Prediction Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Neural Network</div>
                            <span class="feature-icon">💰</span>
                            <h2 class="feature-title">Price Prediction</h2>
                            <p class="feature-description">Forecast prices using deep learning for accurate market value estimation.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->

                        <!-- Time Series Card -->
                        <!-- <a href="#" class="feature-card">
                            <div class="feature-badge">Sequential Model</div>
                            <span class="feature-icon">⏱️</span>
                            <h2 class="feature-title">Time Series Forecasting</h2>
                            <p class="feature-description">Predict future trends based on historical temporal data patterns.</p>
                            <button class="feature-link">Explore Model →</button>
                        </a> -->
                    </div>
                </div>

            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-item">
                <h3>12+</h3>
                <p>ML Models</p>
            </div>
            <div class="stat-item">
                <h3>High</h3>
                <p>Accuracy</p>
            </div>
            <div class="stat-item">
                <h3>⚡</h3>
                <p>Real-time</p>
            </div>
            <div class="stat-item">
                <h3>🎯</h3>
                <p>Precise Results</p>
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;

        function changeSlide(index) {
            currentSlide = index;
            const sliderContent = document.getElementById('sliderContent');
            const buttons = document.querySelectorAll('.slider-btn');
            
            // Update slider position
            sliderContent.style.transform = `translateX(-${index * 33.333}%)`;
            
            // Update active button
            buttons.forEach((btn, i) => {
                if (i === index) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        // Optional: Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft' && currentSlide > 0) {
                changeSlide(currentSlide - 1);
            } else if (e.key === 'ArrowRight' && currentSlide < 2) {
                changeSlide(currentSlide + 1);
            }
        });
    </script>
</body>
</html>
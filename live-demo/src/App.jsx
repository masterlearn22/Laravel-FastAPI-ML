import { useState } from 'react'
import Dashboard from './components/Dashboard'
import Mammals from './components/Mammals'
import Places from './components/Places'
import Sentiment from './components/Sentiment'
import './dashboard.css' // Import new premium styles

function App() {
  // null means showing the dashboard
  const [activeModel, setActiveModel] = useState(null)

  return (
    <div>
      {/* If activeModel is null, show Dashboard. Otherwise show specific component. */}
      {!activeModel ? (
        <Dashboard onSelectModel={setActiveModel} />
      ) : (
        <main>
          {activeModel === 'mammals' && <Mammals onBack={() => setActiveModel(null)} />}
          {activeModel === 'places' && <Places onBack={() => setActiveModel(null)} />}
          {activeModel === 'sentiment' && <Sentiment onBack={() => setActiveModel(null)} />}
        </main>
      )}
    </div>
  )
}

export default App

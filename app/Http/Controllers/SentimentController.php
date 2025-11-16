<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SentimentPrediction;

class SentimentController extends Controller
{
    public function index()
    {
        $history = SentimentPrediction::latest()->take(10)->get();

        // Ambil data result dari session (jika ada)
        $result = session('result');
        $text = session('text');
        $showResultButton = session('showResultButton');

        return view('classification.sentiment_classification', compact('history', 'result', 'text', 'showResultButton'));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'text_input' => 'required|string'
        ], [
            'text_input.required' => 'Teks harus diisi!'
        ]);

        $text = $request->text_input;

        $response = Http::asForm()->post("http://127.0.0.1:8000/predict/sentiment", [
            "text" => $text
        ]);

        if ($response->failed()) {
            return back()->withErrors("FastAPI tidak merespon.");
        }

        $result = $response->json();

        // ✅ Simpan ke database (hanya terjadi saat POST, bukan refresh)
        SentimentPrediction::create([
            'text' => $text,
            'label' => $result['label'],
            'confidence' => $result['confidence'],
        ]);

        // ✅ Redirect dengan session flash (mencegah double insert)
        return redirect()
            ->route('sentiment')
            ->with([
                'result' => $result,
                'text' => $text,
                'showResultButton' => true
            ]);
    }
}

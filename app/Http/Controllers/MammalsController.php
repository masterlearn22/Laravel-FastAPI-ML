<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MammalsPrediction; 
class MammalsController extends Controller
{
    public function index()
    {
        // Ambil riwayat prediksi dari database
        $history = MammalsPrediction::orderBy('created_at', 'desc')->get();

        // Ambil data hasil prediksi dari session
        $result = session('result');
        $image = session('image');
        $showResultButton = session('showResultButton', false);

        return view('classification.mammals_classification', compact(
            'result',
            'image',
            'showResultButton',
            'history'
        ));
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240', // 10MB
        ]);

        $image = $request->file('image');
        $storedPath = $image->store('mammals_predictions', 'public');

        // === Kirim gambar ke FastAPI ===
        $response = Http::attach(
            'file',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post(env('FASTAPI_URL') . '/predict/mammals');

        if (!$response->ok()) {
            return back()->withErrors(['FastAPI tidak merespons.']);
        }

        $result = $response->json();

        // === Simpan hasil ke database ===
        MammalsPrediction::create([
            'image_path' => $storedPath,
            'label' => $result['label'] ?? 'Unknown',
            'confidence' => $result['confidence'] ?? 0,
            'top5_labels' => json_encode($result['top5_labels'] ?? []),
            'top5_probs' => json_encode($result['top5_probs'] ?? []),
        ]);

        // === Ambil semua riwayat terbaru ===
        $history = MammalsPrediction::orderBy('created_at', 'desc')->get();

        // === Kembalikan ke view utama dengan session ===
        return redirect()
            ->route('mammals')
            ->with([
                'result' => [
                    'label' => $result['label'] ?? 'Unknown',
                    'confidence' => $result['confidence'] ?? 0,
                    'top5_labels' => $result['top5_labels'] ?? [],
                    'top5_probs' => $result['top5_probs'] ?? [],
                ],
                'image' => base64_encode(file_get_contents($image->getRealPath())),
                'showResultButton' => true,
                'history' => $history
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PlacePrediction;

class PlaceController extends Controller
{
    public function index()
    {
        $history = PlacePrediction::orderBy('created_at', 'desc')->get();

        return view('place_classification', [
            'history' => $history,
            'result' => session('result'),
            'image'  => session('image'),
            'showResultButton' => session('showResultButton')
        ]);
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $image = $request->file('image');
        $storedPath = $image->store('place_predictions', 'public');

        // === PANGGIL FAST API ===
        $response = Http::attach(
                'file',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )
            ->post(env('FASTAPI_URL').'/predict/places');   // <— beda endpoint

        if (!$response->ok()) {
            return back()->with('error', 'FastAPI untuk tempat tidak merespons.');
        }

        $result = $response->json();

        // === SIMPAN DB ===
        PlacePrediction::create([
            'image_path'  => $storedPath,
            'label'       => $result['label'],
            'confidence'  => $result['confidence'],
            'top5_labels' => $result['top5_labels'],
            'top5_probs'  => $result['top5_probs'],
        ]);

        return redirect()
            ->route('place')
            ->with([
                'result' => $result,
                'image' => base64_encode(file_get_contents($image->getRealPath())),
                'showResultButton' => true
            ]);
    }
}

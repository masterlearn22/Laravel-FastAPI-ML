<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MammalsPrediction;

class MammalsController extends Controller
{
    public function index()
    {
        $history = MammalsPrediction::orderBy('created_at', 'desc')->get();

        return view('mammals_classification', [
            'history' => $history,
            'result' => session('result'),
            'image' => session('image'),
            'showResultButton' => session('showResultButton')
        ]);
    }


    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $image = $request->file('image');
        $storedPath = $image->store('predictions', 'public');

        // kirim gambar ke FastAPI
        $response = Http::attach(
            'file',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )
            ->post(env('FASTAPI_URL') . '/predict/mammals');

        if (!$response->ok()) {
            return back()->with('error', 'FastAPI tidak merespons.');
        }

        $result = $response->json();    // hasil JSON dari FastAPI

        // simpan ke DB
        MammalsPrediction::create([
            'image_path' => $storedPath,
            'label' => $result['label'],
            'confidence' => $result['confidence'],
            'top5_labels' => $result['top5_labels'],
            'top5_probs' => $result['top5_probs'],
        ]);

        $history = MammalsPrediction::orderBy('created_at', 'desc')->get();

        return redirect()
            ->route('mammals')
            ->with([
                'history' => $history,
                'result' => $result,
                'image' => base64_encode(file_get_contents($image->getRealPath())),
                'showResultButton' => true
            ]);
    }
}

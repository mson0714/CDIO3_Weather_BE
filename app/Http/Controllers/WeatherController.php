<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class WeatherController extends Controller
{
    public function predict(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'precipitation' => 'required|numeric',
            'temp_max' => 'required|numeric',
            'temp_min' => 'required|numeric',
            'wind' => 'required|numeric'
        ]);

        try {
            $input = json_encode($validated);
            $process = new Process(['python', base_path('predict.py'), $input]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $result = json_decode($process->getOutput(), true);
            return response()->json([
                'success' => true,
                'prediction' => $result['prediction']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi dự đoán: ' . $e->getMessage()
            ], 500);
        }
    }
}

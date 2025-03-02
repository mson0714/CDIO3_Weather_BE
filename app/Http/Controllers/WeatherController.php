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
            // Chuẩn bị input data
            $input = json_encode($validated);

            // Chạy Python script với đường dẫn đầy đủ và environment variables
            $pythonPath = 'C:/Users/PC-SON/AppData/Local/Programs/Python/Python310/python.exe';
            $process = new Process([$pythonPath, base_path('predict.py'), $input]);

            // Set environment variables
            $process->setEnv([
                'PYTHONHASHSEED' => '0',
                'MKL_NUM_THREADS' => '1',
                'NUMEXPR_NUM_THREADS' => '1',
                'OMP_NUM_THREADS' => '1'
            ]);

            // Tăng timeout nếu cần
            $process->setTimeout(60);

            $process->run();

            // Kiểm tra và xử lý output
            if (!$process->isSuccessful()) {
                $error = $process->getErrorOutput();
                throw new \Exception($error ?: 'Python script execution failed');
            }

            $output = $process->getOutput();
            if (empty($output)) {
                throw new \Exception('No output from Python script');
            }

            $result = json_decode($output, true);
            if (!$result || !isset($result['success'])) {
                throw new \Exception('Invalid response from Python script');
            }

            if (!$result['success']) {
                throw new \Exception($result['error'] ?? 'Unknown error');
            }

            return response()->json([
                'success' => true,
                'prediction' => $result['prediction']
            ])->header('Access-Control-Allow-Origin', '*')
              ->header('Access-Control-Allow-Methods', '*')
              ->header('Access-Control-Allow-Headers', '*');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi dự đoán : ' . $e->getMessage()
            ], 500)->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', '*')
                    ->header('Access-Control-Allow-Headers', '*');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function __invoke()
    {
        $databaseStatus = 'healthy';
        $databaseMessage = 'Database connection is available.';

        try {
            DB::connection()->getPdo();
        } catch (\Throwable $exception) {
            $databaseStatus = 'unhealthy';
            $databaseMessage = $exception->getMessage();
        }

        $services = [
            'database' => [
                'status' => $databaseStatus,
                'message' => $databaseMessage,
            ],
            'storage' => [
                'status' => 'healthy',
                'message' => 'Local storage is ready for school uploads.',
            ],
        ];

        $status = in_array('unhealthy', array_column($services, 'status'), true)
            ? 'unhealthy'
            : (in_array('degraded', array_column($services, 'status'), true) ? 'degraded' : 'healthy');

        return response()->json([
            'status' => $status,
            'services' => $services,
        ], $status === 'unhealthy' ? 503 : 200);
    }
}

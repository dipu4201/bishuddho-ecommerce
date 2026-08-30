<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'BISHUDDHO API',
        'message' => 'API is running successfully',
    ]);
});

<?php

// 1. Daftarkan Autoloader Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Jalankan Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Tangani Request Menggunakan Kernel HTTP Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// 4. Kirim Response Balik ke Browser/Vercel
$response->send();

$kernel->terminate($request, $response);
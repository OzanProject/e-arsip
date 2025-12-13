<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $ptk = App\Models\Ptk::first();
    if (!$ptk) {
        echo "No PTK found to test.\n";
        exit;
    }
    
    // Refresh model to ensure we get the latest data from DB (including UUID if it was just added)
    $ptk->refresh();

    echo "PTK ID: " . $ptk->id . "\n";
    echo "PTK UUID: " . $ptk->uuid . "\n";
    
    $url = route('landing.ptk.show', $ptk);
    echo "Route URL: " . $url . "\n";
    
    if (str_contains($url, $ptk->uuid)) {
        echo "SUCCESS: URL contains UUID.\n";
    } else {
        echo "FAILURE: URL does not contain UUID.\n";
    }

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

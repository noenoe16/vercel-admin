<?php

use Illuminate\Contracts\Http\Kernel;
use Native\Mobile\Support\Ios\Request;
use Symfony\Component\HttpFoundation\Response;

$_timing = ['start' => microtime(true)];

// Capture OPcache status
$_opcacheInfo = 'unknown';
if (function_exists('opcache_get_status')) {
    $opcacheStatus = @opcache_get_status(false);
    if ($opcacheStatus) {
        $_opcacheInfo = 'enabled='.($opcacheStatus['opcache_enabled'] ? 'YES' : 'NO');
    }
}

// Register cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    parse_str(str_replace('; ', '&', $_SERVER['HTTP_COOKIE']), $cookies);
    $_COOKIE = array_map('urldecode', $cookies);
}

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/../../../../autoload.php';
$_timing['autoload'] = microtime(true);

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../../../../../bootstrap/app.php';
$_timing['bootstrap'] = microtime(true);

$kernel = $app->make(Kernel::class);
$_timing['kernel'] = microtime(true);

try {
    // ✅ Capture request early for Filament/Livewire compatibility
    $request = Request::capture();
    $_timing['capture'] = microtime(true);

    // ✅ Register request instance before bootstrap
    $app->instance('request', $request);

    // ✅ Explicitly bootstrap the kernel
    $kernel->bootstrap();
    $_timing['kernel_bootstrap'] = microtime(true);

    /** @var Response $response */
    $response = $kernel->handle($request);
    $_timing['handle'] = microtime(true);

    $kernel->terminate($request, $response);
    $_timing['terminate'] = microtime(true);

    // Timing calc
    $autoloadMs = round(($_timing['autoload'] - $_timing['start']) * 1000, 1);
    $bootstrapMs = round(($_timing['bootstrap'] - $_timing['autoload']) * 1000, 1);
    $kernelMs = round(($_timing['kernel'] - $_timing['bootstrap']) * 1000, 1);
    $captureMs = round(($_timing['capture'] - $_timing['kernel']) * 1000, 1);
    $kernelBootMs = round(($_timing['kernel_bootstrap'] - $_timing['capture']) * 1000, 1);
    $handleMs = round(($_timing['handle'] - $_timing['kernel_bootstrap']) * 1000, 1);
    $totalMs = round(($_timing['terminate'] - $_timing['start']) * 1000, 1);

    // Log timing (shows in Xcode console)
    error_log("PerfTiming: PHP opcache={$_opcacheInfo} autoload={$autoloadMs}ms bootstrap={$bootstrapMs}ms kernel={$kernelMs}ms capture={$captureMs}ms kernel_boot={$kernelBootMs}ms handle={$handleMs}ms TOTAL={$totalMs}ms");

    $code = $response->getStatusCode();
    $status = Response::$statusTexts[$code] ?? 'OK';
    echo "HTTP/1.1 {$code} {$status}\r\n";
    echo "X-PHP-Timing: opcache={$_opcacheInfo},autoload={$autoloadMs}ms,bootstrap={$bootstrapMs}ms,handle={$handleMs}ms,total={$totalMs}ms\r\n";

    // Send all headers
    foreach ($response->headers->all() as $name => $values) {
        foreach ($values as $value) {
            echo "{$name}: {$value}\r\n";
        }
    }
    echo "\r\n";

    $response->sendContent();

} catch (\Throwable $e) {
    error_log('CRITICAL ERROR: '.$e->getMessage()."\n".$e->getTraceAsString());
    echo "HTTP/1.1 500 Internal Server Error\r\n\r\n";
    echo "Internal Server Error during iOS bridge processing.\n";
    if ($app->bound('config') && config('app.debug')) {
        echo $e->getMessage()."\n".$e->getTraceAsString();
    }
}

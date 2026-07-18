#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

putenv('APP_ENV=testing');

// Bootstrap the application
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the kernel to enable Facades, Database, and Environment configurations
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Now we can use Facades and other Laravel features
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Step 1: Create a user using the factory. `create` persists it to the database.
$user = User::factory()->create([
    'role' => 'intern',
]);

echo "Created user: {$user->email}\n";

try {
    // Step 2: Simulate an HTTP login request that Laravel can understand.
    $request = Request::create('/login', 'POST', [
        'email' => $user->email,
        'password' => 'password', // Default factory password
    ]);

    // Bind the request to the app container so it can be injected.
    $app->instance('request', $request);

    // Step 3: Resolve the controller and LoginRequest from the container.
    // This ensures dependencies are injected and validation runs correctly.
    $loginRequest = $app->make(LoginRequest::class);
    $controller = $app->make(AuthenticatedSessionController::class);

    // Step 4: Call the controller action.
    $redirectResponse = $controller->store($loginRequest);

    echo "Controller action finished. Redirecting to: " . $redirectResponse->getTargetUrl() . "\n";

    // Step 5: Verify authentication status.
    if (Auth::check()) {
        echo "SUCCESS: User is authenticated!\n";
        echo "Authenticated User ID: " . Auth::id() . "\n";
    } else {
        echo "FAILED: User is not authenticated after controller action.\n";
    }
} catch (Exception $e) {
    echo "ERROR: An exception occurred during the test.\n";
    echo "Message: " . $e->getMessage() . "\n";
}

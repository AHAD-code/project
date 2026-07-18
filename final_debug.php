<?php

require __DIR__ . '/vendor/autoload.php';

// 1. Properly load the Laravel application instance
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/bootstrap/app.php';

// 2. Boot the kernel to enable Facades, Database, and Environment configurations
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

echo "Starting authentication debug script...\n";

// Try to authenticate
try {
    // 3. Create a test user using the factory.
    $user = User::factory()->create();
    echo "✅ User created: {$user->email}\n";

    // 4. Simulate an HTTP login request that Laravel can understand.
    $request = Request::create('/login', 'POST', [
        'email' => $user->email,
        'password' => 'password', // Default factory password
    ]);

    // 5. Bind the request to the app container so it can be injected.
    // This is crucial for FormRequests and Auth facade to work correctly.
    $app->instance('request', $request);

    // 6. Resolve the LoginRequest from the container.
    // This triggers validation and populates the request with data.
    $loginRequest = $app->make(LoginRequest::class);
    echo "✅ LoginRequest resolved from container.\n";

    // 7. Call the authenticate method.
    // This is the core logic of the login form.
    $loginRequest->authenticate();
    echo "✅ LoginRequest::authenticate() method executed.\n";

    // Check if authentication worked
    $isAuthenticated = Auth::check();
    $userId = Auth::id();

    echo "\n--- TEST RESULTS ---\n";
    echo "User Email: {$user->email}\n";
    echo "Password used: 'password'\n";
    echo "Authenticated (Auth::check()): " . ($isAuthenticated ? 'Yes' : 'No') . "\n";
    echo "Authenticated User ID (Auth::id()): {$userId}\n";

    if ($isAuthenticated && $userId === $user->id) {
        echo "\nSUCCESS: Test would pass - user is correctly authenticated!\n";
    } else {
        echo "\nFAILED: Test would fail - user is not authenticated.\n";
    }
} catch (ValidationException $e) {
    echo "❌ ERROR: A validation exception occurred during the test.\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Errors: " . json_encode($e->errors(), JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "❌ ERROR: An unexpected exception occurred during the test.\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
}

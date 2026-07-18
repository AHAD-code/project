<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

// Create a test user using the factory and check authentication
use App\Models\User;

$user = User::factory()->create();
echo "Created user: {$user->email}\n";
echo "User created: " . ($user->exists ? "Yes" : "No") . "\n";

// Check password
$password = 'password';
$hash = password_hash('password', PASSWORD_DEFAULT);
$matches = password_verify('password', $user->password);
echo "Password verification (hash): " . ($matches ? 'true' : 'false') . "\n";

// Test if user can authenticate
$authenticated = Auth::guard('web')->attempt(['email' => $user->email, 'password' => $password]);
echo "Direct auth attempt result: " . ($authenticated ? 'Authenticated' : 'Not Authenticated') . "\n";

if ($authenticated) {
    echo "User ID after auth: " . Auth::guard('web')->id() . "\n";
}

// Test with LoginRequest
$request = new App\Http\Requests\Auth\LoginRequest();
$response = new App\Http\Responses\RedirectResponse();
// Try to authenticate using the request
try {
    // This is how LoginRequest::authenticate() works
    Auth::guard('web')->attempt($request->getCredentials($request));
    echo "LoginRequest auth attempt result: ".(Auth::guard('web')->check() ? "Authenticated" : "Not Authenticated")."\n";
} catch (Exception $e) {
    echo "LoginRequest error: " . $e->getMessage() . "\n";
}

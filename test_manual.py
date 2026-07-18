<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as TestingTestCase;
use Illuminate\Http\Request;

// Create a test user
$user = User::factory()->create();

echo "Test user created:\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role}\n";
echo "Password hash: {$user->password}\n\n";

// Test 1: Create LoginRequest
$request = new \App\Http\Requests\Auth\LoginRequest();
echo "LoginRequest created\n\n";

// Test 2: Attempt to authenticate with wrong password
$wrongPassword = 'wrong-password';
echo "Test 2: Attempting to authenticate with wrong password...\n";

// Initialize the request with wrong credentials
$wrongRequest = new \App\Http\Requests\Auth\LoginRequest();
$wrongRequest->initialize([
    'email' => $user->email,
    'password' => $wrongPassword,
]);

echo "Request initialized with email: {$user->email}, password: $wrongPassword\n";

// Create a new request instance for authentication test to avoid side effects
$wrongRequest2 = new \App\Http\Requests\Auth\LoginRequest();
$wrongRequest2->setContainer(app());
$wrongRequest2->initialize([
    'email' => $user->email,
    'password' => $wrongPassword,
    'role_login_type' => 'student', // Required field
], [], [], [], [], [], '');

try {
    $wrongRequest2->authenticate();
    echo "ERROR: Authentication succeeded with wrong password!\n";
} catch (Exception $e) {
    echo "Authentication failed as expected: " . $e->getMessage() . "\n";
}

echo "\nAll manual tests completed.\n";

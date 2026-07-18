<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/tests/TestCase.php';
require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use Illuminate\Foundation\Testing\TestCase as TestingTestCase;
use App\Models\User;

// Create a test case instance for manual testing
$testCase = new TestCase();

// Test User factory creates user with correct password
$user = User::factory()->create();

echo "Testing User factory password setup...\n";
echo "User email: " . $user->email . "\n";
echo "Password hash: " . $user->password . "\n";

// Test password verification directly
try {
    $passwordVerify = password_verify('password', $user->password);
    echo "Direct password_verify('password', hash): " . ($passwordVerify ? "PASSED" : "FAILED") . "\n";
    
    if (!$passwordVerify) {
        echo "ERROR: Factory created user with incorrect password hash!\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "Exception during password verification: " . $e->getMessage() . "\n";
    exit(1);
}

// Test Laravel's authentication system
try {
    $authenticating = Auth::attempt(['email' => $user->email, 'password' => 'password']);
    
    echo "\nLaravel Auth::attempt() test:\n";
    echo "Result: " . ($authenticating ? "SUCCESS (User authenticated)" : "FAILED (User NOT authenticated)") . "\n";
    
    if ($authenticating) {
        echo "Authenticated user ID: " . Auth::id() . "\n";
        echo "Authenticated user email: " . Auth::user()->email . "\n";
    }
} catch (Exception $e) {
    echo "Exception during Auth::attempt(): " . $e->getMessage() . "\n";
}

echo "\nFinal result: " . ($authenticating ? "SUCCESS" : "FAILED - The test would fail with current implementation") . "\n";

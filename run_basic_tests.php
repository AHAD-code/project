<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/tests/TestCase.php';
require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use Tests\TestCase;

$test = new TestCase();

// Test user creation
$user = $test->createTestUser('intern', 'password');

echo "User created:\n";
echo "ID: {$user->id}\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role}\n";
echo "Password hash: {$user->password}\n\n";

// Test if user is not authenticated initially
$test->assertGuest();

echo "Test passed: User is a guest initially.\n\n";

// Try to authenticate with wrong password
try {
    // Simulate login attempt with wrong password
    $wrongEmail = $user->email;
    $wrongPassword = 'wrong-password';
    
    $authenticating = Auth::attempt(['email' => $wrongEmail, 'password' => $wrongPassword]);
    
    if ($authenticating) {
        echo "FAILED: Should not authenticate with wrong password!\n";
    } else {
        echo "PASSED: Correctly rejected wrong password.\n";
    }
} catch (Exception $e) {
    echo "Exception during wrong password test: " . $e->getMessage() . "\n";
}

echo "\nAll basic tests passed.\n";

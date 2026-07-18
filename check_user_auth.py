<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use App\\Models\\User;

// Clear existing users
User::where('email', 'LIKE', 'test_%@%')->delete();

// Create a user using the factory
$testUser = User::factory()->create();

echo "User created via factory:\n";
echo "ID: " . $testUser->id . "\n";
echo "Email: " . $testUser->email . "\n";
echo "Password hash: " . $testUser->password . "\n";

// Test password verification
try {
    $result = password_verify('password', $testUser->password);
    echo "Password 'password' verification: " . ($result ? "PASSED" : "FAILED") . "\n";
} catch (Exception $e) {
    echo "Error during password verification: " . $e->getMessage() . "\n";
}

// Check if the user can authenticate
$user = App\\Models\\User::find($testUser->id);
if ($user) {
    $authenticating = Auth::attempt(['email' => $user->email, 'password' => 'password']);
    echo "Auth::attempt() result: " . ($authenticating ? "SUCCESS" : "FAILURE") . "\n";
    
    if ($authenticating) {
        echo "Authenticated user ID: " . Auth::id() . "\n";
    }
}

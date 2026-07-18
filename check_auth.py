<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap the application
require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use App\\Models\\User;

// Create a test user
$testUser = User::factory()->create();

// Simulate a login attempt
$email = $testUser->email;
$password = 'password';

// Check if the user is in the database
$foundUser = User::where('email', $email)->first();

if ($foundUser) {
    echo "User found in database!\n";
    echo "Email: {$foundUser->email}\n";
    echo "Name: {$foundUser->name}\n";
    echo "Role: {$foundUser->role}\n";
    echo "Password hash: {$foundUser->password}\n";
    
    // Test password verification
    $result = password_verify($password, $foundUser->password);
    echo "Password verification: " . ($result ? "PASS" : "FAIL") . "\n";
    
    if ($result) {
        // Simulating successful authentication via the web guard
        Auth::guard('web')->login($foundUser);
        
        // Check authentication status
        if (Auth::guard('web')->check()) {
            echo "Authentication successful!\n";
            echo "Authenticated user ID: " . Auth::guard('web')->id() . "\n";
            echo "Authenticated user email: " . Auth::guard('web')->user()->email . "\n";
        }
    } else {
        echo "Password verification failed!\n";
    }
} else {
    echo "User not found in database!\n";
}

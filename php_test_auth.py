#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use App\\Models\\User;

$testUser = User::factory()->create();

// Simulate what the test does
echo "Testing authentication...\n";

echo "User exists in database: " . ($testUser->exists ? "Yes" : "No") . "\n";
echo "User email: {$testUser->email}\n";
echo "User password hash from DB: {$testUser->password}\n";

// Test password verification
$password = password_verify('password', $testUser->password);
echo "Password 'password' matches hash: {$password}\n\n";

if ($password) {
    // In the test, it would use the LoginRequest
    $user = App\\Models\\User::find(1);
    if ($user) {
        Auth::guard('web')->login($user);
        $authenticated = Auth::guard('web')->check();
        echo "After manual login - Authenticated: {$authenticated}\n";
        echo "Authenticated user ID: " . Auth::guard('web')->id() . "\n";
    }
} else {
    echo "ERROR: Password does not match!\n";
}

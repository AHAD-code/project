#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

use App\Models\User;

$kernel = require __DIR__ . '/bootstrap/kernel.php';

$user = User::factory()->create();
echo "Created user with ID: {$user->id}\n";
echo "User email: {$user->email}\n";
echo "User password hash: {$user->password}\n";

// Test the password check
$passwordCheck = password_verify('password', $user->password);
echo "Password 'password' matches: " . ($passwordCheck ? 'true' : 'false') . "\n";

// Try login with direct database access
$foundUser = User::where('email', $user->email)->first();
if ($foundUser) {
    echo "User found via direct query\n";
    echo "Stored hash: {$foundUser->password}\n";
    $matches = password_verify('password', $foundUser->password);
    echo "Password matches stored hash: " . ($matches ? 'true' : 'false') . "\n";
} else {
    echo "User not found via direct query\n";
}

#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';
require __DIR__ . '/tests/TestCase.php';

use App\Models\User;

$kernel = require __DIR__ . '/bootstrap/kernel.php';

$testCase = new Tests\TestCase();

// Create a user for testing
$user = User::factory()->create();

echo "TestCase class: " . get_class($testCase) . "\n";

echo "User exists in database: " . ($user->exists ? "Yes" : "No") . "\n";

echo "User email: {$user->email}\n";

// Check methods available in TestCase
$testMethods = get_class_methods($testCase);
echo "\nTestCase methods:\n";
for ($i = 0; $i < count($testMethods); $i++) {
    if (strpos($testMethods[$i], 'assert') === 0) {
        echo "  - {$testMethods[$i]}\n";
    }
}

// Check if TestCase has required methods
if (method_exists($testCase, 'assertAuthenticated')) {
    echo "\nassertAuthenticated method exists!\n";
} else {
    echo "\nassertAuthenticated method DOES NOT exist!\n";
}

// Check the User model methods
$userClass = new App\Models\User();
$classMethods = get_class_methods($userClass);
echo "\nUser model methods:\n";
for ($i = 0; $i < count($classMethods); $i++) {
    if (strpos($classMethods[$i], 'authenticat') !== false) {
        echo "  - {$classMethods[$i]}\n";
    }
}

// Check the database
if ($user->exists) {
    echo "\nDirect database query:\n";
    $directUser = App\Models\User::find($user->id);
    if ($directUser) {
        echo "User found via direct query: {$directUser->email}\\n";
        echo "Password hash in DB: {$directUser->password}\n";
        $pwdHash = $directUser->password;
        $pwdMatch = $pwdHash === $user->password;
        echo "Password matches: {$pwdMatch}\n";
    } else {
        echo "User NOT found via direct query!\n";
    }
}

<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

// Include necessary components
use App\\Http\\Controllers\\Auth\\AuthenticatedSessionController;
use App\\Http\\Requests\\Auth\\LoginRequest;
use Illuminate\\Foundation\\Testing\\TestCase as TestingTestCase;
use App\\Models\\User;
use Illuminate\\Foundation\\Auth\\User as Authenticatable;
use Illuminate\\Support\\Facades\\Auth;

// Create a user for testing
$user = User::factory()->create();
echo "Created user: {$user->email}\n";
echo "User password hash: {$user->password}\n\n";

// Test 1: Direct password verification
$password = 'password';
$passwordHash = $user->password;

$passwordVerify = password_verify($password, $passwordHash);
echo "Test 1 - Password verification: " . ($passwordVerify ? "PASSED" : "FAILED") . "\n";

if (!$passwordVerify) {
    echo "ERROR: The factory-created user has an incorrect password hash!\n";
    echo "This is why the authentication tests are failing.\n";
    exit(1);
}

// Test 2: Laravel Auth::attempt()
try {
    $authenticating = Auth::attempt(['email' => $user->email, 'password' => $password]);
    
    echo "\nTest 2 - Laravel Auth::attempt(): " . ($authenticating ? "PASSED" : "FAILED") . "\n";
    
    if ($authenticating) {
        echo "Authenticated user ID: " . Auth::id() . "\n";
        echo "Authenticated user email: " . Auth::user()->email . "\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}

echo "\nSummary:\n";

echo "1. The User factory creates passwords with 'password' (line 31 of UserFactory.php)\n");
echo "2. The User model has 'email_verified_at' set to 'datetime' (line 47 of User.php)\n");
echo "3. The User model extends Authenticatable (Laravel's Auth\User) (line 8 of User.php)\n");

echo "\nAll basic tests completed.\n";

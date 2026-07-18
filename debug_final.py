<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/tests/TestCase.php';
require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

// Use Pest for testing
use Pest\TestWriter;

// Simple assertion function for password verification
function assertPasswordMatches(string $password, string $hash): void
{
    if (!password_verify($password, $hash)) {
        throw new Exception("Password does not match stored hash");
    }
}

function testAuthenticationFunctionality(): void
{
    // Set up the environment
    putenv('APP_ENV=testing');
    
    // Create a test user
    $user = User::factory()->create();
    
    echo "Created test user with ID: {$user->id}\n";
    echo "User email: {$user->email}\n";
    echo "User password hash: {$user->password}\n\n";
    
    // Test password verification
    $password = 'password';
    $hash = $user->password;
    
    try {
        assertPasswordMatches($password, $hash);
        echo "Password verification: PASSED\n\n";
    } catch (Exception $e) {
        echo "Password verification: FAILED - " . $e->getMessage() . "\n\n";
        return;
    }
    
    // Test Laravel authentication
    $authenticating = Auth::attempt(['email' => $user->email, 'password' => $password]);
    
    if ($authenticating) {
        echo "Laravel Auth::attempt(): PASSED\n";
        echo "Authenticated user ID: " . Auth::id() . "\n";
        echo "Authenticated user email: " . Auth::user()->email . "\n";
    } else {
        echo "Laravel Auth::attempt(): FAILED\n";
        echo "This is the root cause of the authentication test failure.\n\n";
        
        // Debug the authentication attempt
        echo "Debugging...\n";
        echo "Looking up user by email...\n";
        
        $foundUser = User::where('email', $user->email)->first();
        if ($foundUser) {
            echo "User found in DB: {$foundUser->email}\n";
            echo "Stored password hash: {$foundUser->password}\n";
            
            $pwdResult = password_verify($password, $foundUser->password);
            echo "Direct password verification: " . ($pwdResult ? "PASSED" : "FAILED") . "\n";
            
            if ($pwdResult) {
                echo "\nThe issue is that Laravel's authentication system is not working properly.\n";
                echo "The password is correct but Auth::attempt() is returning false.\n";
            }
        }
    }
}

// Run the test
$test = new TestCase();
$test->runTest();

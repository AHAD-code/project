<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

$kernel = require __DIR__ . '/bootstrap/kernel.php';

use App\Models\User;

// Clear existing users to get a clean test
User::where('email', 'LIKE', 'test_%@%')->delete();

// Create a user for testing
$testUser = User::factory()->make();

echo "Created test user:\n";
echo "Email: " . $testUser->email . "\n";

// Set a known password
$testUser->password = bcrypt('password');

// Save to database  
try {
    $testUser->save();
    echo "User saved to database with ID: " . $testUser->id . "\n";
} catch (Exception $e) {
    echo "Error saving user: " . $e->getMessage() . "\n";
    exit(1);
}

// Verify the saved data
$savedUser = User::find($testUser->id);

echo "\nVerification:\n";
echo "User exists: " . ($savedUser ? "Yes" : "No") . "\n";
if ($savedUser) {
    echo "Email in DB: " . $savedUser->email . "\n";
    echo "Password hash in DB: " . $savedUser->password . "\n";
    
    // Test password verification
    $password = 'password';
    $hash = $savedUser->password;
    $result = password_verify($password, $hash);
    
    echo "Password '\"password\"' matches: " . ($result ? "YES" : "NO") . "\n";
    
    if ($result) {
        echo "\nSUCCESS: User will authenticate correctly!\n";
    } else {
        echo "\nFAILED: User will NOT authenticate.\n";
        echo "Note: The factory may not be setting the password correctly.\n";
    }
}

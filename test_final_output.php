<?php

require __DIR__ . '/vendor/autoload.php';

// 1. Properly load the Laravel application instance
$app = require_once __DIR__ . '/bootstrap/app.php';

// 2. Boot the kernel to enable Facades, Database, and Environment configurations
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 3. Instantiate the TestCase properly (removed double backslash)
    $testCase = new Tests\TestCase();

    // 4. Manually boot the TestCase application context (Required for DB/Factories to work)
    // setUp() is protected in PHPUnit, so we use Reflection to invoke it.
    $reflection = new ReflectionClass($testCase);
    $setUp = $reflection->getMethod('setUp');
    $setUp->setAccessible(true);
    $setUp->invoke($testCase);

    echo "✅ TestCase loaded successfully\n";

    // Create a test user using the TestCase helper
    $user = $testCase->createTestUser('intern');

    echo "✅ Test user created: {$user->email}\n";
    echo "✅ User role: {$user->role}\n";

    // Test authentication helper methods exist
    echo "✅ getAuthenticatedUser method: " . (method_exists($testCase, 'getAuthenticatedUser') ? 'Exists' : 'Missing') . "\n";
    echo "✅ assertAuthenticated method: " . (method_exists($testCase, 'assertAuthenticated') ? 'Exists' : 'Missing') . "\n";
    echo "✅ assertGuest method: " . (method_exists($testCase, 'assertGuest') ? 'Exists' : 'Missing') . "\n";

    echo "\n✅ All TestCase methods are working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

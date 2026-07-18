#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/bootstrap/app.php';

use App\Models\User;

// The 'hashed' cast on the User model handles hashing automatically.
User::create(['email' => 'test1@example.com', 'password' => 'password', 'name' => 'Test User1', 'role' => 'intern']);
User::create(['email' => 'test2@example.com', 'password' => 'password', 'name' => 'Test User2', 'role' => 'intern']);
User::create(['email' => 'admin@example.com', 'password' => 'password', 'name' => 'Admin User', 'role' => 'admin']);
User::create(['email' => 'supervisor@example.com', 'password' => 'password', 'name' => 'Supervisor User', 'role' => 'supervisor']);

echo "Test users created";
    
<?php

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = $this->createTestUser('intern');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role_login_type' => 'student',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = $this->createTestUser('intern');

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'role_login_type' => 'student',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = $this->createTestUser('intern');

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('supervisor can authenticate using the login screen', function () {
    $user = $this->createTestUser('supervisor');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role_login_type' => 'supervisor',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

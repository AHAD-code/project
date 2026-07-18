namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

test('login screen can be rendered', function (TestCase $test) {
    $response = $test->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function (TestCase $test) {
    $user = $test->createTestUser('student');

    $response = $test->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role_login_type' => 'student',
    ]);

    $test->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function (TestCase $test) {
    $user = $test->createTestUser('student');

    $test->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'role_login_type' => 'student',
    ]);

    $test->assertGuest();
});

test('users can logout', function (TestCase $test) {
    $user = $test->createTestUser('student');

    $response = $test->actingAs($user)->post('/logout');

    $test->assertGuest();
    $response->assertRedirect('/');
});

test('supervisor can authenticate using the login screen', function (TestCase $test) {
    $user = $test->createTestUser('supervisor');

    $response = $test->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role_login_type' => 'supervisor',
    ]);

    $test->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
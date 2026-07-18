<?Php
namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Base test case for all tests in the project
 *
 * Provides helper methods for authentication-related tests
 */
class TestCase extends BaseTestCase
{
    /**
     * Create a test user using the User factory with specified role and password
     *
     * @param string|null $role
     * @param string $password
     * @return App\Models\User
     */
    protected function createTestUser(string $role = null, string $password = 'password'): User
    {
        // Create a user and explicitly set the password.
        $user = User::factory()->create([
            'role' => $role ?? 'intern',
            'password' => $password, // The 'hashed' cast on the User model handles hashing.
        ]);
        return $user;
    }

    /**
     * Get the currently authenticated user.
     *
     * @param  string|null  $guard
     * @return \App\Models\User|null
     */
    protected function getAuthenticatedUser(string $guard = null): ?User
    {
        return $this->app['auth']->guard($guard)->user();
    }

    /**
     * Assert that a user is authenticated.
     *
     * @param  string|null  $guard
     * @return $this
     */
    public function assertAuthenticated($guard = null)
    {
        $this->assertTrue($this->app['auth']->guard($guard)->check());

        return $this;
    }

    /**
     * Assert that the user is a guest (not authenticated).
     *
     * @param  string|null  $guard
     * @return $this
     */
    public function assertGuest($guard = null)
    {
        $this->assertFalse($this->app['auth']->guard($guard)->check());

        return $this;
    }
}

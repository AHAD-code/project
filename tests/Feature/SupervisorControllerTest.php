<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Task;

class SupervisorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test user.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * A basic test supervisor.
     *
     * @var \App\Models\Supervisor
     */
    protected $supervisor;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and log them in
        $this->user = User::factory()->create([
            'email' => 'supervisor@example.com',
            'role' => 'supervisor',
        ]);

        $this->actingAs($this->user);

        // Create a supervisor linked to the user
        $this->supervisor = Supervisor::factory()->create([
            'email' => $this->user->email,
        ]);
    }

    /**
     * Test the supervisor dashboard index page.
     *
     * @return void
     */
    public function testIndex()
    {
        // Create interns and tasks for the supervisor
        $interns = Intern::factory()->count(3)->create(['supervisor_id' => $this->supervisor->id]);
        foreach ($interns as $intern) {
            Task::factory()->create(['intern_id' => $intern->id, 'status' => 'Pending']);
        }

        $response = $this->get(route('supervisor.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('supervisor.dashboard');
        $response->assertViewHas('supervisor', $this->supervisor);
        $response->assertViewHas('interns');
        $response->assertViewHas('stats');
        $response->assertViewHas('chartLabels');
        $response->assertViewHas('chartData');

        $stats = $response->viewData('stats');
        $this->assertEquals(3, $stats['total_interns']);
        $this->assertEquals(3, $stats['pending_tasks']);
    }

    /**
     * Test storing a new supervisor.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'name' => 'New Supervisor',
            'email' => 'newsupervisor@example.com',
            'department' => 'HR',
            'designation' => 'Senior HR',
        ];

        $response = $this->post(route('supervisors.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Supervisor added successfully.');
        $this->assertDatabaseHas('supervisors', ['email' => 'newsupervisor@example.com']);
    }

    /**
     * Test updating a supervisor.
     *
     * @return void
     */
    public function testUpdate()
    {
        $data = [
            'name' => 'Updated Supervisor',
            'email' => $this->supervisor->email,
            'department' => 'Engineering',
            'designation' => 'Lead Engineer',
        ];

        $response = $this->put(route('supervisors.update', $this->supervisor), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Supervisor updated successfully.');
        $this->assertDatabaseHas('supervisors', ['name' => 'Updated Supervisor']);
    }

    /**
     * Test deleting a supervisor.
     *
     * @return void
     */
    public function testDestroy()
    {
        $response = $this->delete(route('supervisors.destroy', $this->supervisor));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Supervisor removed successfully.');
        $this->assertDatabaseMissing('supervisors', ['id' => $this->supervisor->id]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PersonalInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_redirect()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_access()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
    }

    public function test_admin_sees_all_resumes()
    {
        $admin = User::factory()->state(['role' => 'admin'])->create();
        User::factory()->has(PersonalInformation::factory())->count(3)->create();
        $this->assertEquals(3, PersonalInformation::count());
        $response = $this->actingAs($admin)->get('/');
        $response->assertViewHas('resumes', fn($paginator) => $paginator->total() === 3);
    }

    public function test_edit_self_allowed()
    {
        $user = User::factory()->has(PersonalInformation::factory())->create();
        $response = $this->actingAs($user)->get("/edit/{$user->id}");
        $response->assertOk();
    }

    public function test_edit_others_blocked()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->actingAs($user1)->get("/edit/{$user2->id}");
        $response->assertForbidden();
    }
}

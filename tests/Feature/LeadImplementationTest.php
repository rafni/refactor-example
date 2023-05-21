<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadImplementationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_view_elements(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText([__('Name'), __('Phone'), __('Email'), __('Create lead')]);
    }

    public function test_show_view_elements(): void
    {
        $lead = Lead::factory()->create();
        $response = $this->get('/' . $lead->id);

        $response->assertStatus(200);
        $response->assertSeeText([__('Name'), __('Phone'), __('Email'), __('Go back'), __('Edit lead')]);
    }

    public function test_edit_view_elements(): void
    {
        $lead = Lead::factory()->create();
        $response = $this->get('/' . $lead->id . '/edit');

        $response->assertStatus(200);
        $response->assertSeeText([__('Name'), __('Phone'), __('Email'), __('Update lead')]);
    }

    public function test_post_implementation(): void
    {
        $response = $this->post('/', [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors();
    }

    public function test_post_implementation_error(): void
    {
        $response = $this->post('/', [
            'phone' => fake()->phoneNumber(),
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_put_implementation(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->put('/' . $lead->id, [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionDoesntHaveErrors();
    }

    public function test_put_implementation_error(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->put('/' . $lead->id, [
            'phone' => fake()->phoneNumber(),
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_delete_implementation(): void
    {
        $lead = Lead::factory()->create();

        $response = $this->delete('/' . $lead->id);

        $response->assertNoContent();
    }
}

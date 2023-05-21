<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Lead;
use App\Repositories\LeadRepository;
use App\Services\LeadScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @covers LeadRepository
     */
    public function test_repository_construction(): LeadRepository
    {
        $leadScoring = new LeadScoringService;
        $repository = new LeadRepository($leadScoring);
        $this->assertInstanceOf(LeadRepository::class, $repository);

        return $repository;
    }

    /**
     * @covers LeadRepository
     * @depends test_repository_construction
     */
    public function test_without_name(LeadRepository $repository): void
    {
        $lead = $repository->create([
            'email' => fake()->email(),
        ]);
        $this->assertFalse($lead);
    }

    /**
     * @covers LeadRepository
     * @depends test_repository_construction
     */
    public function test_without_email(LeadRepository $repository): void
    {
        $lead = $repository->create([
            'name' => fake()->name(),
        ]);
        $this->assertFalse($lead);
    }

    /**
     * @covers LeadRepository
     * @depends test_repository_construction
     */
    public function test_without_phone(LeadRepository $repository): void
    {
        $lead = $repository->create([
            'name' => fake()->name(),
            'email' => fake()->email(),
        ]);
        $this->assertInstanceOf(Lead::class, $lead);
    }

    /**
     * @covers LeadRepository
     * @depends test_repository_construction
     */
    public function test_full_filled_row(LeadRepository $repository): void
    {
        $name = fake()->name();
        $email = fake()->email();
        $phone = fake()->phoneNumber();

        $lead = $repository->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ]);
        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertInstanceOf(Client::class, $lead->client);
        $this->assertSame($name, $lead->name);
        $this->assertSame($email, $lead->email);
        $this->assertSame($phone, $lead->phone);
        $this->assertTrue($lead->exists);
        $this->assertIsInt($lead->score);
    }
}

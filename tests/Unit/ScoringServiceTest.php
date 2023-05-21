<?php

namespace Tests\Unit;

use App\Models\Lead;
use App\Services\LeadScoringService;
use Tests\TestCase;

class ScoringServiceTest extends TestCase
{
    /**
     * name: 20 points
     * email: 40 points
     * phone: 40 points
     */
    public static function provider()
    {
        return [
            [new Lead(['name' => fake()->name(), 'email' => fake()->email(), 'phone' => fake()->phoneNumber()]), 100],
            [new Lead(['name' => fake()->name(), 'email' => fake()->email()]), 60],
            [new Lead(['email' => fake()->email(), 'phone' => fake()->phoneNumber()]), 80],
            [new Lead(['name' => fake()->name(), 'phone' => fake()->phoneNumber()]), 60],
        ];
    }

    /**
     * @covers ScoringService
     */
    public function test_service_construction(): LeadScoringService
    {
        $leadScoring = new LeadScoringService;
        $this->assertInstanceOf(LeadScoringService::class, $leadScoring);

        return $leadScoring;
    }

    /**
     * @covers ScoringService
     * @depends test_service_construction
     * @dataProvider provider
     */
    public function test_scoring_value(Lead $lead, int $scoring, LeadScoringService $scoringService): void
    {
        $this->assertSame($scoring, $scoringService->getLeadScore($lead));
    }
}

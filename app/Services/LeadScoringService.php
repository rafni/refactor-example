<?php

namespace App\Services;

use App\Models\Lead;
use App\Services\Contracts\LeadScoringContract;

class LeadScoringService implements LeadScoringContract
{
    protected const SCORE_BY_NAME = 20;
    protected const SCORE_BY_EMAIL = 40;
    protected const SCORE_BY_PHONE = 40;

    public function getLeadScore(Lead $lead) : int
    {
        $leadScore = 0;
        if ($lead->name) {
            $leadScore += self::SCORE_BY_NAME;
        }
        if ($lead->email) {
            $leadScore += self::SCORE_BY_EMAIL;
        }
        if ($lead->phone) {
            $leadScore += self::SCORE_BY_PHONE;
        }
        return $leadScore;
    }
}

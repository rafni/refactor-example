<?php

namespace App\Services\Contracts;

use App\Models\Lead;

interface LeadScoringContract
{
    public function getLeadScore(Lead $lead) : int;
}

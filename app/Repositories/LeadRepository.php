<?php

namespace App\Repositories;

use App\Models\Lead;
use App\Services\Contracts\LeadScoringContract;
use Illuminate\Support\Facades\DB;

class LeadRepository
{
    protected LeadScoringContract $leadScoringService;

    public function __construct(LeadScoringContract $leadScoringService)
    {
        $this->leadScoringService = $leadScoringService;
    }

    public function find(int $id) : Lead|null
    {
        return Lead::find($id);
    }

    public function create(array $data) : Lead|false
    {
        $lead = new Lead($data);
        $lead->score = $this->leadScoringService->getLeadScore($lead);
        try {
            DB::beginTransaction();
            $lead->save();
            $lead->client()->create();
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            return false;
        }
        
        return $lead->exists ? $lead : false;
    }

    public function update(Lead $lead, array $data) : Lead|false
    {
        $lead->fill($data);
        $lead->score = $this->leadScoringService->getLeadScore($lead);

        try {
            $saved = $lead->update();

        } catch (\Throwable $th) {
            report($th);
            return false;
        }

        return $saved ? $lead : false;
    }

    public function delete(Lead $lead) : bool|null
    {
        try {
            return $lead->delete();

        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }
}

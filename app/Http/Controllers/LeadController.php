<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Repositories\LeadRepository;

class LeadController extends Controller
{
    protected $leadRepository;

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(LeadRequest $request)
    {
        $createdLead = $this->leadRepository->create($request->validated());
        if ($createdLead) {
            return redirect()
                ->route('lead.show', ['lead' => $createdLead->id])
                ->with('success', __('Lead has been created'));

        } else {
            return redirect()
                ->route('lead.create')
                ->withInput()
                ->with('error', __('Lead cannot be created'));
        }
    }

    public function show($id)
    {
        $lead = $this->leadRepository->find($id);
        if (! $lead) {
            abort(404);
        }
        return view('leads.show', ['lead' => $lead]);
    }

    public function edit($id)
    {
        $lead = $this->leadRepository->find($id);
        if (! $lead) {
            abort(404);
        }        
        return view('leads.edit', ['lead' => $lead]);
    }

    public function update(LeadRequest $request, $id)
    {
        $lead = $this->leadRepository->find($id);
        if (! $lead) {
            abort(404);
        }

        $updatedLead = $this->leadRepository->update($lead, $request->validated());
        if ($updatedLead) {
            return redirect()
                ->route('lead.show', ['lead' => $updatedLead->id])
                ->with('success', __('Lead has been updated'));

        } else {
            return redirect()
                ->route('lead.edit')
                ->withInput()
                ->with('error', __('Lead cannot be updated'));
        }
    }

    public function destroy($id)
    {
        $lead = $this->leadRepository->find($id);
        if (! $lead) {
            abort(404);
        }

        if ($this->leadRepository->delete($lead)) {
            return response()->noContent();

        } else {
            return redirect()
                ->route('lead.show')
                ->with('error', __('Lead cannot be deleted'));
        }
    }
}

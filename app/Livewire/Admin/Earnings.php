<?php

namespace App\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use App\Models\Earning;
use App\Models\Payout;
use App\Services\FinancialCalculatorService;
use Carbon\Carbon;

class Earnings extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    // UI State
    public $isModalOpen = false;
    public $viewingEarningId = null; 

    // Filters (Range defaults to null = Show All)
    public $selectedProject = '';
    public $dateFrom = null;
    public $dateTo = null;

    // Form Data
    public $project_id;
    public $total_amount;
    public $earning_date;

    // Preview Data
    public $preview_breakdown = [];

    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'total_amount' => 'required|numeric|min:0',
        'earning_date' => 'required|date',
    ];

    public function mount()
    {
        // Only set default date for the creation form, not the filter
        $this->earning_date = Carbon::now()->format('Y-m-d');
    }

    // --- Actions ---

    public function openModal()
    {   
        $this->authorize('manage payouts');
        $this->resetValidation();
        $this->reset(['project_id', 'total_amount', 'preview_breakdown']);
        $this->earning_date = Carbon::now()->format('Y-m-d');
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->viewingEarningId = null;
    }

    public function updated($property)
    {
        // Auto-calculate preview when typing
        if (in_array($property, ['project_id', 'total_amount']) && 
            $this->project_id && 
            $this->total_amount && 
            is_numeric($this->total_amount)) {
            
            // Use service to calculate
            $calculator = app(FinancialCalculatorService::class);
            $this->preview_breakdown = $calculator->calculateBreakdown($this->project_id, (float)$this->total_amount);
        }
    }

    public function save(FinancialCalculatorService $calculator)
    {   
        $this->authorize('manage payouts');
        $this->validate();

        $calculator->recordEarning(
            $this->project_id, 
            $this->earning_date, 
            (float)$this->total_amount
        );

        $this->dispatch('notify', message: 'Earning recorded successfully.');
        $this->closeModal();
    }

    public function delete($id)
    {   
        $this->authorize('manage payouts');
        Earning::find($id)->delete();
        $this->dispatch('notify', message: 'Record deleted.', type: 'error');
    }

    public function toggleDetails($id)
    {   
        // $this->authorize('manage payouts');
        $this->viewingEarningId = $this->viewingEarningId === $id ? null : $id;
    }

    public function togglePayoutStatus($payoutId)
    {
        $payout = Payout::find($payoutId);

        if ($payout) {
            $payout->is_paid = !$payout->is_paid;
            $payout->paid_at = $payout->is_paid ? now() : null;
            $payout->save();

            $status = $payout->is_paid ? 'Paid' : 'Unpaid';
            $this->dispatch('notify', message: "Marked as $status");
        }
    }

    public function render()
    {   
        $this->authorize('view earnings');
        $query = Earning::with(['project', 'payouts.user'])->latest('earning_date');

        // 1. Filter by Project
        if ($this->selectedProject) {
            $query->where('project_id', $this->selectedProject);
        }

        // 2. Filter by Date Range (Start)
        if ($this->dateFrom) {
            $query->whereDate('earning_date', '>=', $this->dateFrom);
        }

        // 3. Filter by Date Range (End)
        if ($this->dateTo) {
            $query->whereDate('earning_date', '<=', $this->dateTo);
        }

        return view('livewire.admin.earnings', [
            'earnings' => $query->paginate(10),
            'projects' => Project::orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Earnings']);
    }
}
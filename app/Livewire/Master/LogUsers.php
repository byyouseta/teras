<?php

namespace App\Livewire\Master;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class LogUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $startDate;
    public $endDate;

    public function mount()
    {
        // Default periode: 7 hari terakhir
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = Activity::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                        ->orWhere('log_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->startDate)->startOfDay(),
                    Carbon::parse($this->endDate)->endOfDay()
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.log-users', [
            'logs' => $logs
        ]);
    }
}

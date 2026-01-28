<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use Livewire\Component;

class StatAgendaBulanan extends Component
{
    // Properti publik untuk menampung data yang akan digunakan oleh chart.
    public $dataPoints = [];
    public $labels = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $monthlyCounts = Agenda::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $this->dataPoints = [];
        for ($i = 1; $i <= 12; $i++) {
            $this->dataPoints[] = $monthlyCounts[$i] ?? 0;
        }


        // Data Kategori (nilai-nilai X atau Label)
        $this->labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
    }

    public function render()
    {
        return view('livewire.agenda.stat-agenda-bulanan');
    }
}

<?php

namespace Movve\Crm\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class DashboardReport extends Component
{
    public $month;
    public $newUsers = 0;
    public $bookings = 0;
    public $earned = 0;

    public function mount()
    {
        $this->month = now()->format('Y-m');
        $this->loadData();
    }

    public function previousMonth()
    {
        $this->month = Carbon::createFromFormat('Y-m', $this->month)->subMonth()->format('Y-m');
        $this->loadData();
    }

    public function nextMonth()
    {
        $this->month = Carbon::createFromFormat('Y-m', $this->month)->addMonth()->format('Y-m');
        $this->loadData();
    }

    public function loadData()
    {
        // Dummy data, vervang met echte queries
        $this->newUsers = 5;
        $this->bookings = 12;
        $this->earned = 1234.56;
    }

    public function render()
    {
        return view('movve/crm::livewire.dashboard-report');
    }
}

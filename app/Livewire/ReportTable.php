<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;

class ReportTable extends Component
{
    public function render()
    {
        return view('livewire.report-table', [
            'reports' => Report::all()
        ]);

    }

    public function createReport()
    {

        $employeeId = auth()->id();

        $user = auth()->user();
        $report = new Report();
        $report->ReportName = 'Daily Sales Report '.now();
        $report->EmployeeId = $employeeId;
        $report->Date = now();
        $report->save();
    }
}

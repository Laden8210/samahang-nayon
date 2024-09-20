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
        $report = new Report();
        $report->ReportName = 'Report 1';
        $report->EmployeeId = 1;
        $report->Date = now();
        $report->save();
    }
}

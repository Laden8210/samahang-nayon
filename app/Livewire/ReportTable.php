<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;

class ReportTable extends Component
{

    public $type;
    public $startdate;
    public $enddate;
    public function render()
    {
        return view('livewire.report-table', [
            'reports' => Report::all()
        ]);

    }

    public function createReport()
    {

        if ($this->type === 'Daily Revenue Report') {
            $this->validate([
                'type' => 'required|string',
                'startdate' => 'required|date|before_or_equal:today',
            ]);
        } else {
            $this->validate([
                'type' => 'required|string',
                'startdate' => 'required|date|before_or_equal:today',
                'enddate' => 'required|date|before_or_equal:today',
            ]);
        }
        $employeeId = auth()->id();

        $user = auth()->user();
        $report = new Report();
        $report->ReportName = $this->type ."-". now()->timestamp;

        $report->type = $this->type;
        $report->EmployeeId = $employeeId;
        $report->Date = $this->startdate;

        if ($this->type != 'Daily Revenue Report') {
            $report->EndDate = $this->enddate;
        }

        $report->CreatedAt = now();
        $report->save();
    }
}

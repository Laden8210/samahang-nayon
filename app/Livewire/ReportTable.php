<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Carbon;
class ReportTable extends Component
{

    public $type;
    public $startdate;
    public $enddate;
    public $isEndDateDisabled = false;

    public $search = '';

    public function render()
    {
        return view('livewire.report-table', [
            'reports' => Report::search($this->search)->orderBy('CreatedAt', 'desc')->get()
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

        if ($this->type == 'Weekly Revenue Report') {
            $report->EndDate = Carbon::parse($this->startdate)->addWeek();
        }

        if ($this->type == 'Monthly Revenue Report') {
            $report->EndDate = Carbon::parse($this->startdate)->addMonth();
        }


        $report->CreatedAt = now();
        $report->save();
    }

    public function disableField(){
        $this->isEndDateDisabled = str_contains($this->type, 'Revenue Report');
    }
}

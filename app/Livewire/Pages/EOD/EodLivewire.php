<?php

namespace App\Livewire\Pages\EOD;

use Livewire\Component;
use App\Models\Task\Task;
use App\Models\Employee\Employee;

class EodLivewire extends Component
{
    public $model;
    public $singleEodReport;
    public $selectedDate = false;
    public $selectedSubject = false;
    public $eodDateList = [];
    public $empId = "";
    public $dynamicempId = "";
    public $employeeModel = "";

    public function mount(Task $model, $dynamicempId)
    {
        $this->model = $model;
        $this->dynamicempId = $dynamicempId;

        $res = $this->fetchEODDate();
        // dd(count($res) > 0);
        if (count($res) > 0) {
            $this->fetchEODBydate($res[0]['eod_date'], $res[0]['subject']);
        }
    }

    public function fetchCUrrentEmployee()
    {
        if ($this->dynamicempId) {
            $this->empId = $this->dynamicempId;
        } else {
            $this->empId = fetchCurrentEmployeeWithReportingManagers()->id;
        }

        $this->employeeModel = Employee::find($this->empId);
    }

    public function fetchEODBydate($date, $subject = '')
    {
        $this->dispatch('show-delete-modal');

        $this->dynamicempId = $this->dynamicempId;
        $this->fetchCUrrentEmployee();
        $this->selectedDate = $date;
        $this->selectedSubject = $subject;
        $eodList = Task::whereDate('eod_date', $date)->where('employee_id', $this->empId)
            ->with('customer:id,company_name')->get()->groupBy('customer_id')->toArray();

        $this->singleEodReport = $eodList;
    }

    public function fetchEODDate()
    {
        $this->fetchCUrrentEmployee();
        return $eodDateList = Task::where('employee_id', $this->empId)->groupBy('eod_date')->get(['eod_date', 'subject']);
    }

    public function render()
    {

        $eodDateList = $this->fetchEODDate();
        // $eodDateList = Task::where('employee_id', $this->empId)->groupBy('eod_date')->get(['eod_date', 'subject']);
        return view('livewire.pages.e-o-d.eod-livewire', [
            'eodDateListArr' => $eodDateList,
        ]);
    }
}

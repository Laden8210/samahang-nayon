<?php

namespace App\Livewire\User;

use Database\Seeders\PersonalInformationTable;
use Livewire\Component;
use App\Models\PersonalInformation;
use App\Models\Employee;

class UserTable extends Component
{

    public $search = '';
    public function render()
    {
        return view('livewire.user.user-table', [
            'users' => Employee::search($this->search)->paginate(10)
        ]);
    }

}

<?php

namespace App\Livewire\User;

use Database\Seeders\PersonalInformationTable;
use Livewire\Component;
use App\Models\PersonalInformation;

class UserTable extends Component
{

    public $search = '';
    public function render()
    {
        return view('livewire.user.user-table', [
            'users' => PersonalInformation::search($this->search)->paginate(10)
        ]);
    }

}

<?php

namespace App\Livewire\User;

use Database\Seeders\PersonalInformationTable;
use Livewire\Component;
use App\Models\PersonalInformation;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class UserTable extends Component
{

    public $search = '';

    public $user;
    protected $listeners = ['refreshComponent' => '$refresh'];

    use WithPagination;

    public function render()
    {
        $current_user = Auth::user()->EmployeeId;
        return view('livewire.user.user-table', [
            'users' => Employee::search($this->search)
            ->where('EmployeeId' , '!=' ,$current_user)->paginate(10)
        ]);
    }

    public function changeStatus($id)
    {
        $user = Employee::where('EmployeeId', $id)->firstOrFail();
        if ($user->Status == 'Active') {
            $user->update([
                'Status' => 'Inactive'
            ]);
        } else {
            $user->update([
                'Status' => 'Active'
            ]);
        }
        session()->flash('message', 'Successfully '.$user->Status.' successfully!');

    }

    public function selectUser($id)
    {
        $this->user = Employee::where('EmployeeId', $id)->firstOrFail();

    }

    public function delete($id)
    {

        $this->user->delete();
        session()->flash('message', 'Successfully deleted!');
    }

}

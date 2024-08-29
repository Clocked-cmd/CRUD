<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name;
    public $email;
    public $address;
    public $updateData = false;
    public $employee_id;
    public $keywords;
    public $employee_selected_id = [];
    public $sortColumn = 'name';
    public $sortDirection = 'asc';

    public function store()
{
    $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ];

    $messages = [
        'name.required' => 'Required Name',
        'email.required' => 'Required Email',
        'email.email' => 'Email Format Does Not Match',
        'address.required' => 'Required Address',
    ];

    $validated = $this->validate($rules, $messages);

    ModelsEmployee::create($validated);
    
    session()->flash('message', 'Data Entered Successfully');

    
    }
    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->address = $data->address;

        $this->updateData = true;
        $this->employee_id = $id;
    }
    public function update()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ];
    
        $messages = [
            'name.required' => 'Required Name',
            'email.required' => 'Required Email',
            'email.email' => 'Email Format Does Not Match',
            'address.required' => 'Required Address',
        ];
    
        $validated = $this->validate($rules, $messages);
    
        $data = ModelsEmployee::find($this->employee_id);

        $data->update($validated);
        
        session()->flash('message', 'Data Updated Successfully');

        
    }

    public function clear(){
        $this->name = '';
        $this->email = '';
        $this->address = '';

        $this->updateData = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }
    public function delete()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            ModelsEmployee::find($id)->delete();
        }
        if(count($this->employee_selected_id)){
            for($x = 0; $x < count($this->employee_selected_id);$x++){
                ModelsEmployee::find(($this->employee_selected_id)[$x])->delete();
            }
        }
        session()->flash('message', 'Data Deleted Successfully');
        $this->clear();
        
    }

    public function delete_confirmation($id)
    {
        if($id !=''){
           $this->employee_id = $id;

        }
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if ($this->keywords != null){
            $data = ModelsEmployee::where('name', 'like', '%' .$this->keywords. '%')
            ->orWhere('email', 'like', '%' .$this->keywords. '%')
            ->orWhere('address', 'like', '%' .$this->keywords. '%')
            ->orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        } else {
            $data = ModelsEmployee::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);
        }
        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}

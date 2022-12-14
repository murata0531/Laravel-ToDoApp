<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Status;
use App\Models\Task;

class Tasks extends Component
{
    public $tasks, $name, $description, $task_id,$statuses;
    public $status_id = 1;
    public $isOpen=false;

    public function render()
    {
        $this->statuses = Status::with('tasks')->get();
        $this->tasks = Task::with('statuses')->get();
        
        return view('livewire.tasks');
    }

    public function mount($status_id = 1)
    {
        $this->status_id = $status_id;
        $this->onChange();
    }

    public function onChange()
    {
        $status_id= intval($this->status_id);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->task_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        Task::updateOrCreate(['id' => $this->task_id], [
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id
        ]);

        session()->flash('message', 
        $this->task_id ? 'Task Updated Successfully.' : 'Task Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->task_id = $task->id;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->stattus_id = $task->status_id;
        $this->openModal();
    }

    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }
}

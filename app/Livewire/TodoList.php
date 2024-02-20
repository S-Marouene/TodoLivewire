<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule('required|min:3|max:50')]
    public $name;
    #[Rule('required|min:3|max:50')]
    public $editTodoName;
    public $search;
    public $editTodoId;

    public function create()
    {
        $validated = $this->validateOnly('name');
        Todo::create($validated);
        $this->reset('name');
        session()->flash('success','Created.');
        $this->resetPage();
    }
    public function delete($todoId){
            Todo::find($todoId)->delete();
    }

    public function toggle($todoId){
        $todo = Todo::find($todoId);
        $todo->completed  = !$todo->completed;
        $todo->save();
    }
    public function edit($todoId){
        $this->editTodoId=$todoId;
        $this->editTodoName = Todo::find($todoId)->name;
    }
    public function cancelEdit()
    {
        $this->reset('editTodoId','editTodoName');
    }

    public function update()
    {
        $this->validateOnly('editTodoName');
        Todo::find($this->editTodoId)->update(
            [
                'name'=>$this->editTodoName
            ]
        );
        $this->cancelEdit();
    }
    public function render()
    {
        return view('livewire.todo-list',[
            'todos'=> Todo::latest()->where('name','like',"%{$this->search}%")->paginate(5)
        ]);
    }
}

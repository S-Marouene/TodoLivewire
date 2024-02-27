<?php
namespace App\Livewire;
use App\Models\Todo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule('required|min:3|max:50')]
    public $name;
    #[Rule('required|min:3|max:50')]
    public $editTodoName;

    #[Url(as: 's',history: true,keep: false)]
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

    public function placeholder(){
        return view('placeholder');
    }

    public function mount($search){
        $this->search=$search;
    }

    //With computed no need to send Todoos in render with benefits of caching
    #[Computed()]
    public function todos(){
        return Todo::latest()->where('name','like',"%{$this->search}%")->paginate(5);
    }

    public Todo $selectedTodo;
    public function viewDetails(Todo $todo)
    {
        $this->selectedTodo = $todo;

        $this->dispatch('open-modal',name:'TodoDetails');
    }


    public function render()
    {
        sleep(0.5);
        return view('livewire.todo-list',[]);
    }
}

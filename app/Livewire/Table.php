<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
    protected $model = User::class;
    public $myParam = 'Default';
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDebugStatus(true);
    }

    public function columns(): array
    {
        return [
            Column::make('--ID', 'id')
                ->sortable()
                ->setSortingPillTitle('Key')
                ->setSortingPillDirections('0-9', '9-0')
                ->secondaryHeader(function($rows) {
                    return $rows->sum('id');
                })
                ->html(),
            Column::make('Name')
                ->sortable()
                ->searchable()
                ->view('my.active.view')
                /*->secondaryHeader(function() {
                    return view('tables.cells.input-search', ['field' => 'name', 'columnSearch' => $this->columnSearch]);
                })*/
                ->html(),
            Column::make('Email')
                ->sortable()
                ->collapseOnMobile(),
            Column::make('password')
                ->sortable(),
            Column::make('created_at')
                ->sortable(),

        ];
    }

    public function reorder($items): void
    {
        foreach ($items as $item) {
            User::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
        }
    }
}

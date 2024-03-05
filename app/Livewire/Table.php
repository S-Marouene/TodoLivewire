<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
    protected $model = User::class;



    public function configure(): void
    {
       // $this->setLoadingPlaceholderDisabled();
        //$this->setHideConfigurableAreasWhenReorderingStatus(true);
        //$this->setHideConfigurableAreasWhenReorderingEnabled();
        //$this->setHideConfigurableAreasWhenReorderingStatus(false);

        //$this->setLoadingPlaceholderStatus(true);
       // $this->setLoadingPlaceholderStatus(true);
        //$this->setLoadingPlaceholderBlade('placeholder');

        $this->setSingleSortingDisabled();
        $this->setDefaultSort('name', 'desc');
        $this->setPrimaryKey('id');

        $this->setComponentWrapperAttributes([
            'default' => true,
            'class' => 'px-6 py-3 text-left font-bold lowercase ',
        ]);
    }


    public function columns(): array
    {
        return [
            Column::make('--ID', 'id')
                ->sortable(),
            Column::make('Name')
                ->sortable()->searchable(),
            Column::make('Email')
                ->sortable(),
            Column::make('password')
                ->sortable(),
            Column::make('created_at')
                ->sortable(),

        ];
    }
}

<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;


class Table extends DataTableComponent
{
    protected $model = User::class;
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            //->setDebugStatus(true)
            ->setTableRowUrl(function($row) {
                return route('home', $row);
            })
            ->setTableRowUrlTarget(function($row) {
                return '_blank';
            })
            ->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
                if ($column->isField('id')) {
                    return ['class' => 'text-green-500'];
                }

                return ['default' => true];
            })
            ->setHideBulkActionsWhenEmptyEnabled();

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

    public function filters(): array
    {
        return [
            TextFilter::make('Name')
                ->config([
                    'maxlength' => 5,
                    'placeholder' => 'Search Name',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('users.name', 'like', '%'.$value.'%');
                }),


            /*SelectFilter::make('Active')
                ->setFilterPillTitle('User Status')
                ->setFilterPillValues([
                    '1' => 'Active',
                    '0' => 'Inactive',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('active', true);
                    } elseif ($value === '0') {
                        $builder->where('active', false);
                    }
                }),*/
            DateFilter::make('Created From')
                ->config([
                    'min' => '2020-01-01',
                    'max' => '2021-12-31',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('users.created_at', '>=', $value);
                }),
            DateFilter::make('Created To')
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('users.created_ed_at', '<=', $value);
                }),
        ];
    }
    public function bulkActions(): array
    {
        return [
            'export' => 'Export Selected',
        ];
    }
    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $users = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new UsersExport($users), 'users.xlsx');
    }
}

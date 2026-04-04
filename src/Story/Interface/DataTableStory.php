<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIDataTableComponent;

final class DataTableStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'DataTable'; }
    public function description(): string { return 'Tableau avec tri, pagination et actions.'; }
    public function componentClass(): string { return UIDataTableComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'columns' => [['key' => 'name', 'label' => 'Name'], ['key' => 'role', 'label' => 'Role']],
            'rows' => [
                ['name' => 'Alice', 'role' => 'Admin'],
                ['name' => 'Bob', 'role' => 'Editor'],
                ['name' => 'Claire', 'role' => 'Viewer'],
                ['name' => 'David', 'role' => 'Admin'],
            ],
            'rowActions' => [
                ['name' => 'view', 'label' => 'View', 'icon' => 'eye'],
                ['name' => 'edit', 'label' => 'Edit', 'icon' => 'pencil-square'],
                ['name' => 'delete', 'label' => 'Delete', 'icon' => 'trash'],
            ],
            'showPagination' => true,
            'perPage' => 2,
            'actionsMode' => 'inline',
        ];
    }

    public function variants(): array
    {
        return [
            'basic' => [],
            'empty' => ['rows' => []],
            'sorted by name' => ['sortBy' => 'name', 'sortDirection' => 'asc'],
            'icon actions' => ['actionsMode' => 'icons'],
            'dropdown actions' => ['actionsMode' => 'dropdown'],
            'without pagination' => ['showPagination' => false, 'perPage' => 10],
        ];
    }
}

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
            'columns' => [['key' => 'name', 'label' => 'Name'], ['key' => 'role', 'label' => 'Role'], ['key' => 'status', 'label' => 'Status']],
            'rows' => [
                ['name' => 'Alice', 'role' => 'Admin', 'status' => ['component' => 'uibadge', 'props' => ['color' => 'green'], 'slot' => 'Active']],
                ['name' => 'Bob', 'role' => 'Editor', 'status' => ['component' => 'uibadge', 'props' => ['color' => 'amber'], 'slot' => 'Pending']],
                ['name' => 'Claire', 'role' => 'Viewer', 'status' => ['component' => 'uibadge', 'props' => ['color' => 'slate'], 'slot' => 'Idle']],
                ['name' => 'David', 'role' => 'Admin', 'status' => ['component' => 'uibadge', 'props' => ['color' => 'red'], 'slot' => 'Blocked']],
            ],
            'rowActions' => [
                ['name' => 'view', 'label' => 'View', 'icon' => 'eye'],
                ['name' => 'edit', 'label' => 'Edit', 'icon' => 'pencil-square', 'color' => 'indigo'],
                ['name' => 'delete', 'label' => 'Delete', 'icon' => 'trash', 'color' => 'red'],
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
            'component cells' => [],
            'without pagination' => ['showPagination' => false, 'perPage' => 10],
        ];
    }
}

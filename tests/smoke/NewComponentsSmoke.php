<?php

declare(strict_types=1);

require __DIR__ . '/../../../core/vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

use Impulse\UI\Component\Interface\UIAccordionComponent;
use Impulse\UI\Component\Interface\UIModalComponent;
use Impulse\UI\Component\Interface\UISkeletonComponent;
use Impulse\UI\Component\Navigation\UIBreadcrumbComponent;
use Impulse\UI\Component\Navigation\UIDropdownComponent;
use Impulse\UI\Component\Navigation\UIPaginationComponent;
use Impulse\UI\Component\Form\UIDatePickerComponent;
use Impulse\UI\Component\Form\UIFileUploadComponent;
use Impulse\UI\Component\Interface\UIDataTableComponent;
use Impulse\UI\Component\Interface\UIDrawerComponent;
use Impulse\UI\Component\Interface\UIPopoverComponent;
use Impulse\UI\Component\Interface\UIProgressComponent;
use Impulse\UI\Component\Interface\UIStatCardComponent;
use Impulse\UI\Component\Interface\UIStepperComponent;
use Impulse\UI\Component\Interface\UITimelineComponent;
use Impulse\UI\Component\Interface\UITooltipComponent;
use Impulse\UI\Component\Navigation\UICommandPaletteComponent;
use Impulse\UI\Component\Navigation\UISidebarComponent;

$components = [
    new UIModalComponent('smoke-modal'),
    new UIAccordionComponent('smoke-accordion', null, [
        'items' => [
            ['title' => 'One', 'content' => 'First content'],
            ['title' => 'Two', 'content' => 'Second content'],
        ],
    ]),
    new UISkeletonComponent('smoke-skeleton'),
    new UIBreadcrumbComponent('smoke-breadcrumb', null, [
        'items' => [
            ['label' => 'Admin', 'url' => '#'],
            ['label' => 'Users', 'url' => '#'],
        ],
    ]),
    new UIPaginationComponent('smoke-pagination', null, [
        'totalPages' => 12,
        'totalItems' => 120,
    ]),
    new UIDropdownComponent('smoke-dropdown', null, [
        'items' => [
            ['value' => 'edit', 'label' => 'Edit'],
            ['separator' => true],
            [
                'type' => 'group',
                'label' => 'Advanced',
                'items' => [
                    ['value' => 'archive', 'label' => 'Archive'],
                ],
            ],
        ],
    ]),
    new UIDataTableComponent('smoke-table', null, [
        'columns' => [
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'role', 'label' => 'Role'],
        ],
        'rows' => [
            ['name' => 'Alice', 'role' => 'Admin'],
            ['name' => 'Bob', 'role' => 'Editor'],
        ],
        'rowActions' => [
            ['name' => 'edit', 'label' => 'Edit'],
        ],
    ]),
    new UIDatePickerComponent('smoke-date'),
    new UIFileUploadComponent('smoke-upload', null, [
        'files' => [
            ['name' => 'report.pdf', 'size' => '120 KB'],
        ],
    ]),
    new UIDrawerComponent('smoke-drawer', null, ['open' => true, 'content' => 'Drawer content']),
    new UITooltipComponent('smoke-tooltip', null, ['open' => true]),
    new UIPopoverComponent('smoke-popover', null, ['open' => true, 'content' => 'Popover content']),
    new UIProgressComponent('smoke-progress', null, ['value' => 42]),
    new UIProgressComponent('smoke-cprogress', null, ['variant' => 'circular', 'value' => 65]),
    new UIStepperComponent('smoke-stepper', null, ['steps' => ['Start', 'Details', 'Confirm']]),
    new UITimelineComponent('smoke-timeline', null, [
        'items' => [
            ['title' => 'Created', 'description' => 'Project created', 'time' => '09:00'],
        ],
    ]),
    new UISidebarComponent('smoke-sidebar', null, [
        'items' => [
            ['value' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
            ['value' => 'settings', 'label' => 'Settings', 'icon' => 'cog-6-tooth'],
        ],
    ]),
    new UICommandPaletteComponent('smoke-command', null, [
        'open' => true,
        'commands' => [
            ['value' => 'new', 'label' => 'New file', 'shortcut' => 'Cmd+N'],
        ],
        'filteredCommands' => [
            ['value' => 'new', 'label' => 'New file', 'shortcut' => 'Cmd+N'],
        ],
    ]),
    new UIStatCardComponent('smoke-stat', null, ['title' => 'Revenue', 'value' => '$12,400', 'delta' => '+12%']),
];

foreach ($components as $component) {
    $html = $component->template();

    if (!is_string($html) || trim($html) === '') {
        throw new RuntimeException('Empty template for ' . $component::class);
    }
}

echo "New components smoke test passed." . PHP_EOL;


<?php

declare(strict_types=1);

require __DIR__ . '/../../../core/vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

use Impulse\UI\Component\Form\UIDatePickerComponent;
use Impulse\UI\Component\Form\UIFileUploadComponent;
use Impulse\UI\Component\Interface\UIDataTableComponent;
use Impulse\UI\Component\Interface\UIDrawerComponent;
use Impulse\UI\Component\Interface\UIPopoverComponent;
use Impulse\UI\Component\Interface\UIStepperComponent;
use Impulse\UI\Component\Navigation\UICommandPaletteComponent;
use Impulse\UI\Component\Navigation\UIDropdownComponent;
use Impulse\UI\Component\Navigation\UISidebarComponent;
use Impulse\UI\Component\Interface\UIProgressComponent;
use Impulse\UI\Component\Interface\UIStatCardComponent;
use Impulse\UI\Component\Interface\UITimelineComponent;

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$date = new UIDatePickerComponent('a-date');
$date->setDate('2026-04-05');
assertTrue($date->value === '2026-04-05', 'DatePicker single action failed');
$date->setRangeStart('2026-04-01');
$date->setRangeEnd('2026-04-09');
assertTrue($date->startDate === '2026-04-01' && $date->endDate === '2026-04-09', 'DatePicker range action failed');

$upload = new UIFileUploadComponent('a-upload', null, ['maxFiles' => 1]);
$upload->addFile('a.txt', '1 KB');
$upload->addFile('b.txt', '1 KB');
assertTrue(count($upload->files) === 1, 'FileUpload max files failed');
assertTrue($upload->errorMessage !== '', 'FileUpload error message failed');
$upload->removeFile(0);
assertTrue(count($upload->files) === 0, 'FileUpload remove failed');

$table = new UIDataTableComponent('a-table', null, [
    'columns' => [['key' => 'name', 'label' => 'Name']],
    'rows' => [['name' => 'B'], ['name' => 'A']],
    'perPage' => 1,
]);
$table->sort('name');
assertTrue($table->sortBy === 'name', 'DataTable sort field failed');
$table->sort('name');
assertTrue($table->sortDirection === 'desc', 'DataTable sort direction toggle failed');
$table->goToPage(2);
assertTrue($table->page === 2, 'DataTable pagination action failed');

$drawer = new UIDrawerComponent('a-drawer');
$drawer->openDrawer();
assertTrue($drawer->open === true, 'Drawer open action failed');
$drawer->toggleDrawer();
assertTrue($drawer->open === false, 'Drawer toggle action failed');

$popover = new UIPopoverComponent('a-popover');
$popover->togglePopover();
assertTrue($popover->open === true, 'Popover toggle failed');
$popover->closePopover();
assertTrue($popover->open === false, 'Popover close failed');

$stepper = new UIStepperComponent('a-stepper', null, ['steps' => ['One', 'Two', 'Three']]);
$stepper->nextStep();
assertTrue($stepper->currentStep === 2, 'Stepper next failed');
$stepper->previousStep();
assertTrue($stepper->currentStep === 1, 'Stepper previous failed');
$stepper->goToStep(3);
assertTrue($stepper->currentStep === 1, 'Stepper should not jump when allowJump=false');

$dropdown = new UIDropdownComponent('a-dropdown', null, ['items' => [['value' => 'edit', 'label' => 'Edit']]]);
$dropdown->toggleDropdown();
assertTrue($dropdown->open === true, 'Dropdown toggle failed');
$dropdown->selectItem('edit');
assertTrue($dropdown->selected === 'edit' && $dropdown->open === false, 'Dropdown select failed');

$sidebar = new UISidebarComponent('a-sidebar', null, ['items' => [['value' => 'home', 'label' => 'Home']]]);
$sidebar->setActive('home');
assertTrue($sidebar->active === 'home', 'Sidebar setActive failed');
$sidebar->toggleSidebar();
assertTrue($sidebar->collapsed === true, 'Sidebar toggle failed');

$palette = new UICommandPaletteComponent('a-palette', null, ['commands' => [['value' => 'new', 'label' => 'New']]]);
$palette->togglePalette();
assertTrue($palette->open === true, 'Command palette open failed');
$palette->updateQuery('new');
assertTrue(count($palette->filteredCommands) === 1, 'Command palette filter failed');
$palette->runCommand('new');
assertTrue($palette->open === false, 'Command palette run command close failed');

$progress = new UIProgressComponent('a-progress', null, ['value' => 25, 'label' => 'Upload']);
assertTrue(str_contains($progress->template(), '25%'), 'Progress render failed');

$circular = new UIProgressComponent('a-cprogress', null, ['variant' => 'circular', 'value' => 70]);
assertTrue(str_contains($circular->template(), '70%'), 'Circular progress render failed');

$timeline = new UITimelineComponent('a-timeline', null, ['items' => [['title' => 'Created', 'description' => 'Entity created', 'time' => 'now']]]);
assertTrue(str_contains($timeline->template(), 'Created'), 'Timeline render failed');

$stat = new UIStatCardComponent('a-stat', null, ['title' => 'Revenue', 'value' => '$100', 'delta' => '+3%']);
assertTrue(str_contains($stat->template(), 'Revenue'), 'StatCard render failed');

echo "New components actions smoke test passed." . PHP_EOL;


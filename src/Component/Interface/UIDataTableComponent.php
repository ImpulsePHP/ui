<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $columns
 * @property array $rows
 * @property string $sortBy
 * @property string $sortDirection
 * @property int $page
 * @property int $perPage
 * @property string $emptyMessage
 * @property array $rowActions
 * @property string $color
 * @property bool $showPagination
 * @property string $actionsMode
 * @property array $perPageOptions
 * @property int $openRowActionMenu
 */
final class UIDataTableComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const DIRECTIONS = ['asc', 'desc'];
    private const ACTION_MODES = ['inline', 'icons', 'dropdown'];

    public function setup(): void
    {
        $this->states([
            'columns' => [],
            'rows' => [],
            'sortBy' => '',
            'sortDirection' => 'asc',
            'page' => 1,
            'perPage' => 10,
            'emptyMessage' => $this->transOrDefault('datatable.empty', 'No data available.'),
            'rowActions' => [],
            'showPagination' => true,
            'openRowActionMenu' => -1,
        ]);

        $this->perPageOptions = [5, 10, 25, 50];

        $this->state('sortDirection', 'asc', self::DIRECTIONS);
        $this->state('actionsMode', 'inline', self::ACTION_MODES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->page = 1;
    }

    #[Action]
    public function goToPage(int $page): void
    {
        $totalPages = $this->getTotalPages();
        $this->page = max(1, min($page, $totalPages));
    }

    #[Action]
    public function nextPage(): void
    {
        $this->goToPage((int) $this->page + 1);
    }

    #[Action]
    public function previousPage(): void
    {
        $this->goToPage((int) $this->page - 1);
    }

    #[Action]
    public function setPerPage(int $perPage): void
    {
        $this->perPage = max(1, $perPage);
        $this->page = 1;
    }

    #[Action]
    public function executeRowAction(string $action, int $rowIndex): void
    {
        $rows = $this->getVisibleRows();
        $row = $rows[$rowIndex] ?? null;
        $this->openRowActionMenu = -1;
        $this->emit('datatable-row-action', ['action' => $action, 'row' => $row]);
    }

    #[Action]
    public function toggleRowActionMenu(int $rowIndex): void
    {
        $this->openRowActionMenu = $this->openRowActionMenu === $rowIndex ? -1 : $rowIndex;
    }

    #[Action]
    public function closeRowActionMenu(): void
    {
        $this->openRowActionMenu = -1;
    }

    private function getSortedRows(): array
    {
        $rows = (array) $this->rows;

        if ($this->sortBy !== '') {
            usort($rows, function (array $a, array $b): int {
                $left = (string) ($a[$this->sortBy] ?? '');
                $right = (string) ($b[$this->sortBy] ?? '');
                $cmp = $left <=> $right;
                return $this->sortDirection === 'asc' ? $cmp : -$cmp;
            });
        }

        return $rows;
    }

    private function getVisibleRows(): array
    {
        $rows = $this->getSortedRows();
        $offset = (max(1, (int) $this->page) - 1) * max(1, (int) $this->perPage);
        return array_slice($rows, $offset, max(1, (int) $this->perPage));
    }

    private function getTotalPages(): int
    {
        $totalRows = count((array) $this->rows);
        return max(1, (int) ceil($totalRows / max(1, (int) $this->perPage)));
    }

    private function renderSortIcons(string $key): string
    {
        $isCurrent = $this->sortBy === $key;
        if (!$isCurrent) {
            return '';
        }

        $upClass = $this->sortDirection === 'asc' ? 'text-slate-700' : 'text-slate-300';
        $downClass = $this->sortDirection === 'desc' ? 'text-slate-700' : 'text-slate-300';

        return <<<HTML
            <span class="inline-flex flex-col leading-none ml-1">
                <uiicon name="chevron-up" size="3" class="{$upClass}" />
                <uiicon name="chevron-down" size="3" class="{$downClass}" />
            </span>
        HTML;
    }

    private function renderRowActions(int $rowIndex): string
    {
        $actions = [];
        foreach ((array) $this->rowActions as $action) {
            if (!is_array($action)) {
                continue;
            }

            $name = (string) ($action['name'] ?? 'action');
            $label = (string) ($action['label'] ?? $name);
            $icon = (string) ($action['icon'] ?? '');

            if ($this->actionsMode === 'dropdown') {
                $iconHtml = $icon !== '' ? '<uiicon name="' . $icon . '" size="4" class="text-slate-400" />' : '';
                $actions[] = '<button type="button" class="w-full px-2 py-1.5 text-left text-xs hover:bg-slate-50 inline-flex items-center gap-2" data-action-click="executeRowAction(\'' . $name . '\',' . $rowIndex . ')">' . $iconHtml . '<span>' . $label . '</span></button>';
                continue;
            }

            if ($this->actionsMode === 'icons') {
                $iconName = $icon !== '' ? $icon : 'ellipsis-horizontal';
                $actions[] = '<button type="button" class="inline-flex items-center justify-center h-7 w-7 rounded-md hover:bg-slate-50 text-' . $this->color . '-600" title="' . $label . '" data-action-click="executeRowAction(\'' . $name . '\',' . $rowIndex . ')"><uiicon name="' . $iconName . '" size="4" /></button>';
                continue;
            }

            if ($icon !== '') {
                $actions[] = '<button type="button" class="inline-flex items-center gap-1 text-xs text-' . $this->color . '-600" data-action-click="executeRowAction(\'' . $name . '\',' . $rowIndex . ')"><uiicon name="' . $icon . '" size="4" /><span>' . $label . '</span></button>';
            } else {
                $actions[] = '<button type="button" class="text-xs text-' . $this->color . '-600" data-action-click="executeRowAction(\'' . $name . '\',' . $rowIndex . ')">' . $label . '</button>';
            }
        }

        if ($this->actionsMode === 'dropdown') {
            $menu = implode('', $actions);
            $isOpen = (int) $this->openRowActionMenu === $rowIndex;
            $openClass = $isOpen ? '' : 'hidden';
            return <<<HTML
                <div class="relative inline-block">
                    <button type="button" class="h-7 w-7 inline-flex items-center justify-center rounded-md hover:bg-slate-50 text-slate-500" aria-label="actions" data-action-click="toggleRowActionMenu({$rowIndex})">
                        <uiicon name="ellipsis-horizontal" size="4" />
                    </button>
                    <div class="{$openClass} absolute right-0 bottom-full mb-1 min-w-40 max-h-56 overflow-y-auto bg-white border border-slate-200 rounded-md shadow-lg z-50 py-1" data-close-outside="self" data-close-outside-action="closeRowActionMenu">
                        {$menu}
                    </div>
                </div>
            HTML;
        }

        return '<div class="inline-flex gap-2">' . implode('', $actions) . '</div>';
    }

    public function template(): string
    {
        $columns = (array) $this->columns;
        $rows = $this->getVisibleRows();
        $actionsLabel = $this->transOrDefault('datatable.actions', 'Actions');

        if ($columns === []) {
            return '<div class="ui-data-table text-sm text-slate-500">No columns configured.</div>';
        }

        $thead = [];
        foreach ($columns as $column) {
            $key = is_array($column) ? (string) ($column['key'] ?? '') : (string) $column;
            $label = is_array($column) ? (string) ($column['label'] ?? $key) : (string) $column;
            $icons = $this->renderSortIcons($key);
            $thead[] = '<th class="px-3 py-2 text-left text-xs font-semibold uppercase text-slate-500"><button type="button" class="inline-flex items-center" data-action-click="sort(\'' . $key . '\')">' . $label . $icons . '</button></th>';
        }

        $tbody = [];
        if ($rows === []) {
            $tbody[] = '<tr><td colspan="' . (count($columns) + 1) . '" class="px-3 py-6 text-sm text-slate-500 text-center">' . $this->emptyMessage . '</td></tr>';
        } else {
            foreach ($rows as $rowIndex => $row) {
                if (!is_array($row)) {
                    continue;
                }

                $cells = [];
                foreach ($columns as $column) {
                    $key = is_array($column) ? (string) ($column['key'] ?? '') : (string) $column;
                    $cells[] = '<td class="px-3 py-2 text-sm text-slate-700">' . (string) ($row[$key] ?? '') . '</td>';
                }

                $cells[] = '<td class="px-3 py-2">' . $this->renderRowActions((int) $rowIndex) . '</td>';
                $tbody[] = '<tr class="border-t border-slate-100">' . implode('', $cells) . '</tr>';
            }
        }

        $theadHtml = implode('', $thead);
        $tbodyHtml = implode('', $tbody);

        $paginationHtml = '';
        if ($this->showPagination) {
            $totalRows = count((array) $this->rows);
            $totalPages = $this->getTotalPages();
            $from = $totalRows === 0 ? 0 : (((int) $this->page - 1) * (int) $this->perPage) + 1;
            $to = min((int) $this->page * (int) $this->perPage, $totalRows);

            $perPageButtons = [];
            foreach ((array) $this->perPageOptions as $option) {
                $opt = max(1, (int) $option);
                $class = $opt === (int) $this->perPage ? 'bg-slate-800 text-white' : 'border border-slate-300 text-slate-600';
                $perPageButtons[] = '<button type="button" class="px-2 py-1 text-xs rounded ' . $class . '" data-action-click="setPerPage(' . $opt . ')">' . $opt . '</button>';
            }
            $perPageHtml = implode('', $perPageButtons);

            $prevDisabled = (int) $this->page <= 1 ? 'opacity-50 cursor-not-allowed' : '';
            $nextDisabled = (int) $this->page >= $totalPages ? 'opacity-50 cursor-not-allowed' : '';
            $previousLabel = $this->transOrDefault('pagination.previous', 'Previous');
            $nextLabel = $this->transOrDefault('pagination.next', 'Next');

            $paginationHtml = <<<HTML
                <div class="flex flex-wrap items-center justify-between gap-2 px-3 py-2 border-t border-slate-200 bg-slate-50">
                    <p class="text-xs text-slate-500">{$from}-{$to} / {$totalRows}</p>
                    <div class="inline-flex items-center gap-1">{$perPageHtml}</div>
                    <div class="inline-flex items-center gap-1">
                        <button type="button" class="px-2 py-1 text-xs border border-slate-300 rounded {$prevDisabled}" data-action-click="previousPage()">{$previousLabel}</button>
                        <span class="text-xs text-slate-500">{$this->page} / {$totalPages}</span>
                        <button type="button" class="px-2 py-1 text-xs border border-slate-300 rounded {$nextDisabled}" data-action-click="nextPage()">{$nextLabel}</button>
                    </div>
                </div>
            HTML;
        }

        return <<<HTML
            <div class="ui-data-table overflow-visible border border-slate-200 rounded-lg bg-white">
                <table class="min-w-full">
                    <thead class="bg-slate-50"><tr>{$theadHtml}<th class="px-3 py-2 text-left text-xs font-semibold uppercase text-slate-500">{$actionsLabel}</th></tr></thead>
                    <tbody>{$tbodyHtml}</tbody>
                </table>
                {$paginationHtml}
            </div>
        HTML;
    }
}



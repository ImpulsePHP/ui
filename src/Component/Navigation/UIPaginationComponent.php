<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property int $page
 * @property int $totalPages
 * @property int $perPage
 * @property int $totalItems
 * @property int $maxVisible
 * @property bool $showSummary
 * @property string $size
 * @property string $color
 * @property string $previousLabel
 * @property string $nextLabel
 */
final class UIPaginationComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];

    public function setup(): void
    {
        $this->states([
            'page' => 1,
            'totalPages' => 1,
            'perPage' => 10,
            'totalItems' => 0,
            'maxVisible' => 7,
            'showSummary' => true,
            'previousLabel' => 'Previous',
            'nextLabel' => 'Next',
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function goToPage(int $page): void
    {
        $this->page = max(1, min($page, max(1, (int) $this->totalPages)));
        $this->emit('pagination-changed', ['page' => $this->page]);
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

    /**
     * @return array<int|string>
     */
    private function getVisiblePages(): array
    {
        $total = max(1, (int) $this->totalPages);
        $current = max(1, min((int) $this->page, $total));
        $window = max(5, (int) $this->maxVisible);

        if ($total <= $window) {
            return range(1, $total);
        }

        $result = [1];
        $side = (int) floor(($window - 3) / 2);
        $start = max(2, $current - $side);
        $end = min($total - 1, $current + $side);

        if ($start > 2) {
            $result[] = '...';
        }

        for ($i = $start; $i <= $end; $i++) {
            $result[] = $i;
        }

        if ($end < $total - 1) {
            $result[] = '...';
        }

        $result[] = $total;

        return $result;
    }

    private function getButtonPadding(): string
    {
        return match ($this->size) {
            'small' => 'px-2 py-1 text-xs',
            'large' => 'px-4 py-2.5 text-base',
            default => 'px-3 py-2 text-sm',
        };
    }

    public function template(): string
    {
        $current = max(1, min((int) $this->page, max(1, (int) $this->totalPages)));
        $pages = $this->getVisiblePages();
        $btnSize = $this->getButtonPadding();

        $prevDisabled = $current <= 1 ? 'disabled opacity-50 cursor-not-allowed' : '';
        $nextDisabled = $current >= (int) $this->totalPages ? 'disabled opacity-50 cursor-not-allowed' : '';

        $buttons = [];
        foreach ($pages as $entry) {
            if ($entry === '...') {
                $buttons[] = '<span class="px-2 text-slate-400">...</span>';
                continue;
            }

            $page = (int) $entry;
            $isActive = $page === $current;
            $classes = $isActive
                ? "{$btnSize} rounded-md bg-{$this->color}-600 text-white"
                : "{$btnSize} rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50";

            $buttons[] = <<<HTML
                <button type="button" class="{$classes}" data-action-click="goToPage({$page})">{$page}</button>
            HTML;
        }

        $summary = '';
        if ($this->showSummary && $this->totalItems > 0) {
            $from = (($current - 1) * (int) $this->perPage) + 1;
            $to = min($current * (int) $this->perPage, (int) $this->totalItems);
            $summary = <<<HTML
                <p class="text-xs text-slate-500">Showing {$from}-{$to} of {$this->totalItems}</p>
            HTML;
        }

        $buttonsHtml = implode('', $buttons);

        return <<<HTML
            <div class="ui-pagination space-y-2">
                {$summary}
                <div class="flex items-center gap-1">
                    <button type="button" class="{$btnSize} rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50 {$prevDisabled}" data-action-click="previousPage()">{$this->previousLabel}</button>
                    {$buttonsHtml}
                    <button type="button" class="{$btnSize} rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50 {$nextDisabled}" data-action-click="nextPage()">{$this->nextLabel}</button>
                </div>
            </div>
        HTML;
    }
}


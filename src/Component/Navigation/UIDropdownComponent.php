<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property array $items
 * @property bool $open
 * @property string $align
 * @property string $size
 * @property string $color
 * @property string $selected
 * @property bool $borderless
 */
final class UIDropdownComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const ALIGNS = ['left', 'right'];
    private const SIZES = ['small', 'normal', 'large'];

    public function setup(): void
    {
        $this->states([
            'label' => 'Options',
            'items' => [],
            'open' => false,
            'selected' => '',
            'borderless' => false,
        ]);

        $this->state('align', 'left', self::ALIGNS);
        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function toggleDropdown(): void
    {
        $this->open = !$this->open;
    }

    #[Action]
    public function closeDropdown(): void
    {
        $this->open = false;
    }

    #[Action]
    public function selectItem(string $value): void
    {
        $this->selected = $value;
        $this->open = false;

        $this->emit('dropdown-selected', [
            'value' => $value,
            'label' => $this->resolveLabel($value),
        ]);
    }

    private function resolveLabel(string $value): string
    {
        $resolved = $this->resolveLabelInEntries((array) $this->items, $value);
        return $resolved ?? $value;
    }

    /**
     * @param array<int, mixed> $entries
     */
    private function resolveLabelInEntries(array $entries, string $value): ?string
    {
        foreach ($entries as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            if (($entry['separator'] ?? false) || (($entry['type'] ?? '') === 'separator')) {
                continue;
            }

            if (($entry['type'] ?? '') === 'group') {
                $nested = $entry['items'] ?? [];
                if (is_array($nested)) {
                    $found = $this->resolveLabelInEntries($nested, $value);
                    if ($found !== null) {
                        return $found;
                    }
                }

                continue;
            }

            if (($entry['value'] ?? '') === $value) {
                return (string) ($entry['label'] ?? $value);
            }
        }

        return null;
    }

    private function getButtonSizeClass(): string
    {
        return match ($this->size) {
            'small' => 'px-2.5 py-1.5 text-xs',
            'large' => 'px-4 py-2.5 text-base',
            default => 'px-3 py-2 text-sm',
        };
    }

    private function renderItems(): string
    {
        return $this->renderEntries((array) $this->items);
    }

    /**
     * @param array<int, mixed> $entries
     */
    private function renderEntries(array $entries): string
    {
        $html = [];

        foreach ($entries as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            if (($entry['separator'] ?? false) || (($entry['type'] ?? '') === 'separator')) {
                $html[] = $this->renderSeparator();
                continue;
            }

            if (($entry['type'] ?? '') === 'group') {
                $html[] = $this->renderGroup($entry);
                continue;
            }

            $html[] = $this->renderItemButton($entry);
        }

        return implode('', $html);
    }

    private function renderSeparator(): string
    {
        return '<div role="separator" class="my-1 border-t border-slate-200"></div>';
    }

    /**
     * @param array<string, mixed> $group
     */
    private function renderGroup(array $group): string
    {
        $groupLabel = (string) ($group['label'] ?? '');
        $groupItems = $group['items'] ?? [];

        if (!is_array($groupItems)) {
            return '';
        }

        $labelHtml = '';
        if ($groupLabel !== '') {
            $labelHtml = <<<HTML
                <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wide text-slate-400">{$groupLabel}</div>
            HTML;
        }

        $itemsHtml = $this->renderEntries($groupItems);

        return <<<HTML
            <div class="py-1">
                {$labelHtml}
                {$itemsHtml}
            </div>
        HTML;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function renderItemButton(array $item): string
    {
        $value = (string) ($item['value'] ?? '');
        $label = (string) ($item['label'] ?? $value);
        $icon = (string) ($item['icon'] ?? '');
        $shortcut = (string) ($item['shortcut'] ?? '');
        $disabled = (bool) ($item['disabled'] ?? false);
        $active = $value === $this->selected;

        $classes = 'w-full text-left px-3 py-2 text-sm flex items-center justify-between gap-3';
        $classes .= $disabled ? ' opacity-50 cursor-not-allowed' : ' hover:bg-slate-50';
        if ($active) {
            $classes .= " bg-{$this->color}-50 text-{$this->color}-700";
        } else {
            $classes .= ' text-slate-700';
        }

        $action = ($disabled || $value === '') ? '' : "data-action-click=\"selectItem('{$value}')\"";

        $iconHtml = '';
        if ($icon !== '') {
            $iconHtml = <<<HTML
                <uiicon name="{$icon}" size="4" class="text-slate-400" />
            HTML;
        }

        $shortcutHtml = '';
        if ($shortcut !== '') {
            $shortcutHtml = <<<HTML
                <span class="text-xs text-slate-400">{$shortcut}</span>
            HTML;
        }

        $checkHtml = '';
        if ($active) {
            $checkHtml = '<uiicon name="check" size="4" class="text-current" />';
        }

        return <<<HTML
            <button type="button" class="{$classes}" {$action}>
                <span class="inline-flex items-center gap-2 min-w-0">
                    {$iconHtml}
                    <span class="truncate">{$label}</span>
                </span>
                <span class="inline-flex items-center gap-2">
                    {$shortcutHtml}
                    {$checkHtml}
                </span>
            </button>
        HTML;
    }

    public function template(): string
    {
        $buttonSize = $this->getButtonSizeClass();
        $openDisplay = $this->open ? 'block' : 'none';
        $alignClass = $this->align === 'right' ? 'right-0' : 'left-0';
        $selectedLabel = $this->selected !== '' ? $this->resolveLabel($this->selected) : $this->label;
        $items = $this->renderItems();
        $chevronRotate = $this->open ? 'rotate-180' : '';
        $buttonBorder = $this->borderless ? 'border-transparent shadow-none' : 'border-slate-300';

        $portalAlign = $this->align === 'right' ? 'bottom-right' : 'bottom-left';

        return <<<HTML
            <div class="ui-dropdown relative inline-block">
                <button id="{$this->id}-toggle" type="button" class="{$buttonSize} rounded-md border {$buttonBorder} bg-white text-slate-700 hover:bg-slate-50 inline-flex items-center gap-2" data-action-click="toggleDropdown()">
                    <span>{$selectedLabel}</span>
                    <uiicon name="chevron-down" size="4" class="text-slate-400 transition-transform {$chevronRotate}" />
                </button>
                <div style="display: {$openDisplay};" data-portal-target="body" data-portal-anchor="#{$this->id}-toggle" data-portal-align="{$portalAlign}" class="absolute {$alignClass} mt-2 w-56 bg-white border border-slate-200 rounded-md shadow-lg z-40" data-close-outside="self" data-close-outside-action="closeDropdown">
                    <div class="py-1">{$items}</div>
                </div>
            </div>
        HTML;
    }
}


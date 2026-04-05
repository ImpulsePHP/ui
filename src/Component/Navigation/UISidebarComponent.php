<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $title
 * @property array $items
 * @property string $active
 * @property bool $collapsed
 * @property bool $showToggle
 */
final class UISidebarComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'title' => $this->transOrDefault('sidebar.title', 'Navigation'),
            'items' => [],
            'active' => '',
            'collapsed' => false,
            'showToggle' => true,
        ]);
    }

    #[Action]
    public function toggleSidebar(): void
    {
        $this->collapsed = !$this->collapsed;
    }

    #[Action]
    public function setActive(string $value): void
    {
        $this->active = $value;
        $this->emit('sidebar-selected', ['value' => $value]);
    }

    public function template(): string
    {
        $width = $this->collapsed ? 'w-20' : 'w-64';

        $links = [];
        foreach ((array) $this->items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $value = (string) ($item['value'] ?? '');
            $label = (string) ($item['label'] ?? $value);
            $icon = (string) ($item['icon'] ?? '');
            $active = $value === $this->active;

            $class = $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:bg-slate-50';
            $iconHtml = $icon !== '' ? '<uiicon name="' . $icon . '" size="4" class="text-slate-400" />' : '';
            if ($this->collapsed) {
                $labelHtml = '';
                $btnClass = 'w-full flex items-center justify-center gap-2 px-2 py-2 rounded ' . $class;
            } else {
                $labelHtml = '<span>' . $label . '</span>';
                $btnClass = 'w-full flex items-center gap-2 px-3 py-2 rounded ' . $class;
            }
            $links[] = '<button type="button" class="' . $btnClass . '" data-action-click="setActive(\'' . $value . '\')">' . $iconHtml . $labelHtml . '</button>';
        }

        $linksHtml = implode('', $links);
        $toggleButton = '';
        if ($this->showToggle) {
            $toggleIcon = $this->collapsed ? 'chevron-double-right' : 'chevron-double-left';
            $toggleButton = <<<HTML
                <button type="button" class="h-7 w-7 inline-flex items-center justify-center rounded-md text-slate-500 hover:bg-slate-100" data-action-click="toggleSidebar()">
                    <uiicon name="{$toggleIcon}" size="4" />
                </button>
            HTML;
        }

        $titleHtml = $this->collapsed ? '<h3 class="text-sm font-semibold text-slate-800 truncate text-center w-full">' . $this->title . '</h3>' : '<h3 class="text-sm font-semibold text-slate-800">' . $this->title . '</h3>';

        return <<<HTML
            <aside class="ui-sidebar {$width} border-r border-slate-200 bg-white p-3 space-y-3 transition-all overflow-hidden">
                <div class="flex items-center justify-between">{$titleHtml}{$toggleButton}</div>
                <nav class="space-y-1">{$linksHtml}</nav>
            </aside>
        HTML;
    }
}


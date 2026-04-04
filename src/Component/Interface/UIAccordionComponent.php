<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $items
 * @property array $openItems
 * @property bool $multiple
 * @property bool $bordered
 * @property bool $flush
 * @property string $color
 */
final class UIAccordionComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'items' => [],
            'openItems' => [0],
            'multiple' => false,
            'bordered' => true,
            'flush' => false,
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function toggleItem(int $index): void
    {
        $openItems = $this->normalizeOpenItems($this->openItems);
        $isOpen = in_array($index, $openItems, true);

        if ($isOpen) {
            $openItems = array_values(array_filter($openItems, static fn (int $v) => $v !== $index));
        } elseif ((bool) $this->multiple) {
            $openItems[] = $index;
        } else {
            $openItems = [$index];
        }

        $this->openItems = array_values(array_unique($openItems));

        $this->emit('accordion-toggled', [
            'index' => $index,
            'isOpen' => in_array($index, $this->normalizeOpenItems($this->openItems), true),
        ]);
    }

    /**
     * @param mixed $rawOpenItems
     * @return int[]
     */
    private function normalizeOpenItems(mixed $rawOpenItems): array
    {
        if (!is_array($rawOpenItems)) {
            return [];
        }

        return array_values(array_unique(array_map(static fn (mixed $value): int => (int) $value, $rawOpenItems)));
    }

    private function getWrapperClass(): string
    {
        if ($this->flush) {
            return 'divide-y divide-slate-200';
        }

        return $this->bordered ? 'border border-slate-200 rounded-lg overflow-hidden' : '';
    }

    private function renderItem(array|string $item, int $index): string
    {
        $title = is_array($item) ? ($item['title'] ?? "Item {$index}") : (string) $item;
        $content = is_array($item) ? ($item['content'] ?? '') : '';
        $disabled = is_array($item) ? (bool) ($item['disabled'] ?? false) : false;

        $isOpen = in_array($index, $this->normalizeOpenItems($this->openItems), true);
        $panelClass = $isOpen ? 'block' : 'hidden';
        $iconRotate = $isOpen ? 'rotate-180' : '';

        $headerClass = 'w-full text-left px-4 py-3 flex items-center justify-between transition-colors';
        if ($disabled) {
            $headerClass .= ' cursor-not-allowed opacity-50';
        } else {
            $headerClass .= ' hover:bg-slate-50';
        }

        if ($isOpen) {
            $headerClass .= ' ' . TailwindColorUtility::getBackgroundClasses($this->color);
        }

        $titleClass = $isOpen ? "font-medium text-{$this->color}-700" : 'font-medium text-slate-800';
        $iconClass = $isOpen ? "text-{$this->color}-600" : 'text-slate-500';

        $action = $disabled ? '' : "data-action-click=\"toggleItem({$index})\"";

        return <<<HTML
            <div class="bg-white">
                <button type="button" class="{$headerClass}" {$action}>
                    <span class="{$titleClass}">{$title}</span>
                    <svg class="w-4 h-4 transition-transform {$iconRotate} {$iconClass}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="{$panelClass} px-4 pb-4 text-sm text-slate-600">{$content}</div>
            </div>
        HTML;
    }

    public function template(): string
    {
        $wrapperClass = $this->getWrapperClass();
        $html = [];

        foreach ((array) $this->items as $index => $item) {
            $html[] = $this->renderItem($item, (int) $index);
        }

        $content = implode('', $html);

        return <<<HTML
            <div class="ui-accordion {$wrapperClass}">
                {$content}
            </div>
        HTML;
    }
}


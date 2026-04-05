<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $items
 * @property bool $showHome
 * @property string $homeLabel
 * @property string $homeUrl
 * @property string $separator
 * @property string $color
 */
final class UIBreadcrumbComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'items' => [],
            'showHome' => true,
            'homeLabel' => 'Home',
            'homeUrl' => '#',
            'separator' => '/',
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    private function renderItem(array $item, bool $isLast): string
    {
        // allow item to be raw html or a component definition
        if (isset($item['html'])) {
            $content = (string) $item['html'];
        } elseif (isset($item['component']) && is_string($item['component'])) {
            $tag = strtolower(trim((string) $item['component']));
            $props = is_array($item['props'] ?? null) ? $item['props'] : [];
            $slot = isset($item['slot']) ? (string) $item['slot'] : '';
            $content = $this->renderComponentTag($tag, $props, $slot);
        } else {
            $label = $item['label'] ?? '';
            $url = $item['url'] ?? '#';
            if ($isLast) {
                return <<<HTML
                    <li class="text-slate-700 font-medium" aria-current="page">{$label}</li>
                HTML;
            }

            return <<<HTML
                <li>
                    <a href="{$url}" class="text-{$this->color}-600 hover:underline">{$label}</a>
                </li>
            HTML;
        }

        if ($isLast) {
            return '<li class="text-slate-700 font-medium" aria-current="page">' . $content . '</li>';
        }

        return '<li>' . $content . '</li>';
    }

    private function renderComponentTag(string $tag, array $props, string $slot = ''): string
    {
        if ($tag === '') {
            return $slot;
        }

        $attrs = [];
        foreach ($props as $key => $propValue) {
            if (!is_scalar($propValue) || $key === '') {
                continue;
            }

            $attrKey = htmlspecialchars((string) $key, ENT_QUOTES | ENT_SUBSTITUTE);
            $attrValue = htmlspecialchars((string) $propValue, ENT_QUOTES | ENT_SUBSTITUTE);
            $attrs[] = $attrKey . '="' . $attrValue . '"';
        }

        $attrString = implode(' ', $attrs);
        if ($slot === '') {
            return '<' . $tag . ($attrString !== '' ? ' ' . $attrString : '') . ' />';
        }

        return '<' . $tag . ($attrString !== '' ? ' ' . $attrString : '') . '>' . $slot . '</' . $tag . '>';
    }

    public function template(): string
    {
        $allItems = [];

        if ($this->showHome) {
            $allItems[] = ['label' => $this->homeLabel, 'url' => $this->homeUrl];
        }

        foreach ((array) $this->items as $item) {
            if (is_array($item)) {
                $allItems[] = $item;
            }
        }

        $count = count($allItems);
        $segments = [];

        foreach ($allItems as $index => $item) {
            $isLast = ($index === $count - 1);
            $segments[] = $this->renderItem($item, $isLast);

            if (!$isLast) {
                $segments[] = <<<HTML
                    <li class="text-slate-400 select-none">{$this->separator}</li>
                HTML;
            }
        }

        $content = implode('', $segments);

        return <<<HTML
            <nav class="ui-breadcrumb" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-sm">{$content}</ol>
            </nav>
        HTML;
    }
}


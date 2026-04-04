<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $items
 * @property string $color
 */
final class UITimelineComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'items' => [],
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    public function template(): string
    {
        $html = [];

        foreach ((array) $this->items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $title = (string) ($item['title'] ?? $this->transOrDefault('timeline.event', 'Event'));
            $description = (string) ($item['description'] ?? '');
            $time = (string) ($item['time'] ?? '');
            $color = (string) ($item['color'] ?? $this->color);

            $html[] = <<<HTML
                <li class="relative pl-8 pb-6">
                    <span class="absolute left-0 top-1 h-3 w-3 rounded-full bg-{$color}-500"></span>
                    <span class="absolute left-1.5 top-4 bottom-0 w-px bg-slate-200"></span>
                    <p class="text-xs text-slate-400">{$time}</p>
                    <p class="text-sm font-semibold text-slate-800">{$title}</p>
                    <p class="text-sm text-slate-600">{$description}</p>
                </li>
            HTML;
        }

        $content = implode('', $html);
        return '<ul class="ui-timeline">' . $content . '</ul>';
    }
}

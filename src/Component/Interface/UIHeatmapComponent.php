<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

final class UIHeatmapComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'data' => [],
            'id' => uniqid('heat', true)
        ]);

        $this->state('color', 'slate', TailwindColorUtility::getAllColors());
    }

    public function template(): string
    {
        $cells = [];

        $c = $this->color;
        $palette = ["{$c}-50", "{$c}-200", "{$c}-400", "{$c}-600", "{$c}-800"];

        foreach ((array) $this->data as $d) {
            $val = max(0, (int) ($d['v'] ?? 0));
            $idx = min(count($palette) - 1, $val);
            $colorEntry = $palette[$idx] ?? $palette[0];
            $label = htmlspecialchars((string) ($d['label'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE);

            $safeClass = htmlspecialchars((string) $colorEntry, ENT_QUOTES | ENT_SUBSTITUTE);
            $cells[] = "<div class=\"w-4 h-4 rounded-sm m-0.5 bg-{$safeClass}\" title=\"{$label}: {$val}\"></div>";
        }

        $html = implode('', $cells);

        return <<<HTML
            <div class="ui-heatmap flex flex-wrap w-full max-w-xl" id="{$this->id}">
                {$html}
            </div>
        HTML;
    }
}





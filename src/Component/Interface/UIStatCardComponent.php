<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $title
 * @property string $value
 * @property string $delta
 * @property string $icon
 * @property string $color
 * @property bool $positive
 */
final class UIStatCardComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'title' => $this->transOrDefault('stat_card.metric', 'Metric'),
            'value' => '0',
            'delta' => '',
            'icon' => '',
            'positive' => true,
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    public function template(): string
    {
        $deltaClass = $this->positive ? 'text-emerald-600' : 'text-red-600';
        $icon = $this->icon !== '' ? '<uiicon name="' . $this->icon . '" size="5" class="text-' . $this->color . '-600" />' : '';

        return <<<HTML
            <div class="ui-stat-card rounded-lg border border-slate-200 bg-white p-4 space-y-2">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">{$this->title}</p>
                    {$icon}
                </div>
                <p class="text-2xl font-bold text-slate-800">{$this->value}</p>
                <p class="text-xs {$deltaClass}">{$this->delta}</p>
            </div>
        HTML;
    }
}

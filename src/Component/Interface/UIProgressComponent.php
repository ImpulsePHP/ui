<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property int $value
 * @property int $max
 * @property bool $showLabel
 * @property string $label
 * @property string $color
 * @property string $size
 * @property string $variant
 * @property int $circleSize
 * @property int $circleStroke
 */
final class UIProgressComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const VARIANTS = ['linear', 'circular'];

    public function setup(): void
    {
        $this->states([
            'value' => 0,
            'max' => 100,
            'showLabel' => true,
            'label' => $this->transOrDefault('progress.label', 'Progress'),
            'size' => 'normal',
            'circleSize' => 96,
            'circleStroke' => 8,
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('variant', 'linear', self::VARIANTS);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    public function template(): string
    {
        $max = max(1, (int) $this->max);
        $value = max(0, min((int) $this->value, $max));
        $percent = (int) round(($value / $max) * 100);

        if ($this->variant === 'circular') {
            $size = max(40, (int) $this->circleSize);
            $stroke = max(2, (int) $this->circleStroke);
            $center = $size / 2;
            $radius = $center - $stroke;
            $circ = 2 * pi() * $radius;
            $offset = $circ - (($percent / 100) * $circ);
            $label = $this->showLabel
                ? '<span class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-slate-700">' . $percent . '%</span>'
                : '';

            return <<<HTML
                <div class="ui-progress relative inline-flex" style="width: {$size}px; height: {$size}px;">
                    <svg width="{$size}" height="{$size}" viewBox="0 0 {$size} {$size}">
                        <circle cx="{$center}" cy="{$center}" r="{$radius}" fill="none" stroke="#e2e8f0" stroke-width="{$stroke}" />
                        <circle cx="{$center}" cy="{$center}" r="{$radius}" fill="none" stroke="currentColor" stroke-width="{$stroke}"
                            class="text-{$this->color}-600" stroke-dasharray="{$circ}" stroke-dashoffset="{$offset}"
                            stroke-linecap="round" transform="rotate(-90 {$center} {$center})" />
                    </svg>
                    {$label}
                </div>
            HTML;
        }

        $height = match ($this->size) {
            'small' => 'h-1.5',
            'large' => 'h-4',
            default => 'h-2.5',
        };

        $label = $this->showLabel ? '<div class="mb-1 text-xs text-slate-600">' . $this->label . ' (' . $percent . '%)</div>' : '';

        return <<<HTML
            <div class="ui-progress">
                {$label}
                <div class="w-full {$height} rounded-full bg-slate-200 overflow-hidden">
                    <div class="h-full bg-{$this->color}-600 transition-all" style="width: {$percent}%"></div>
                </div>
            </div>
        HTML;
    }
}


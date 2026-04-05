<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property int $lines
 * @property bool $animated
 * @property bool $avatar
 * @property string $shape
 * @property string $width
 * @property string $height
 */
final class UISkeletonComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SHAPES = ['rounded', 'square', 'pill'];

    public function setup(): void
    {
        $this->states([
            'lines' => 3,
            'animated' => true,
            'avatar' => false,
            'width' => 'w-full',
            'height' => 'h-4',
        ]);

        $this->state('shape', 'rounded', self::SHAPES);
    }

    private function getShapeClass(): string
    {
        return match ($this->shape) {
            'square' => 'rounded-none',
            'pill' => 'rounded-full',
            default => 'rounded-md',
        };
    }

    private function renderLines(): string
    {
        $shape = $this->getShapeClass();
        $animate = $this->animated ? 'animate-pulse' : '';
        $useHeight = $this->height;
        if ($this->shape === 'pill' && $this->height === 'h-4') {
            $useHeight = 'h-6';
        }
        $lines = [];

        for ($i = 0; $i < max(1, (int) $this->lines); $i++) {
            $lineWidth = match (true) {
                $i === 0 => $this->width,
                $i % 3 === 0 => 'w-5/6',
                $i % 2 === 0 => 'w-3/4',
                default => 'w-full',
            };

            $lines[] = <<<HTML
                <div class="{$lineWidth} {$useHeight} {$shape} bg-slate-200 {$animate}"></div>
            HTML;
        }

        return implode('', $lines);
    }

    private function renderAvatar(): string
    {
        if (!$this->avatar) {
            return '';
        }

        $animate = $this->animated ? 'animate-pulse' : '';

        return <<<HTML
            <div class="h-10 w-10 rounded-full bg-slate-200 {$animate} mt-0.5"></div>
        HTML;
    }

    public function template(): string
    {
        $avatar = $this->renderAvatar();
        $lines = $this->renderLines();

        return <<<HTML
            <div class="ui-skeleton flex gap-3" role="status" aria-label="Loading">
                {$avatar}
                <div class="w-full space-y-2">{$lines}</div>
            </div>
        HTML;
    }
}


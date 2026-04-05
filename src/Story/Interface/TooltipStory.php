<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UITooltipComponent;
use Impulse\UI\Utility\TailwindColorUtility;

final class TooltipStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Tooltip'; }
    public function description(): string { return 'Tooltip positions et affichage.'; }
    public function componentClass(): string { return UITooltipComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'text' => 'Helpful information',
            // position default + allowed values for dropdown in story UI
            'position' => 'top',
            'open' => false,
            '__slot' => 'Hover target',
            'underline' => false,
            // underlineColor: default + allowed tailwind colors
            'underlineColor' => 'slate',
        ];
    }

    public function variants(): array
    {
        return [
            'top' => [],
            'bottom' => ['position' => 'bottom'],
            'left' => ['position' => 'left'],
            'right' => ['position' => 'right'],
            'always open' => ['open' => true],
            'underline hex color' => ['underline' => true, 'underlineColor' => '#ef4444'],
            'underline tailwind color' => ['underline' => true, 'underlineColor' => 'indigo'],
        ];
    }
}


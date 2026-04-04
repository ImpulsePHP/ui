<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UITooltipComponent;

final class TooltipStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Tooltip'; }
    public function description(): string { return 'Tooltip positions et affichage.'; }
    public function componentClass(): string { return UITooltipComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['text' => 'Helpful information', 'position' => 'top', 'open' => true, '__slot' => 'Hover target'];
    }

    public function variants(): array
    {
        return [
            'top' => [],
            'bottom' => ['position' => 'bottom'],
            'left' => ['position' => 'left'],
            'right' => ['position' => 'right'],
        ];
    }
}


<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIPopoverComponent;

final class PopoverStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Popover'; }
    public function description(): string { return 'Popover avec titre et contenu.'; }
    public function componentClass(): string { return UIPopoverComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['title' => 'Actions', 'content' => 'Popover details.', 'position' => 'bottom', 'open' => true, '__slot' => 'Open popover'];
    }

    public function variants(): array
    {
        return [
            'bottom' => [],
            'top' => ['position' => 'top'],
            'left' => ['position' => 'left'],
            'right' => ['position' => 'right'],
        ];
    }
}


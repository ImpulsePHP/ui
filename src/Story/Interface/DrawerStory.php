<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIDrawerComponent;

final class DrawerStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Drawer'; }
    public function description(): string { return 'Panneau lateral slide-in.'; }
    public function componentClass(): string { return UIDrawerComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['title' => 'Details', 'content' => 'Drawer content.', 'open' => true, 'side' => 'right'];
    }

    public function variants(): array
    {
        return [
            'right' => [],
            'left' => ['side' => 'left'],
            'closed' => ['open' => false],
            'fixed backdrop close disabled' => ['closeOnBackdrop' => false],
        ];
    }
}


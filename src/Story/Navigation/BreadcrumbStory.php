<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UIBreadcrumbComponent;

final class BreadcrumbStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string
    {
        return 'Breadcrumb';
    }

    public function description(): string
    {
        return 'Composant fil d ariane pour la navigation hiérarchique.';
    }

    public function componentClass(): string
    {
        return UIBreadcrumbComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'showHome' => true,
            'homeLabel' => 'Home',
            'homeUrl' => '#',
            'separator' => '/',
            'color' => 'indigo',
            'items' => [
                ['label' => 'Projects', 'url' => '#'],
                ['label' => 'Impulse UI', 'url' => '#'],
                ['label' => 'Settings', 'url' => '#'],
            ],
        ];
    }

    public function variants(): array
    {
        return [
            'default' => [],
            'without home' => [
                'showHome' => false,
            ],
            'chevron separator' => [
                'separator' => '>',
                'color' => 'blue',
            ],
            'dot separator' => [
                'separator' => '.',
                'color' => 'slate',
            ],
            'short path' => [
                'items' => [
                    ['label' => 'Library', 'url' => '#'],
                    ['label' => 'Books', 'url' => '#'],
                ],
            ],
        ];
    }
}


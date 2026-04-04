<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UISkeletonComponent;

final class SkeletonStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Skeleton';
    }

    public function description(): string
    {
        return 'Composant skeleton pour placeholders de chargement visuels.';
    }

    public function componentClass(): string
    {
        return UISkeletonComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'lines' => 3,
            'animated' => true,
            'avatar' => false,
            'shape' => 'rounded',
            'width' => 'w-full',
            'height' => 'h-4',
        ];
    }

    public function variants(): array
    {
        return [
            'basic' => [],
            'with avatar' => [
                'avatar' => true,
                'lines' => 4,
            ],
            'pill lines' => [
                'shape' => 'pill',
                'height' => 'h-3',
            ],
            'large lines' => [
                'lines' => 5,
                'height' => 'h-5',
            ],
            'static no animation' => [
                'animated' => false,
                'lines' => 2,
            ],
        ];
    }
}


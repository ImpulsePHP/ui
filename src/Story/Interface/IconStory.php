<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIIconComponent;

final class IconStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Icon';
    }

    public function description(): string
    {
        return 'Composant d\'icône utilisant la bibliothèque Heroicons. Supporte tous les variants : outline, solid, mini, micro.';
    }

    public function componentClass(): string
    {
        return UIIconComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'name' => 'home',
            'variant' => 'outline',
            'size' => 'auto',
            'iconClass' => '',
        ];
    }

    public function variants(): array
    {
        return [
            'home solid' => [
                'name' => 'home',
                'variant' => 'solid',
            ],
            'user mini' => [
                'name' => 'user',
                'variant' => 'mini',
            ],
            'heart micro' => [
                'name' => 'heart',
                'variant' => 'micro',
            ],
            'shopping-cart' => [
                'name' => 'shopping-cart',
                'variant' => 'outline',
            ],
            'check-circle solid' => [
                'name' => 'check-circle',
                'variant' => 'solid',
                'iconClass' => 'text-green-500',
            ],
            'x-mark error' => [
                'name' => 'x-mark',
                'variant' => 'solid',
                'iconClass' => 'text-red-500',
            ],
            'large size' => [
                'name' => 'star',
                'variant' => 'solid',
                'size' => 'auto',
                'iconClass' => 'text-yellow-500 h-70 w-70',
            ],
        ];
    }
}

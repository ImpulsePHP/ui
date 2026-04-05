<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UITreeViewComponent;

final class TreeViewStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'TreeView'; }
    public function description(): string { return 'Nested tree view.'; }
    public function componentClass(): string { return UITreeViewComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'items' => [
                ['id' => 'root', 'label' => 'Root', 'children' => [
                    ['id' => 'a', 'label' => 'Child A'],
                    ['id' => 'b', 'label' => 'Child B', 'children' => [
                        ['id' => 'b1', 'label' => 'Child B1']
                    ]]
                ]]
            ],
        ];
    }

    public function variants(): array
    {
        return [ 'default' => [] ];
    }
}


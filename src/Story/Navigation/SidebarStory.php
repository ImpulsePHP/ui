<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UISidebarComponent;

final class SidebarStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string { return 'Sidebar'; }
    public function description(): string { return 'Navigation laterale d application.'; }
    public function componentClass(): string { return UISidebarComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'title' => 'Workspace',
            'active' => 'dashboard',
            'items' => [
                ['value' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                ['value' => 'projects', 'label' => 'Projects', 'icon' => 'folder-open'],
                ['value' => 'settings', 'label' => 'Settings', 'icon' => 'cog-6-tooth'],
            ],
        ];
    }

    public function variants(): array
    {
        return [
            'default' => [],
            'collapsed' => [
                'collapsed' => true,
            ],
            'active settings' => ['active' => 'settings'],
            'without toggle' => [
                'showToggle' => false,
            ],
        ];
    }
}

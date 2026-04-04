<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIModalComponent;

final class ModalStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Modal';
    }

    public function description(): string
    {
        return 'Composant modal pour confirmations, formulaires rapides et contenus detail.';
    }

    public function componentClass(): string
    {
        return UIModalComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'title' => 'Delete item',
            'content' => 'This action cannot be undone.',
            'open' => true,
            'size' => 'normal',
            'color' => 'indigo',
            'closeOnBackdrop' => true,
            'showFooter' => true,
            'confirmLabel' => 'Delete',
            'cancelLabel' => 'Cancel',
            'confirmColor' => 'red',
        ];
    }

    public function variants(): array
    {
        return [
            'confirmation' => [
                'title' => 'Archive project',
                'content' => 'Archive this project and move it to history.',
                'confirmLabel' => 'Archive',
                'confirmColor' => 'amber',
            ],
            'small info modal' => [
                'size' => 'small',
                'title' => 'Maintenance',
                'content' => 'Scheduled maintenance starts at 22:00.',
                'showFooter' => false,
            ],
            'large content modal' => [
                'size' => 'large',
                'title' => 'Terms update',
                'content' => 'Please review the new terms before continuing.',
                '__slot' => '<ul class="list-disc pl-5 text-sm"><li>New privacy section</li><li>Updated retention policy</li></ul>',
                'confirmColor' => 'indigo',
            ],
            'xl modal' => [
                'size' => 'xl',
                'title' => 'Release notes',
                'content' => 'Version 2.0 introduces tabs, modals, dropdowns and many UI upgrades.',
                'showFooter' => false,
            ],
            'no close on backdrop' => [
                'title' => 'Session expired',
                'content' => 'Clicking outside does not close this modal.',
                'closeOnBackdrop' => false,
                'confirmLabel' => 'Reconnect',
                'confirmColor' => 'blue',
            ],
        ];
    }
}


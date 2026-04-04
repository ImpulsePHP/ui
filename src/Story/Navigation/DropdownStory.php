<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UIDropdownComponent;

final class DropdownStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string
    {
        return 'Dropdown';
    }

    public function description(): string
    {
        return 'Composant menu dropdown pour actions contextuelles et selecteurs rapides.';
    }

    public function componentClass(): string
    {
        return UIDropdownComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => 'Actions',
            'items' => [
                ['value' => 'edit', 'label' => 'Edit', 'icon' => 'pencil-square', 'shortcut' => 'E'],
                ['value' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'document-duplicate', 'shortcut' => 'Cmd+D'],
                ['value' => 'archive', 'label' => 'Archive', 'icon' => 'archive-box', 'shortcut' => 'A'],
            ],
            'open' => true,
            'align' => 'left',
            'size' => 'normal',
            'color' => 'indigo',
            'selected' => '',
        ];
    }

    public function variants(): array
    {
        return [
            'default left' => [],
            'right aligned' => [
                'align' => 'right',
            ],
            'with selection' => [
                'selected' => 'archive',
                'color' => 'blue',
            ],
            'without icons and shortcuts' => [
                'items' => [
                    ['value' => 'open', 'label' => 'Open'],
                    ['value' => 'rename', 'label' => 'Rename'],
                    ['value' => 'delete', 'label' => 'Delete'],
                ],
            ],
            'small trigger' => [
                'size' => 'small',
                'label' => 'Quick',
            ],
            'small borderless' => [
                'size' => 'small',
                'borderless' => true,
                'label' => 'Actions',
            ],
            'large trigger' => [
                'size' => 'large',
                'label' => 'Project actions',
                'color' => 'green',
            ],
            'with disabled option' => [
                'items' => [
                    ['value' => 'rename', 'label' => 'Rename', 'icon' => 'pencil-square', 'shortcut' => 'R'],
                    ['value' => 'publish', 'label' => 'Publish', 'icon' => 'arrow-up-tray', 'shortcut' => 'P'],
                    ['value' => 'delete', 'label' => 'Delete permanently', 'icon' => 'trash', 'shortcut' => 'Del', 'disabled' => true],
                ],
                'color' => 'red',
            ],
            'with separators' => [
                'items' => [
                    ['value' => 'edit', 'label' => 'Edit', 'icon' => 'pencil-square', 'shortcut' => 'E'],
                    ['value' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'document-duplicate', 'shortcut' => 'Cmd+D'],
                    ['separator' => true],
                    ['value' => 'archive', 'label' => 'Archive', 'icon' => 'archive-box', 'shortcut' => 'A'],
                    ['value' => 'move', 'label' => 'Move to...', 'icon' => 'folder-open', 'shortcut' => 'M'],
                    ['type' => 'separator'],
                    ['value' => 'delete', 'label' => 'Delete', 'icon' => 'trash', 'shortcut' => 'Del'],
                ],
            ],
            'with groups and separators' => [
                'items' => [
                    [
                        'type' => 'group',
                        'label' => 'File',
                        'items' => [
                            ['value' => 'new', 'label' => 'New file', 'icon' => 'document-plus', 'shortcut' => 'Cmd+N'],
                            ['value' => 'open', 'label' => 'Open file', 'icon' => 'folder-open', 'shortcut' => 'Cmd+O'],
                        ],
                    ],
                    ['separator' => true],
                    [
                        'type' => 'group',
                        'label' => 'Share',
                        'items' => [
                            ['value' => 'invite', 'label' => 'Invite', 'icon' => 'user-plus', 'shortcut' => 'I'],
                            ['value' => 'copy-link', 'label' => 'Copy link', 'icon' => 'link', 'shortcut' => 'Cmd+L'],
                        ],
                    ],
                ],
                'selected' => 'copy-link',
            ],
        ];
    }
}


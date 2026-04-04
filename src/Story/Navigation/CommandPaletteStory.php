<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UICommandPaletteComponent;

final class CommandPaletteStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string { return 'CommandPalette'; }
    public function description(): string { return 'Palette de commandes type Cmd+K.'; }
    public function componentClass(): string { return UICommandPaletteComponent::class; }

    protected function getBaseArgs(): array
    {
        $commands = [
            ['value' => 'new-file', 'label' => 'New file', 'shortcut' => 'Cmd+N'],
            ['value' => 'open-settings', 'label' => 'Open settings', 'shortcut' => 'Cmd+,'],
            ['value' => 'invite', 'label' => 'Invite member', 'shortcut' => 'I'],
        ];

        return ['open' => true, 'commands' => $commands, 'filteredCommands' => $commands, 'query' => ''];
    }

    public function variants(): array
    {
        return [
            'open' => [],
            'closed' => ['open' => false],
            'filtered' => ['query' => 'open', 'filteredCommands' => [['value' => 'open-settings', 'label' => 'Open settings', 'shortcut' => 'Cmd+,']]],
        ];
    }
}


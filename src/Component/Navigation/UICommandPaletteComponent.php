<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property bool $open
 * @property string $query
 * @property array $commands
 * @property array $filteredCommands
 */
final class UICommandPaletteComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'open' => false,
            'query' => '',
            'commands' => [],
            'filteredCommands' => [],
        ]);

        $this->filteredCommands = $this->commands;
    }

    #[Action]
    public function togglePalette(): void
    {
        $this->open = !$this->open;
    }

    #[Action]
    public function closePalette(): void
    {
        $this->open = false;
    }

    #[Action]
    public function updateQuery(string $queryOrField, ?string $value = null): void
    {
        $query = $value ?? $queryOrField;
        $this->query = $query;
        $q = strtolower($query);

        $this->filteredCommands = array_values(array_filter((array) $this->commands, static function ($command) use ($q): bool {
            if (!is_array($command)) {
                return false;
            }
            $label = strtolower((string) ($command['label'] ?? ''));
            return $q === '' || str_contains($label, $q);
        }));
    }

    #[Action]
    public function runCommand(string $value): void
    {
        $this->emit('command-executed', ['value' => $value]);
        $this->open = false;
    }

    public function template(): string
    {
        $hidden = $this->open ? '' : 'hidden';
        $toggleLabel = $this->transOrDefault('command_palette.trigger', 'Cmd+K');
        $placeholder = $this->transOrDefault('command_palette.placeholder', 'Type a command...');

        $commands = [];
        foreach ((array) $this->filteredCommands as $command) {
            if (!is_array($command)) {
                continue;
            }

            $value = (string) ($command['value'] ?? '');
            $label = (string) ($command['label'] ?? $value);
            $shortcut = (string) ($command['shortcut'] ?? '');
            $commands[] = '<button type="button" class="w-full flex items-center justify-between px-3 py-2 text-sm hover:bg-slate-50" data-action-click="runCommand(\'' . $value . '\')"><span>' . $label . '</span><span class="text-xs text-slate-400">' . $shortcut . '</span></button>';
        }

        $commandsHtml = implode('', $commands);

        return <<<HTML
            <div class="ui-command-palette">
                <button type="button" class="px-3 py-2 text-sm border border-slate-300 rounded-md" data-action-click="togglePalette()">{$toggleLabel}</button>
                <div class="{$hidden} fixed inset-0 z-50">
                    <div class="absolute inset-0 bg-slate-900/40" data-action-click="closePalette()"></div>
                    <div class="relative z-10 max-w-xl mx-auto mt-24 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
                        <input type="text" name="command_query" value="{$this->query}" class="w-full px-4 py-3 border-b border-slate-100" placeholder="{$placeholder}" data-action-input="updateQuery(command_query)" />
                        <div class="max-h-72 overflow-auto">{$commandsHtml}</div>
                    </div>
                </div>
            </div>
        HTML;
    }
}


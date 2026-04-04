<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $title
 * @property string $content
 * @property string $position
 * @property bool $open
 */
final class UIPopoverComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const POSITIONS = ['top', 'bottom', 'left', 'right'];

    public function setup(): void
    {
        $this->states([
            'title' => $this->transOrDefault('popover.title', 'Popover'),
            'content' => '',
            'position' => 'bottom',
            'open' => false,
        ]);

        $this->state('position', 'bottom', self::POSITIONS);
    }

    #[Action]
    public function togglePopover(): void
    {
        $this->open = !$this->open;
    }

    #[Action]
    public function closePopover(): void
    {
        $this->open = false;
    }

    public function template(): string
    {
        $hidden = $this->open ? '' : 'hidden';
        $position = match ($this->position) {
            'top' => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
            'left' => 'right-full mr-2 top-1/2 -translate-y-1/2',
            'right' => 'left-full ml-2 top-1/2 -translate-y-1/2',
            default => 'top-full mt-2 left-1/2 -translate-x-1/2',
        };
        $trigger = $this->slot();
        if ($trigger === '') {
            $trigger = $this->transOrDefault('popover.trigger', 'Toggle popover');
        }

        return <<<HTML
            <div class="ui-popover relative inline-block">
                <button type="button" class="px-3 py-2 text-sm border border-slate-300 rounded-md" data-action-click="togglePopover()">
                    {$trigger}
                </button>
                <div class="{$hidden} absolute {$position} z-30 w-64 bg-white border border-slate-200 rounded-lg shadow-lg">
                    <div class="px-3 py-2 border-b border-slate-100 text-sm font-semibold text-slate-800">{$this->title}</div>
                    <div class="px-3 py-2 text-sm text-slate-700">{$this->content}</div>
                </div>
            </div>
        HTML;
    }
}

<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $text
 * @property string $position
 * @property bool $open
 */
final class UITooltipComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const POSITIONS = ['top', 'bottom', 'left', 'right'];

    public function setup(): void
    {
        $this->states([
            'text' => $this->transOrDefault('tooltip.text', 'Tooltip'),
            'position' => 'top',
            'open' => false,
        ]);

        $this->state('position', 'top', self::POSITIONS);
    }

    #[Action]
    public function show(): void
    {
        $this->open = true;
    }

    #[Action]
    public function hide(): void
    {
        $this->open = false;
    }

    #[Action]
    public function toggle(): void
    {
        $this->open = !$this->open;
    }

    public function template(): string
    {
        $hidden = $this->open ? '' : 'hidden';
        $position = match ($this->position) {
            'bottom' => 'top-full mt-2 left-1/2 -translate-x-1/2',
            'left' => 'right-full mr-2 top-1/2 -translate-y-1/2',
            'right' => 'left-full ml-2 top-1/2 -translate-y-1/2',
            default => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
        };
        $trigger = $this->slot();
        if ($trigger === '') {
            $trigger = $this->transOrDefault('tooltip.trigger', 'Hover me');
        }

        return <<<HTML
            <div class="ui-tooltip relative inline-block" data-action-click="toggle()">
                <span class="inline-block">{$trigger}</span>
                <div class="{$hidden} absolute {$position} whitespace-nowrap rounded-md bg-slate-800 text-white text-xs px-2 py-1 z-20">
                    {$this->text}
                </div>
            </div>
        HTML;
    }
}

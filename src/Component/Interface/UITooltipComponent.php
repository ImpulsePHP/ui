<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

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
            'open' => false,
            'underline' => false,
        ]);

        $this->state('position', 'top', self::POSITIONS);
        $this->state('underlineColor', 'slate', TailwindColorUtility::getAllColors());
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
        $visibilityClass = $this->open
            ? 'block opacity-100 visible'
            : 'hidden opacity-0 group-hover:block group-hover:opacity-100 group-hover:visible';
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

        $underlineClass = '';
        $underlineStyle = '';
        if ($this->underline) {
            $c = (string) $this->underlineColor;
            if (str_starts_with($c, '#')) {
                $cEsc = htmlspecialchars($c, ENT_QUOTES | ENT_SUBSTITUTE);
                $underlineStyle = "style=\"text-decoration: underline; text-decoration-style: dashed; text-decoration-color: {$cEsc}; text-underline-offset: 3px;\"";
            } else {
                $underlineClass = ' border-b border-dashed ' . TailwindColorUtility::getBorderClasses($c);
            }
        }
        $ariaExpanded = $this->open ? 'true' : 'false';

        return <<<HTML
            <div class="ui-tooltip group relative inline-block" tabindex="0" role="button" aria-expanded="{$ariaExpanded}" data-action-mouseenter="show()" data-action-mouseleave="hide()">
                <span class="inline-block{$underlineClass}" {$underlineStyle} data-action-click="toggle()" data-action-focus="show()" data-action-blur="hide()">{$trigger}</span>
                <div class="absolute {$position} {$visibilityClass} whitespace-nowrap rounded-md bg-slate-800 text-white text-xs px-2 py-1 z-20 transition-opacity duration-150">
                    {$this->text}
                </div>
            </div>
        HTML;
    }
}

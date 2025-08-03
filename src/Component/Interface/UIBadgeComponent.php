<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property string $color
 * @property string $variant
 * @property string $shape
 * @property bool $dot
 * @property string $dotColor
 * @property bool $pulse
 * @property bool $withClose
 * @property bool $dismissible
 */
final class UIBadgeComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const VARIANTS = ['filled', 'outline', 'soft', 'solid'];
    private const SHAPES = ['rounded', 'pill', 'square'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'dot' => false,
            'pulse' => false,
            'withClose' => false,
            'dismissible' => false,
        ]);

        $this->state('color', 'slate', TailwindColorUtility::getAllColors());
        $this->state('dotColor', 'slate', TailwindColorUtility::getAllColors());
        $this->state('variant', 'filled', self::VARIANTS);
        $this->state('shape', 'rounded', self::SHAPES);
    }

    #[Action]
    public function dismiss(): void
    {
        $this->emit('badge-removed', [
            'label' => $this->label,
            'color' => $this->color,
        ]);
    }

    private function getBaseClasses(): string
    {
        $shapeClasses = match ($this->shape) {
            'pill' => 'rounded-full',
            'square' => 'rounded-none',
            default => 'rounded-md',
        };

        $variantClasses = $this->getVariantClasses();
        $baseClasses = 'inline-flex items-center gap-1.5 whitespace-nowrap text-xs py-1 px-2';

        return "{$baseClasses} {$shapeClasses} {$variantClasses}";
    }

    private function getVariantClasses(): string
    {
        return match ($this->variant) {
            'outline' => TailwindColorUtility::getBadgeOutlineClasses($this->color),
            'soft' => TailwindColorUtility::getBadgeSoftClasses($this->color),
            'solid' => TailwindColorUtility::getBadgeSolidClasses($this->color),
            default => TailwindColorUtility::getBadgeColor($this->color),
        };
    }

    private function getDotClasses(): string
    {
        $dotColor = $this->dotColor ?: $this->color;
        $colorClasses = TailwindColorUtility::getDotClasses($dotColor);
        $pulseClasses = $this->pulse ? 'animate-pulse' : '';

        return "rounded-full {$colorClasses} {$pulseClasses} h-2 w-2";
    }

    private function renderDot(): string
    {
        if (!$this->dot) {
            return '';
        }

        $dotClasses = $this->getDotClasses();

        return <<<HTML
            <span class="{$dotClasses}"></span>
        HTML;
    }

    private function renderRemoveButton(): string
    {
        if (!$this->withClose && !$this->dismissible) {
            return '';
        }

        $action = $this->dismissible ? 'data-action-click="dismiss()"' : 'data-toggle-class="hidden" data-target="#' . $this->getComponentId() . '"';

        return <<<HTML
            <div
                class="cursor-pointer my-auto opacity-65 transition-opacity duration-300 hover:opacity-100"
                {$action}
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                  <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        HTML;
    }

    public function template(): string
    {
        $baseClasses = $this->getBaseClasses();
        $dot = $this->renderDot();
        $removeButton = $this->renderRemoveButton();

        return <<<HTML
            <span class="ui-badge {$baseClasses}" id="{$this->getComponentId()}">
                {$dot}
                <span>{$this->label}</span>
                {$removeButton}
            </span>
        HTML;
    }
}

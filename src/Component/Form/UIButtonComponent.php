<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property string $type
 * @property string $color
 * @property string $variant
 * @property string $size
 * @property bool $block
 * @property bool $disabled
 * @property string $iconName
 * @property string $iconPosition
 * @property string $iconSize
 * @property string $iconVariant
 */
final class UIButtonComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const TYPES = ['button', 'submit'];
    private const SIZES = ['small', 'normal', 'large'];
    private const VARIANTS = ['filled', 'soft', 'solid', 'outline', 'ghost', 'link'];
    private const ICON_VARIANTS = ['outline', 'solid', 'mini', 'micro'];
    private const ICON_POSITIONS = ['left', 'right'];

    /**
     * @throws \ReflectionException
     */
    public function setup(): void
    {
        $this->states([
            'label' => $this->trans('button.label'),
            'block' => false,
            'disabled' => false,
            'iconName' => '',
        ]);

        $this->state('type', 'button', self::TYPES);
        $this->state('size', 'normal', self::SIZES);
        $this->state('variant', 'filled', self::VARIANTS);
        $this->state('iconPosition', 'left', self::ICON_POSITIONS);
        $this->state('iconSize', 'normal', self::SIZES);
        $this->state('iconVariant', 'outline', self::ICON_VARIANTS);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    private function getButtonClasses(): string
    {
        $classes = [];
        $classes[] = 'flex items-center justify-center gap-2 py-2 transition-all duration-350 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2';
        $classes[] = $this->getColorClasses();
        $classes[] = TailwindColorUtility::getSizeClasses($this->size, 'button');

        if ($this->block) {
            $classes[] = 'w-full';
        }

        if ($this->disabled) {
            $classes[] = TailwindColorUtility::getStateClasses('disabled');
        } else {
            $classes[] = 'cursor-pointer';
        }

        return implode(' ', $classes);
    }

    private function getColorClasses(): string
    {
        return TailwindColorUtility::getButtonClasses($this->color, $this->variant);
    }

    private function getIconSize(): string
    {
        return match ($this->iconSize) {
            'small' => '4',
            'large' => '6',
            default => '5',
        };
    }

    private function renderIcon(): string
    {
        if (empty($this->iconName)) {
            return '';
        }

        return <<<HTML
            <uiicon
                name="{$this->iconName}"
                variant="{$this->iconVariant}"
                size="{$this->getIconSize()}"
            />
        HTML;
    }

    public function template(): string
    {
        $classes = $this->getButtonClasses();
        $icon = $this->renderIcon();

        if ($this->iconPosition === 'right') {
            $leftContent = '';
            $rightContent = $icon;
        } else {
            $leftContent = $icon;
            $rightContent = '';
        }

        $disabledAttribute = $this->disabled ? 'disabled' : '';

        return <<<HTML
            <button type="{$this->type}" class="ui-button {$classes}" {$disabledAttribute}>
                {$leftContent}
                {$this->label}
                {$rightContent}
            </button>
        HTML;
    }
}

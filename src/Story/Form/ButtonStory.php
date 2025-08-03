<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UIButtonComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class ButtonStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Form';

    public function name(): string
    {
        return 'Button';
    }

    public function description(): string
    {
        return 'Bouton interactif avec support de toutes les couleurs Tailwind et 5 variantes différentes.';
    }

    public function componentClass(): string
    {
        return UIButtonComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'type' => 'button',
            'color' => 'indigo',
            'variant' => 'filled',
            'label' => $this->trans('button.label'),
            'size' => 'normal',
            'block' => false,
            'disabled' => false,
            'iconName' => '',
            'iconVariant' => 'outline',
            'iconSize' => 'normal',
            'iconPosition' => 'left',
        ];
    }

    public function variants(): array
    {
        return [
            'primary-filled' => [
                'color' => 'blue',
                'variant' => 'filled',
                'label' => 'Primary',
            ],
            'success-filled' => [
                'color' => 'emerald',
                'variant' => 'filled',
                'label' => 'Success',
            ],
            'warning-filled' => [
                'color' => 'amber',
                'variant' => 'filled',
                'label' => 'Warning',
            ],
            'danger-filled' => [
                'color' => 'red',
                'variant' => 'filled',
                'label' => 'Danger',
            ],
            'primary-solid' => [
                'color' => 'blue',
                'variant' => 'solid',
                'label' => 'Solid Primary',
            ],
            'success-solid' => [
                'color' => 'emerald',
                'variant' => 'solid',
                'label' => 'Solid Success',
            ],
            'danger-solid' => [
                'color' => 'red',
                'variant' => 'solid',
                'label' => 'Solid Danger',
            ],
            'primary-outline' => [
                'color' => 'blue',
                'variant' => 'outline',
                'label' => 'Outline Primary',
            ],
            'success-outline' => [
                'color' => 'emerald',
                'variant' => 'outline',
                'label' => 'Outline Success',
            ],
            'purple-outline' => [
                'color' => 'purple',
                'variant' => 'outline',
                'label' => 'Outline Purple',
            ],
            'primary-ghost' => [
                'color' => 'blue',
                'variant' => 'ghost',
                'label' => 'Ghost Primary',
            ],
            'pink-ghost' => [
                'color' => 'pink',
                'variant' => 'ghost',
                'label' => 'Ghost Pink',
            ],
            'link-blue' => [
                'color' => 'blue',
                'variant' => 'link',
                'label' => 'Link Blue',
            ],
            'link-purple' => [
                'color' => 'purple',
                'variant' => 'link',
                'label' => 'Link Purple',
            ],
            'small-button' => [
                'color' => 'indigo',
                'variant' => 'filled',
                'size' => 'small',
                'label' => 'Small',
            ],
            'large-button' => [
                'color' => 'violet',
                'variant' => 'solid',
                'size' => 'large',
                'label' => 'Large Button',
            ],
            'icon-left' => [
                'color' => 'emerald',
                'variant' => 'filled',
                'label' => 'Save',
                'iconName' => 'check',
                'iconPosition' => 'left',
                'iconVariant' => 'solid',
            ],
            'icon-right' => [
                'color' => 'blue',
                'variant' => 'outline',
                'label' => 'Next',
                'iconName' => 'arrow-right',
                'iconPosition' => 'right',
            ],
            'block-button' => [
                'color' => 'sky',
                'variant' => 'solid',
                'label' => 'Block Button',
                'block' => true,
            ],
            'disabled-button' => [
                'color' => 'slate',
                'variant' => 'filled',
                'label' => 'Disabled',
                'disabled' => true,
            ],
            'cyan-solid' => [
                'color' => 'cyan',
                'variant' => 'solid',
                'label' => 'Cyan',
            ],
            'rose-filled' => [
                'color' => 'rose',
                'variant' => 'filled',
                'label' => 'Rose',
            ],
            'lime-outline' => [
                'color' => 'lime',
                'variant' => 'outline',
                'label' => 'Lime',
            ],
            'fuchsia-ghost' => [
                'color' => 'fuchsia',
                'variant' => 'ghost',
                'label' => 'Fuchsia',
            ],
        ];
    }
}

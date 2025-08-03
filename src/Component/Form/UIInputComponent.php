<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property string $placeholder
 * @property string $value
 * @property string $type
 * @property string $size
 * @property bool $block
 * @property bool $disabled
 * @property bool $required
 * @property bool $readonly
 * @property string $color
 * @property string $name
 * @property string $id
 * @property string $helpText
 * @property string $errorMessage
 * @property string $rules
 * @property string $iconName
 * @property string $iconPosition
 */
final class UIInputComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const TYPES = ['text', 'password', 'email', 'number', 'tel', 'url', 'date', 'datetime-local', 'time', 'search', 'hidden'];
    private const ICON_POSITIONS = ['left', 'right'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'name' => uniqid('input'),
            'id' => '',
            'helpText' => '',
            'errorMessage' => '',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'iconName' => '',
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('size', 'normal', self::SIZES);
        $this->state('type', 'text', self::TYPES);
        $this->state('iconPosition', 'left', self::ICON_POSITIONS);

        $this->state('rules', '', null, true);
    }

    #[Action]
    public function updateValue(string $fieldName, string $value): void
    {
        $this->value = $value;
        $this->name = $fieldName;

        if ($this->rules) {
            $this->validateField();
        }

        $this->emit('field-updated', [
            'field' => $this->name ?: $this->id,
            'value' => $this->value,
            'error' => $this->errorMessage,
            'isValid' => empty($this->errorMessage)
        ]);
    }

    #[Action]
    public function clearError(): void
    {
        $this->errorMessage = '';
    }

    private function validateField(): void
    {
        if (!$this->rules) {
            return;
        }

        $fieldName = $this->name ?: $this->label ?: 'field';
        $error = $this->validator->validateField($fieldName, $this->value, $this->rules);

        $this->errorMessage = $error ?? '';
    }

    private function getFocusBorderColor(): string
    {
        return TailwindColorUtility::getFocusClasses($this->color, !empty($this->errorMessage));
    }

    private function getBorderColor(): string
    {
        return TailwindColorUtility::getBorderClasses('slate', !empty($this->errorMessage));
    }

    private function getSizeClasses(): string
    {
        return TailwindColorUtility::getSizeClasses($this->size, 'input');
    }

    private function getInputClasses(): string
    {
        $baseClasses = 'w-full bg-white rounded-md focus:outline-none focus:ring-1 transition-all duration-200 ease-in-out';
        $sizeClasses = $this->getSizeClasses();
        $borderClasses = $this->getBorderColor();
        $focusClasses = $this->getFocusBorderColor();

        $classes = "{$baseClasses} {$sizeClasses} border {$borderClasses} {$focusClasses}";

        if ($this->iconName) {
            $paddingAdjustment = match ([$this->iconPosition, $this->size]) {
                ['left', 'small'] => 'pl-8 pr-3',
                ['left', 'large'] => 'pl-12 pr-4',
                ['right', 'small'] => 'pl-3 pr-8',
                ['right', 'large'] => 'pl-4 pr-12',
                ['right', 'normal'] => 'pl-3 pr-10',
                default => 'pl-10 pr-3',
            };

            $classes .= " {$paddingAdjustment}";
        }

        if ($this->disabled) {
            $classes .= ' ' . TailwindColorUtility::getStateClasses('disabled');
        }

        if ($this->readonly) {
            $classes .= ' ' . TailwindColorUtility::getStateClasses('readonly');
        }

        return $classes;
    }

    private function getInputAttributes(): string
    {
        $attributes = [];

        if ($this->name) {
            $attributes[] = "name=\"{$this->name}\"";
        }

        if ($this->id) {
            $attributes[] = "id=\"{$this->id}\"";
        }

        if ($this->placeholder) {
            $attributes[] = "placeholder=\"{$this->placeholder}\"";
        }

        if ($this->rules && $this->type !== 'hidden') {
            $attributes[] = "data-action-change=\"updateValue({$this->name})\" data-action-debounce=\"300\"";
        }

        if ($this->disabled) {
            $attributes[] = 'disabled';
        }

        if ($this->required && !$this->disabled && $this->type !== 'hidden') {
            $attributes[] = 'required';
        }

        if ($this->readonly) {
            $attributes[] = 'readonly';
        }

        return implode(' ', $attributes);
    }

    private function getIconSize(): string
    {
        return match ($this->size) {
            'small' => '4',
            'large' => '6',
            default => '5',
        };
    }

    private function getIconPosition(): string
    {
        $basePosition = 'absolute top-1/2 transform -translate-y-1/2';

        $horizontalPosition = match ([$this->iconPosition, $this->size]) {
            ['left', 'small'] => 'left-2',
            ['right', 'small'] => 'right-2',
            ['right', 'large'], ['right', 'normal'] => 'right-3',
            default => 'left-3',
        };

        return "{$basePosition} {$horizontalPosition}";
    }

    private function renderIcon(): string
    {
        if (!$this->iconName) {
            return '';
        }

        $iconSize = $this->getIconSize();
        $iconPosition = $this->getIconPosition();

        return <<<HTML
            <uiicon name="{$this->iconName}" size="{$iconSize}" class="{$iconPosition} text-slate-400" />
        HTML;
    }

    private function renderLabel(): string
    {
        if (!$this->label) {
            return '';
        }

        $requiredMark = '';
        if ($this->required && !$this->disabled && $this->type !== 'hidden') {
            $requiredMark = '<span class="text-red-500 ml-1">*</span>';
        }

        $forAttribute = $this->id ? "for=\"{$this->id}\"" : '';

        return <<<HTML
            <label {$forAttribute} class="block text-sm font-medium text-slate-700 mb-1">
                {$this->label}
                {$requiredMark}
            </label>
        HTML;
    }

    private function renderHelpText(): string
    {
        if (!$this->helpText) {
            return '';
        }

        return <<<HTML
            <p class="mt-1 text-xs text-slate-500">
                {$this->helpText}
            </p>
        HTML;
    }

    private function renderErrorMessage(): string
    {
        if (!$this->errorMessage) {
            return '';
        }

        return <<<HTML
            <p class="mt-1 text-xs text-red-600" role="alert">
                {$this->errorMessage}
            </p>
        HTML;
    }

    public function template(): string
    {
        if ($this->type === 'hidden') {
            return <<<HTML
                <input type="hidden" value="{$this->value}" {$this->getInputAttributes()} />
            HTML;
        }

        $label = $this->renderLabel();
        $helpText = $this->renderHelpText();
        $errorMessage = $this->renderErrorMessage();
        $icon = $this->renderIcon();

        $blockClass = $this->block ? 'w-full' : 'max-w-sm min-w-[200px]';
        $inputContainer = $this->iconName ? 'relative' : '';

        return <<<HTML
            <div class="ui-input space-y-1 {$blockClass}">
                {$label}
                <div class="{$inputContainer}">
                    <input 
                        type="{$this->type}"
                        value="{$this->value}"
                        class="{$this->getInputClasses()}"
                        {$this->getInputAttributes()}
                    />
                    {$icon}
                </div>
                {$helpText}
                {$errorMessage}
            </div>
        HTML;
    }
}

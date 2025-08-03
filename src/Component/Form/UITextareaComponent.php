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
 * @property string $name
 * @property string $id
 * @property string $helpText
 * @property string $errorMessage
 * @property bool $block
 * @property bool $disabled
 * @property bool $required
 * @property bool $readonly
 * @property string $iconName
 * @property int $rows
 * @property int $maxLength
 * @property string $color
 * @property string $size
 * @property string $iconPosition
 * @property string $rules
 * @property string $countLength
 */
final class UITextareaComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const ICON_POSITIONS = ['left', 'right'];
    private const COUNT = ['count', 'countdown'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'name' => uniqid('textarea'),
            'id' => '',
            'helpText' => '',
            'errorMessage' => '',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'iconName' => '',
            'rows' => 4,
            'maxLength' => 0,
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('size', 'normal', self::SIZES);
        $this->state('iconPosition', 'left', self::ICON_POSITIONS);
        $this->state('countLength', 'count', self::COUNT);

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

        if ($this->rules) {
            $attributes[] = "data-action-change=\"updateValue({$this->name})\" data-action-debounce=\"300\"";
        }

        if ($this->disabled) {
            $attributes[] = 'disabled';
        }

        if ($this->required && !$this->disabled) {
            $attributes[] = 'required';
        }

        if ($this->readonly) {
            $attributes[] = 'readonly';
        }

        return implode(' ', $attributes);
    }

    private function getAriaAttributes(): string
    {
        $aria = [];

        if ($this->errorMessage) {
            $aria[] = 'aria-invalid="true"';
            $aria[] = 'aria-describedby="error-' . $this->getComponentId() . '"';
        }

        if ($this->helpText) {
            $aria[] = 'aria-describedby="help-' . $this->getComponentId() . '"';
        }

        if ($this->maxLength > 0) {
            $aria[] = 'aria-describedby="counter-' . $this->getComponentId() . '"';
        }

        return implode(' ', $aria);
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
        $basePosition = 'absolute top-2.5 transform';

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
        if ($this->required && !$this->disabled) {
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

    private function renderCharacterCount(): string
    {
        if (!$this->maxLength || $this->maxLength <= 0 || $this->disabled || $this->readonly) {
            return '';
        }

        $currentLength = mb_strlen($this->value);
        $remainingChars = $this->maxLength - $currentLength;

        $countText = match($this->countLength) {
            'countdown' => $remainingChars >= 0
                ? $this->trans('textarea.characters_countdown', ['count' => $remainingChars])
                : $this->trans('textarea.characters_count', ['count' => $remainingChars]),
            default => $this->trans('textarea.characters_count', [
                'count' => $currentLength,
                'maxLength' => $this->maxLength,
            ]),
        };

        $textColor = match(true) {
            $remainingChars < 0 => 'text-red-600',
            $remainingChars < ($this->maxLength * 0.1) => 'text-yellow-600',
            default => 'text-slate-500'
        };

        return <<<HTML
            <p class="mt-1 text-xs {$textColor}" aria-live="polite" data-character-display>
                {$countText}
            </p>
        HTML;
    }

    /**
     * @throws \JsonException
     */
    public function template(): string
    {
        $label = $this->renderLabel();
        $helpText = $this->renderHelpText();
        $errorMessage = $this->renderErrorMessage();
        $ariaAttributes = $this->getAriaAttributes();
        $characterCount = $this->renderCharacterCount();
        $icon = $this->renderIcon();

        $blockClass = $this->block ? 'w-full' : 'max-w-sm min-w-[200px]';
        $inputContainer = $this->iconName ? 'relative' : '';

        $characterCounterData = '';
        if ($this->maxLength > 0) {
            $characterCounterData = 'data-character-counter=\'' . json_encode([
                    'maxLength' => $this->maxLength,
                    'mode' => $this->countLength
                ], JSON_THROW_ON_ERROR) . '\'';
        }

        return <<<HTML
            <div class="ui-textarea space-y-1 {$blockClass}" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                {$label}
                <div class="{$inputContainer}">
                    <textarea 
                        rows="{$this->rows}"
                        class="{$this->getInputClasses()}"
                        {$this->getInputAttributes()}
                        {$characterCounterData}
                        {$ariaAttributes}
                    >{$this->value}</textarea>
                    {$icon}
                    {$characterCount}
                </div>
                {$helpText}
                {$errorMessage}
            </div>
        HTML;
    }
}

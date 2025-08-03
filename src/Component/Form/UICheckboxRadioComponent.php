<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $type
 * @property string $label
 * @property string|array $value
 * @property string $name
 * @property string $id
 * @property array $options
 * @property string $size
 * @property string $color
 * @property string $orientation
 * @property bool $disabled
 * @property bool $required
 * @property string $helpText
 * @property string $errorMessage
 * @property string $rules
 * @property bool $inline
 */
final class UICheckboxRadioComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const TYPES = ['checkbox', 'radio'];
    private const SIZES = ['small', 'normal', 'large'];
    private const ORIENTATIONS = ['vertical', 'horizontal'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'value' => '',
            'name' => uniqid('checkbox'),
            'id' => uniqid('checkbox_id_'),
            'options' => [],
            'disabled' => false,
            'required' => false,
            'helpText' => '',
            'errorMessage' => '',
            'inline' => false,
        ]);

        $this->state('type', 'checkbox', self::TYPES);
        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('orientation', 'vertical', self::ORIENTATIONS);
        $this->state('rules', '', protected: true);

        $this->normalizeInitialValue();
    }

    private function handleRadioUpdate(string $optionValue): void
    {
        $this->value = $optionValue;

        if ($this->type === 'radio') {
            if (is_array($this->value)) {
                $this->value = !empty($this->value) ? (string)$this->value[0] : '';
            } else {
                $this->value = (string)$this->value;
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    #[Action]
    public function updateValue(string $optionValue): void
    {
        if ($this->disabled) {
            return;
        }

        if ($this->type === 'checkbox') {
            $this->handleCheckboxUpdate($optionValue);
        } else {
            $this->handleRadioUpdate($optionValue);
        }

        $this->validateField();
        $this->emitFieldUpdate();
    }

    private function handleCheckboxUpdate(string $optionValue): void
    {
        $currentValues = is_array($this->value) ? $this->value : [];

        if (in_array($optionValue, $currentValues, true)) {
            $this->value = array_values(array_filter($currentValues,
                static fn($v) => $v !== $optionValue
            ));
        } else {
            $this->value = [...$currentValues, $optionValue];
        }
    }

    private function normalizeInitialValue(): void
    {
        if ($this->type === 'checkbox') {
            if (!is_array($this->value)) {
                $this->value = $this->value ? [$this->value] : [];
            }
        } elseif ($this->type === 'radio') {
            if (is_array($this->value)) {
                $this->value = !empty($this->value) ? (string)$this->value[0] : '';
            } else {
                $this->value = (string)$this->value;
            }
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function validateField(): void
    {
        if (!$this->rules) {
            return;
        }

        $fieldName = $this->name ?: $this->label ?: 'field';

        if ($this->type === 'checkbox') {
            if (is_array($this->value)) {
                $value = count($this->value) > 0 ? implode(',', $this->value) : '';

                if (empty($this->value) && str_contains($this->rules, 'required')) {
                    $this->errorMessage = 'Ce champ est obligatoire';
                    return;
                }
            } else {
                $value = $this->value ? 'on' : '';
            }
        } else {
            $value = $this->value;
        }

        $error = $this->validateCurrentField($fieldName, $value, $this->rules);
        $this->errorMessage = $error ?? '';
    }

    private function emitFieldUpdate(): void
    {
        $this->emit('field-updated', [
            'field' => $this->name ?: $this->id,
            'value' => $this->value,
            'error' => $this->errorMessage,
            'isValid' => empty($this->errorMessage),
            'type' => $this->type
        ]);
    }

    private function isOptionSelected(string $optionKey): bool
    {
        if ($this->type === 'checkbox') {
            $result = is_array($this->value) && in_array($optionKey, $this->value, true);
        } else {
            $currentValue = is_array($this->value) ?
                (!empty($this->value) ? (string)$this->value[0] : '') :
                (string)$this->value;
            $result = $currentValue === $optionKey;
        }

        return $result;
    }

    private function getInputClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'h-3 w-3',
            'large' => 'h-6 w-6',
            default => 'h-4 w-4',
        };

        $colorClasses = TailwindColorUtility::getCheckboxRadioColorClasses($this->color);
        $baseClasses = 'transition-all duration-200';

        if ($this->type === 'radio') {
            $baseClasses .= ' rounded-full';
        } else {
            $baseClasses .= ' rounded';
        }

        $classes = "{$baseClasses} {$sizeClasses} {$colorClasses}";
        if ($this->disabled) {
            $classes .= ' opacity-50 cursor-not-allowed';
        }

        return $classes;
    }

    private function getLabelClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'text-xs',
            'large' => 'text-base',
            default => 'text-sm',
        };

        $baseClasses = 'font-medium text-slate-700 cursor-pointer';

        if ($this->disabled) {
            $baseClasses .= ' opacity-50 cursor-not-allowed';
        }

        return "{$baseClasses} {$sizeClasses}";
    }

    private function getContainerClasses(): string
    {
        if ($this->inline || $this->orientation === 'horizontal') {
            return 'flex flex-wrap gap-4';
        }

        return 'space-y-2';
    }

    private function getOptionClasses(): string
    {
        $baseClasses = 'flex items-center';

        $gapClasses = match ($this->size) {
            'small' => 'gap-1',
            default => 'gap-2',
        };

        return "{$baseClasses} {$gapClasses}";
    }

    private function renderMainLabel(): string
    {
        if (!$this->label) {
            return '';
        }

        $requiredMark = '';
        if ($this->required && !$this->disabled) {
            $requiredMark = ' <span class="text-red-500">*</span>';
        }

        return <<<HTML
            <legend class="block text-sm font-medium text-slate-700 mb-2">
                {$this->label}{$requiredMark}
            </legend>
        HTML;
    }

    private function renderOptions(): string
    {
        if (empty($this->options)) {
            return '';
        }

        $optionsHtml = [];
        $containerClasses = $this->getContainerClasses();

        foreach ($this->options as $key => $option) {
            $optionValue = is_array($option) ? ($option['value'] ?? $key) : $key;
            $optionLabel = is_array($option) ? ($option['label'] ?? $optionValue) : $option;
            $optionLabelString = is_string($optionLabel) ? $optionLabel : (string) $optionLabel;

            $keyString = is_string($key) ? $key : (string) $key;
            $isSelected = $this->isOptionSelected($keyString);
            $inputId = "{$this->id}_{$keyString}";

            $inputClasses = $this->getInputClasses();
            $labelClasses = $this->getLabelClasses();
            $optionClasses = $this->getOptionClasses();

            $checkedAttribute = $isSelected ? 'checked' : '';
            $disabledAttribute = $this->disabled ? 'disabled' : '';

            if ($this->type === 'checkbox') {
                $inputName = $keyString;
                $inputValue = '';  // Pas de value pour les checkbox multiples
            } else {
                $inputName = $this->name;
                $inputValue = $keyString;
            }

            $valueAttribute = $inputValue ? "value=\"{$inputValue}\"" : '';

            $optionsHtml[] = <<<HTML
                <div class="{$optionClasses}">
                    <input
                        type="{$this->type}"
                        id="{$inputId}"
                        name="{$inputName}"
                        {$valueAttribute}
                        class="{$inputClasses}"
                        {$checkedAttribute}
                        {$disabledAttribute}
                        data-action-change="updateValue('{$keyString}')"
                    />
                    <div class="flex-1">
                        <label for="{$inputId}" class="{$labelClasses}">
                            {$optionLabelString}
                        </label>
                    </div>
                </div>
            HTML;
        }

        return <<<HTML
            <div class="{$containerClasses}">
                {$this->implode('', $optionsHtml)}
            </div>
        HTML;
    }

    private function renderSingleOption(): string
    {
        if (!empty($this->options)) {
            return '';
        }

        $inputValue = 'on';
        if (is_string($this->value) && $this->value !== '') {
            $inputValue = $this->value;
        }

        $isSelected = $this->isOptionSelected($inputValue);

        $inputClasses = $this->getInputClasses();
        $labelClasses = $this->getLabelClasses();
        $optionClasses = $this->getOptionClasses();

        $checkedAttribute = $isSelected ? 'checked' : '';
        $disabledAttribute = $this->disabled ? 'disabled' : '';

        $requiredMark = '';
        if ($this->required && !$this->disabled) {
            $requiredMark = ' <span class="text-red-500">*</span>';
        }

        return <<<HTML
            <div class="{$optionClasses}">
                <input
                    type="{$this->type}"
                    id="{$this->id}"
                    name="{$this->name}"
                    value="{$inputValue}"
                    class="{$inputClasses}"
                    {$checkedAttribute}
                    {$disabledAttribute}
                    data-action-change="updateValue('{$inputValue}')"
                />
                <div class="flex-1">
                    <label for="{$this->id}" class="{$labelClasses}">
                        {$this->label}{$requiredMark}
                    </label>
                </div>
            </div>
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

    private function implode(string $separator, array $array): string
    {
        return implode($separator, $array);
    }

    public function template(): string
    {
        $mainLabel = empty($this->options) ? '' : $this->renderMainLabel();
        $options = empty($this->options) ? $this->renderSingleOption() : $this->renderOptions();
        $helpText = $this->renderHelpText();
        $errorMessage = $this->renderErrorMessage();

        return <<<HTML
            <fieldset class="ui-checkbox-radio space-y-1 ui-checkbox-radio">
                {$mainLabel}
                {$options}
                {$helpText}
                {$errorMessage}
            </fieldset>
        HTML;
    }
}

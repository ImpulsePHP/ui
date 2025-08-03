<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property bool $value
 * @property string $name
 * @property string $id
 * @property string $size
 * @property string $color
 * @property bool $disabled
 * @property bool $required
 * @property string $helpText
 * @property string $errorMessage
 * @property string $rules
 * @property string $labelPosition
 * @property string $onLabel
 * @property string $offLabel
 * @property bool $showLabels
 */
final class UIToggleComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const LABEL_POSITIONS = ['left', 'right', 'top', 'bottom'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'value' => false,
            'name' => uniqid('toggle'),
            'id' => uniqid('toggle_id_'),
            'disabled' => false,
            'required' => false,
            'helpText' => '',
            'errorMessage' => '',
            'onLabel' => '',
            'offLabel' => '',
            'showLabels' => false,
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('labelPosition', 'right', self::LABEL_POSITIONS);
        $this->state('rules', '', protected: true);
    }

    /**
     * @throws \ReflectionException
     */
    #[Action]
    public function toggle(): void
    {
        if ($this->disabled) {
            return;
        }

        $this->value = !$this->value;

        $this->validateField();
        $this->emitFieldUpdate();
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
        $value = $this->value ? '1' : '0';

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
            'type' => 'toggle'
        ]);
    }

    private function getToggleSizeClasses(): string
    {
        return match ($this->size) {
            'small' => 'w-9 h-5',
            'large' => 'w-14 h-7',
            default => 'w-11 h-6',
        };
    }

    private function getKnobSizeClasses(): string
    {
        return match ($this->size) {
            'small' => 'w-5 h-5',
            'large' => 'w-7 h-7',
            default => 'w-6 h-6',
        };
    }

    private function getKnobTransformClasses(): string
    {
        return match ($this->size) {
            'small' => 'peer-checked:translate-x-4',
            'large' => 'peer-checked:translate-x-7',
            default => 'peer-checked:translate-x-6',
        };
    }

    private function getToggleColorClasses(): string
    {
        $activeColor = TailwindColorUtility::getToggleActiveClasses($this->color);
        return "bg-slate-100 {$activeColor}";
    }

    private function getKnobBorderColorClasses(): string
    {
        $borderColor = TailwindColorUtility::getToggleBorderClasses($this->color);
        return "border-slate-300 {$borderColor}";
    }

    private function getLabelTextClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'text-xs',
            'large' => 'text-base',
            default => 'text-sm',
        };

        $baseClasses = 'text-slate-600 cursor-pointer';
        if ($this->disabled) {
            $baseClasses .= ' opacity-50 cursor-not-allowed';
        }

        return "{$baseClasses} {$sizeClasses}";
    }

    private function getOnOffLabelClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'large' => 'text-sm',
            default => 'text-xs',
        };

        return "font-medium text-slate-500 {$sizeClasses}";
    }

    private function getContainerClasses(): string
    {
        return match ($this->labelPosition) {
            'left' => 'inline-flex gap-3 flex-row-reverse items-center',
            'right' => 'inline-flex gap-3 items-center',
            'top' => 'inline-flex flex-col gap-2 items-start',
            'bottom' => 'inline-flex flex-col-reverse gap-2 items-start',
        };
    }

    private function renderToggleSwitch(): string
    {
        $toggleSizeClasses = $this->getToggleSizeClasses();
        $knobSizeClasses = $this->getKnobSizeClasses();
        $knobTransformClasses = $this->getKnobTransformClasses();
        $toggleColorClasses = $this->getToggleColorClasses();
        $knobBorderColorClasses = $this->getKnobBorderColorClasses();

        $checkedAttribute = $this->value ? 'checked' : '';
        $disabledAttribute = $this->disabled ? 'disabled' : '';

        $baseToggleClasses = "peer appearance-none rounded-full cursor-pointer transition-colors duration-300 {$toggleSizeClasses} {$toggleColorClasses}";
        $baseKnobClasses = "absolute top-0 left-0 bg-white rounded-full border shadow-sm transition-transform duration-300 cursor-pointer {$knobSizeClasses} {$knobTransformClasses} {$knobBorderColorClasses}";

        if ($this->disabled) {
            $baseToggleClasses .= ' opacity-50 cursor-not-allowed';
            $baseKnobClasses .= ' cursor-not-allowed';
        }

        $switchHtml = <<<HTML
            <div class="relative inline-block {$toggleSizeClasses}">
                <input 
                    id="{$this->id}" 
                    type="checkbox" 
                    class="{$baseToggleClasses}"
                    {$checkedAttribute}
                    {$disabledAttribute}
                    data-action-change="toggle()"
                />
                <label 
                    for="{$this->id}" 
                    class="{$baseKnobClasses}"
                ></label>
            </div>
        HTML;

        if ($this->showLabels) {
            $onOffLabelClasses = $this->getOnOffLabelClasses();
            $offLabelClasses = $this->value ? 'text-slate-200' : 'text-slate-600';
            $onLabelClasses = $this->value ? 'text-slate-600' : 'text-slate-200';

            return <<<HTML
                <div class="inline-flex gap-2 items-center">
                    <span class="{$onOffLabelClasses} {$offLabelClasses}">
                        {$this->offLabel}
                    </span>
                    {$switchHtml}
                    <span class="{$onOffLabelClasses} {$onLabelClasses}">
                        {$this->onLabel}
                    </span>
                </div>
            HTML;
        }

        return $switchHtml;
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

        $labelTextClasses = $this->getLabelTextClasses();

        if ($this->helpText) {
            return <<<HTML
                <label for="{$this->id}" class="{$labelTextClasses}">
                    <div>
                        <p class="font-medium">
                            {$this->label}{$requiredMark}
                        </p>
                        <p class="text-slate-500">
                            {$this->helpText}
                        </p>
                    </div>
                </label>
            HTML;
        }

        return <<<HTML
            <label for="{$this->id}" class="{$labelTextClasses} font-medium">
                {$this->label}{$requiredMark}
            </label>
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

    private function renderHiddenInput(): string
    {
        $value = $this->value ? '1' : '0';

        return <<<HTML
            <input
                type="hidden"
                name="{$this->name}"
                value="{$value}"
            />
        HTML;
    }

    public function template(): string
    {
        $containerClasses = $this->getContainerClasses();
        $hiddenInput = $this->renderHiddenInput();
        $toggleSwitch = $this->renderToggleSwitch();
        $mainLabel = $this->renderMainLabel();
        $errorMessage = $this->renderErrorMessage();

        return <<<HTML
            <div class="ui-toggle">
                {$hiddenInput}
                <div class="{$containerClasses}">
                    {$toggleSwitch}
                    {$mainLabel}
                </div>
                {$errorMessage}
            </div>
        HTML;
    }
}

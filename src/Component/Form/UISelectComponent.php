<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property string $placeholder
 * @property string|array $value
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
 * @property array $options
 * @property bool $multiple
 * @property bool $searchable
 * @property string $searchPlaceholder
 * @property bool $isOpen
 * @property string $searchQuery
 * @property array $filteredOptions
 * @property int $maxHeight
 * @property string $iconName
 * @property string $iconPosition
 */
final class UISelectComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const ICON_POSITIONS = ['left', 'right'];

    /**
     * @throws \ReflectionException
     */
    public function setup(): void
    {
        $this->states([
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'name' => uniqid('select'),
            'id' => uniqid('id_select'),
            'iconName' => '',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'multiple' => false,
            'options' => [],
            'searchable' => true,
            'searchPlaceholder' => $this->trans('select.search_placeholder'),
            'searchQuery' => '',
            'isOpen' => false,
            'filteredOptions' => [],
            'maxHeight' => 200,
            'helpText' => '',
            'errorMessage' => '',
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('size', 'normal', self::SIZES);
        $this->state('iconPosition', 'left', self::ICON_POSITIONS);
        $this->state('rules', '', protected: true);

        $this->updateFilteredOptions();
    }

    #[Action]
    public function selectOption(string $optionValue): void
    {
        if ($this->disabled || $this->readonly) {
            return;
        }

        if ($this->multiple) {
            $currentValues = is_array($this->value) ? $this->value : [];

            if (in_array($optionValue, $currentValues, true)) {
                $this->value = array_values(array_filter($currentValues, static fn($v) => $v !== $optionValue));
            } else {
                $this->value = [...$currentValues, $optionValue];
            }
        } else {
            $this->value = $optionValue;
            $this->isOpen = false;
        }

        $this->validateField();
        $this->emitFieldUpdate();
    }

    #[Action]
    public function removeBadge(string $optionValue): void
    {
        if ($this->disabled || $this->readonly || !$this->multiple) {
            return;
        }

        $currentValues = is_array($this->value) ? $this->value : [];
        $this->value = array_values(array_filter($currentValues, static fn($v) => $v !== $optionValue));

        $this->validateField();
        $this->emitFieldUpdate();
    }

    #[Action]
    public function toggleDropdown(): void
    {
        if ($this->disabled || $this->readonly) {
            return;
        }

        $this->isOpen = !$this->isOpen;

        if ($this->isOpen) {
            $this->searchQuery = '';
            $this->updateFilteredOptions();
        }
    }

    #[Action]
    public function closeDropdown(): void
    {
        $this->isOpen = false;
        $this->searchQuery = '';
    }

    #[Action]
    public function updateSearch(string $query): void
    {
        $this->searchQuery = $query;
        $this->updateFilteredOptions();
    }

    private function updateFilteredOptions(): void
    {
        if (!is_array($this->options)) {
            $this->filteredOptions = [];
            return;
        }

        if (empty($this->searchQuery)) {
            $this->filteredOptions = $this->options;
            return;
        }

        $query = strtolower($this->searchQuery);
        $filtered = array_filter($this->options, static function($option) use ($query) {
            $label = is_array($option) ? strtolower($option['label'] ?? '') : strtolower($option);
            return str_contains($label, $query);
        });

        $this->filteredOptions = array_values($filtered);
    }

    private function validateField(): void
    {
        if (!$this->rules) {
            return;
        }

        $fieldName = $this->name ?: $this->label ?: 'field';
        $value = $this->multiple && is_array($this->value) ? implode(',', $this->value) : $this->value;
        $error = $this->validator->validateField($fieldName, $value, $this->rules);

        $this->errorMessage = $error ?? '';
    }

    private function emitFieldUpdate(): void
    {
        $this->emit('field-updated', [
            'field' => $this->name ?: $this->id,
            'value' => $this->value,
            'error' => $this->errorMessage,
            'isValid' => empty($this->errorMessage)
        ]);
    }

    private function getSelectedOptions(): array
    {
        $normalizedValue = $this->normalizeValue();
        $this->value = $normalizedValue;

        $selectedValues = $this->multiple
            ? (is_array($normalizedValue) ? $normalizedValue : [])
            : ($normalizedValue ? [$normalizedValue] : []);

        $selected = [];

        if (!is_array($this->options)) {
            return [];
        }

        foreach ($this->options as $option) {
            $optionValue = is_array($option) ? $option['value'] : $option;
            $optionLabel = is_array($option) ? $option['label'] : $option;

            if (in_array($optionValue, $selectedValues, true)) {
                $selected[] = [
                    'value' => $optionValue,
                    'label' => $optionLabel
                ];
            }
        }

        return $selected;
    }

    private function normalizeValue(): mixed
    {
        $value = $this->value;

        while (is_array($value) && count($value) === 1 && is_array($value[0]) && count($value[0]) === 1) {
            $value = $value[0][0];
        }

        if (!$this->multiple && is_array($value) && count($value) === 1) {
            $value = $value[0];
        }

        return $value;
    }

    private function getFocusBorderColor(): string
    {
        return TailwindColorUtility::getFocusClasses($this->color, !empty($this->errorMessage));
    }

    private function getActiveBorderColor(): string
    {
        return TailwindColorUtility::getActiveBorderColor($this->color, !empty($this->errorMessage));
    }

    private function getBorderColor(): string
    {
        return TailwindColorUtility::getBorderClasses('slate', !empty($this->errorMessage));
    }

    private function getSizeClasses(): string
    {
        return TailwindColorUtility::getSizeClasses($this->size, 'input');
    }

    private function getSelectClasses(): string
    {
        $baseClasses = 'bg-white rounded-md shadow-sm focus:outline-none focus:ring-1 transition-colors duration-200 cursor-pointer relative transition-all duration-200 ease-in-out';
        $sizeClasses = $this->getSizeClasses();

        if ($this->iconName) {
            $paddingAdjustment = match ($this->size) {
                'small' => $this->iconPosition === 'left' ? 'pl-7' : 'pr-2',
                'large' => $this->iconPosition === 'left' ? 'pl-10' : 'pr-4',
                default => $this->iconPosition === 'left' ? 'pl-9' : 'pr-3',
            };

            $sizeClasses .= " {$paddingAdjustment}";
        }

        if ($this->isOpen && !$this->disabled && !$this->readonly) {
            $borderClasses = $this->getActiveBorderColor();
        } else {
            $borderClasses = 'border ' . $this->getBorderColor();
            $focusClasses = $this->getFocusBorderColor();
            $borderClasses .= " {$focusClasses}";
        }

        $classes = "{$baseClasses} {$sizeClasses} {$borderClasses}";

        if ($this->disabled) {
            $classes .= ' ' . TailwindColorUtility::getStateClasses('disabled');
        }

        if ($this->readonly) {
            $classes .= ' ' . TailwindColorUtility::getStateClasses('readonly');
        }

        return $classes;
    }

    private function getBadgeColor(): string
    {
        return TailwindColorUtility::getBadgeColor($this->color);
    }

    private function getIconSize(): string
    {
        return match ($this->size) {
            'small' => '4',
            default => '5',
        };
    }

    private function getIconPosition(): string
    {
        $basePosition = 'absolute top-1/2 transform -translate-y-1/2';

        $horizontalPosition = match ([$this->iconPosition, $this->size]) {
            ['left', 'small'] => 'left-2',
            ['right', 'small'] => 'right-8',
            ['right', 'large'] => 'right-10',
            ['right', 'normal'] => 'right-9',
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
            $requiredMark = '<span class="text-red-500">*</span>';
        }

        $forAttribute = $this->id ? "for=\"{$this->id}\"" : '';

        return <<<HTML
            <label {$forAttribute} class="block text-sm font-medium text-slate-700 mb-1">
                {$this->label}
                {$requiredMark}
            </label>
        HTML;
    }

    private function renderSelectedContent(): string
    {
        $selectedOptions = $this->getSelectedOptions();
        if (empty($selectedOptions)) {
            return "<span class=\"text-slate-400\">{$this->placeholder}</span>";
        }

        if ($this->multiple) {
            return $this->renderBadges($selectedOptions);
        }

        return "<span class=\"text-slate-900\">{$selectedOptions[0]['label']}</span>";
    }

    private function renderBadges(array $selectedOptions): string
    {
        $badgeColor = $this->getBadgeColor();
        $badges = [];

        foreach ($selectedOptions as $option) {
            $badges[] = <<<HTML
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium border {$badgeColor}">
                    {$option['label']}
                    <button 
                        type="button" 
                        class="ml-1 text-current hover:text-red-600 focus:outline-none"
                        data-action-click="removeBadge('{$option['value']}')"
                    >
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </span>
            HTML;
        }

        return '<div class="flex flex-wrap gap-1">' . implode('', $badges) . '</div>';
    }

    private function renderSearchInput(): string
    {
        if (!$this->searchable) {
            return '';
        }

        return <<<HTML
            <div class="p-2 border-b border-slate-200">
                <input
                    type="text"
                    placeholder="{$this->searchPlaceholder}"
                    value="{$this->searchQuery}"
                    class="w-full px-2 py-1 text-sm border border-slate-300 rounded focus:outline-none focus:ring-1 {$this->getFocusBorderColor()}"
                    data-search-input
                    autocomplete="off"
                />
            </div>
        HTML;
    }

    /**
     * @throws \ReflectionException
     */
    private function renderDropdown(): string
    {
        if (!$this->isOpen) {
            return '';
        }

        $searchInput = $this->renderSearchInput();
        $options = $this->renderOptions();

        $dataSearch = $this->searchable ? 'data-live-search' : '';

        return <<<HTML
        <div 
            class="absolute z-50 w-full mt-1 bg-white border border-slate-300 rounded-md shadow-lg"
            {$dataSearch}
            data-search-container
            data-search-items="li"
            data-search-fields="data-search-text,span"
            data-search-no-results-message="{$this->trans('select.no_results')}"
            data-search-hidden-class="hidden"
            data-close-outside="self"
            data-close-outside-ignore="#{$this->id}"
            data-close-outside-action="toggleDropdown"
        >
            {$searchInput}
            <div class="max-h-48 overflow-y-auto" data-save-scroll="dropdown-options">
                {$options}
            </div>
        </div>
    HTML;
}

    /**
     * @throws \ReflectionException
     */
    private function renderOptions(): string
{
    if (!is_array($this->filteredOptions) || empty($this->filteredOptions)) {
        return <<<HTML
            <div class="p-3 text-sm text-slate-500 text-center">
                {$this->trans('select.no_options')}
            </div>
        HTML;
    }

    $options = [];
    $selectedValues = $this->multiple
        ? (is_array($this->value) ? $this->value : [])
        : ($this->value ? [$this->value] : []);

    foreach ($this->filteredOptions as $option) {
        $optionValue = is_array($option) ? ($option['value'] ?? '') : $option;
        $optionLabel = is_array($option) ? ($option['label'] ?? $optionValue) : $option;
        $isSelected = in_array($optionValue, $selectedValues, true);

        $selectedClass = $isSelected ? 'bg-slate-100 text-slate-900' : 'text-slate-700 hover:bg-slate-50';
        $checkIcon = '';

        if ($this->multiple && $isSelected) {
            $checkIcon = <<<HTML
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            HTML;
        }

        $options[] = <<<HTML
            <li class="flex items-center justify-between px-3 py-2 cursor-pointer {$selectedClass}" 
                data-action-click="selectOption('{$optionValue}')"
                data-search-text="{$optionLabel}"
            >
                <span class="text-sm">{$optionLabel}</span>
                {$checkIcon}
            </li>
        HTML;
    }

    return '<ul>' . implode('', $options) . '</ul>';
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

    /**
     * @throws \ReflectionException
     */
    public function template(): string
    {
        $label = $this->renderLabel();
        $selectedContent = $this->renderSelectedContent();
        $dropdown = $this->renderDropdown();
        $helpText = $this->renderHelpText();
        $errorMessage = $this->renderErrorMessage();
        $icon = $this->renderIcon();

        $blockClass = $this->block ? 'w-full' : 'max-w-sm min-w-[200px]';
        $isOpenClass = $this->isOpen ? 'rotate-180' : '';
        $selectContainer = $this->iconName ? 'relative' : '';

        $chevronIcon = <<<HTML
            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 {$isOpenClass}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        HTML;

        return <<<HTML
            <div class="ui-select space-y-1 relative {$blockClass}">
                {$label}
                <div class="relative">
                    <div 
                        class="{$this->getSelectClasses()} {$selectContainer} flex items-center justify-between"
                        data-action-click="toggleDropdown"
                        tabindex="0"
                    >
                        <div class="flex-1 min-w-0">
                            {$selectedContent}
                        </div>
                        {$icon}
                        <div class="flex items-center">
                            {$chevronIcon}
                        </div>
                    </div>
                    {$dropdown}
                </div>
                {$helpText}
                {$errorMessage}
            </div>
        HTML;
    }
}

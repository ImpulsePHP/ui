<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $label
 * @property string $mode
 * @property string $value
 * @property string $startDate
 * @property string $endDate
 * @property string $minDate
 * @property string $maxDate
 * @property bool $required
 * @property bool $disabled
 * @property string $name
 * @property string $color
 */
final class UIDatePickerComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const MODES = ['single', 'range'];

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'mode' => 'single',
            'value' => '',
            'startDate' => '',
            'endDate' => '',
            'minDate' => '',
            'maxDate' => '',
            'required' => false,
            'disabled' => false,
            'name' => uniqid('date_picker'),
        ]);

        $this->state('mode', 'single', self::MODES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function setDate(string $date): void
    {
        $this->value = $date;
        $this->emit('date-selected', ['mode' => 'single', 'value' => $this->value]);
    }

    #[Action]
    public function setRangeStart(string $date): void
    {
        $this->startDate = $date;
        $this->emit('date-selected', ['mode' => 'range', 'startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }

    #[Action]
    public function setRangeEnd(string $date): void
    {
        $this->endDate = $date;
        $this->emit('date-selected', ['mode' => 'range', 'startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }

    #[Action]
    public function clearDate(): void
    {
        $this->value = '';
        $this->startDate = '';
        $this->endDate = '';
    }

    public function template(): string
    {
        $label = $this->label ? '<label class="block text-sm font-medium text-slate-700 mb-1">' . $this->label . '</label>' : '';
        $required = $this->required ? 'required' : '';
        $disabled = $this->disabled ? 'disabled' : '';
        $min = $this->minDate !== '' ? 'min="' . $this->minDate . '"' : '';
        $max = $this->maxDate !== '' ? 'max="' . $this->maxDate . '"' : '';
        $focus = TailwindColorUtility::getFocusClasses($this->color);

        if ($this->mode === 'range') {
            return <<<HTML
                <div class="ui-date-picker space-y-1">
                    {$label}
                    <div class="grid grid-cols-2 gap-2">
                        <input type="date" value="{$this->startDate}" {$min} {$max} {$required} {$disabled}
                            class="border border-slate-300 rounded-md px-3 py-2 text-sm {$focus}"
                            data-action-change="setRangeStart({$this->name})" />
                        <input type="date" value="{$this->endDate}" {$min} {$max} {$required} {$disabled}
                            class="border border-slate-300 rounded-md px-3 py-2 text-sm {$focus}"
                            data-action-change="setRangeEnd({$this->name})" />
                    </div>
                </div>
            HTML;
        }

        return <<<HTML
            <div class="ui-date-picker space-y-1">
                {$label}
                <input type="date" value="{$this->value}" {$min} {$max} {$required} {$disabled}
                    class="w-full border border-slate-300 rounded-md px-3 py-2 text-sm {$focus}"
                    data-action-change="setDate({$this->name})" />
            </div>
        HTML;
    }
}


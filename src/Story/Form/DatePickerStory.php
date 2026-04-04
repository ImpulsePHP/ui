<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UIDatePickerComponent;

final class DatePickerStory extends AbstractStory
{
    protected string $category = 'Form';

    public function name(): string { return 'DatePicker'; }
    public function description(): string { return 'Date picker single et range.'; }
    public function componentClass(): string { return UIDatePickerComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['label' => 'Select date', 'mode' => 'single', 'value' => '2026-04-04', 'color' => 'indigo'];
    }

    public function variants(): array
    {
        return [
            'single' => [],
            'range' => ['mode' => 'range', 'startDate' => '2026-04-01', 'endDate' => '2026-04-07'],
            'with limits' => ['minDate' => '2026-01-01', 'maxDate' => '2026-12-31'],
            'disabled' => ['disabled' => true],
        ];
    }
}


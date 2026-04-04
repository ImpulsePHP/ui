<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIProgressComponent;

final class ProgressStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Progress'; }
    public function description(): string { return 'Barre de progression lineaire.'; }
    public function componentClass(): string { return UIProgressComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['value' => 35, 'max' => 100, 'showLabel' => true, 'label' => 'Upload', 'variant' => 'linear'];
    }

    public function variants(): array
    {
        return [
            'small' => ['size' => 'small'],
            'normal' => [],
            'large' => ['size' => 'large', 'value' => 75],
            'without label' => ['showLabel' => false, 'value' => 60],
            'circular default' => ['variant' => 'circular', 'value' => 64],
            'circular large' => ['variant' => 'circular', 'circleSize' => 140, 'circleStroke' => 10, 'value' => 82],
        ];
    }
}

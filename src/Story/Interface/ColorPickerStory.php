<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIColorPickerComponent;

final class ColorPickerStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'ColorPicker'; }
    public function description(): string { return 'Sélecteur de couleur simple.'; }
    public function componentClass(): string { return UIColorPickerComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['value' => '#3b82f6'];
    }

    public function variants(): array
    {
        return ['default' => []];
    }
}


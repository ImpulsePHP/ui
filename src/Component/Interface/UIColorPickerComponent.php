<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class UIColorPickerComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $palette = ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#6b7280'];
        $this->states([
            'value' => '#3b82f6',
            // pass default array as first element of config array
            'palette' => [$palette, null],
            'id' => uniqid('cp')
        ]);
    }

    #[Action]
    public function pickColor(string $color): void
    {
        $this->value = $color;
        $this->emit('color-changed', ['color' => $color]);
    }

    public function template(): string
    {
        $swatches = [];
        foreach ((array) $this->palette as $c) {
            $cEsc = htmlspecialchars((string) $c, ENT_QUOTES | ENT_SUBSTITUTE);
            $swatches[] = "<button type=\"button\" class=\"w-6 h-6 rounded\" style=\"background:{$cEsc};\" data-action-click=\"pickColor('{$cEsc}')\"></button>";
        }

        $swatchesHtml = implode('', $swatches);

        return <<<HTML
            <div class="ui-colorpicker flex items-center gap-3" id="{$this->id}">
                <div class="w-8 h-8 rounded border" style="background: {$this->value};"></div>
                <div class="flex gap-2">{$swatchesHtml}</div>
                <input type="color" value="{$this->value}" class="ml-2" data-action-input="pickColor(this.value)" />
            </div>
        HTML;
    }
}



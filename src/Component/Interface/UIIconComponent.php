<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;

/**
 * @property string $name
 * @property string $variant
 * @property string $size
 * @property string $iconClass
 */
final class UIIconComponent extends AbstractComponent
{
    private const VARIANTS = ['outline', 'solid', 'mini', 'micro'];
    private const SIZES = ['auto', '4', '5', '6'];

    public function setup(): void
    {
        $this->states([
            'name' => '',
            'iconClass' => ''
        ]);

        $this->state('variant', 'outline', self::VARIANTS);
        $this->state('size', 'auto', self::SIZES);
    }

    private function getIconPath(): ?string
    {
        if (empty($this->name)) {
            return null;
        }

        $basePath = __DIR__ . '/../../../resources/icons';
        $iconName = $this->convertToKebabCase($this->name);

        $variantMap = [
            'outline' => '24/outline',
            'solid' => '24/solid',
            'mini' => '20/solid',
            'micro' => '16/solid'
        ];

        $variant = $variantMap[$this->variant] ?? '24/outline';
        $iconPath = "{$basePath}/{$variant}/{$iconName}.svg";

        return file_exists($iconPath) ? $iconPath : null;
    }

    private function convertToKebabCase(string $name): string
    {
        $result = preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $name);
        return strtolower($result);
    }

    private function getSizeClass(): string
    {
        if ($this->size === 'auto') {
            return match ($this->variant) {
                'micro' => 'size-4',
                'mini' => 'size-5',
                default => 'size-6'
            };
        }

        return "size-{$this->size}";
    }

    private function loadSvgContent(): string
    {
        $iconPath = $this->getIconPath();
        if (!$iconPath || !file_exists($iconPath)) {
            return $this->renderMissingIcon();
        }

        $svgContent = file_get_contents($iconPath);
        if ($svgContent === false) {
            return $this->renderMissingIcon();
        }

        $sizeClass = $this->getSizeClass();
        $additionalClass = !empty($this->iconClass) ? " {$this->iconClass}" : '';

        if (preg_match('/class="([^"]*)"/', $svgContent)) {
            $svgContent = preg_replace(
                '/class="([^"]*)"/',
                'class="$1 ' . $sizeClass . $additionalClass . '"',
                $svgContent
            );
        } else {
            $svgContent = preg_replace(
                '/<svg([^>]*)>/',
                '<svg$1 class="' . $sizeClass . $additionalClass . '">',
                $svgContent
            );
        }

        return $svgContent;
    }

    private function renderMissingIcon(): string
    {
        $sizeClass = $this->getSizeClass();
        $additionalClass = !empty($this->iconClass) ? " {$this->iconClass}" : '';

        return <<<HTML
            <svg class="{$sizeClass}{$additionalClass}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        HTML;
    }

    public function template(): string
    {
        return $this->loadSvgContent();
    }
}

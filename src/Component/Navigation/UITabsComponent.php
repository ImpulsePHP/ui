<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Navigation;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $tabs
 * @property int|string $active
 * @property string $color
 * @property string $variant
 * @property string $size
 * @property bool $fullWidth
 * @property bool $pill
 * @property string $orientation
 * @property bool $showContent
 */
final class UITabsComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const VARIANTS = ['underline', 'pills', 'bordered'];
    private const SIZES = ['small', 'normal', 'large'];
    private const ORIENTATIONS = ['horizontal', 'vertical'];

    public function setup(): void
    {
        $this->states([
            'tabs' => [],
            'active' => 0,
            'fullWidth' => false,
            'pill' => false,
            'showContent' => true,
        ]);

        $this->state('variant', 'underline', self::VARIANTS);
        $this->state('size', 'normal', self::SIZES);
        $this->state('orientation', 'horizontal', self::ORIENTATIONS);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function switchTab(string $tabId, int $index): void
    {
        $this->active = $index;

        $this->emit('tab-changed', [
            'tabId' => $tabId,
            'index' => $index,
            'tab' => $this->tabs[$index] ?? null
        ]);
    }

    private function getTabsListClasses(): string
    {
        $classes = [];

        // Base classes
        if ($this->orientation === 'vertical') {
            $classes[] = 'flex flex-col space-y-1';
            if ($this->fullWidth) {
                $classes[] = 'w-full';
            }
        } else {
            $classes[] = 'flex';
            if ($this->fullWidth) {
                $classes[] = 'w-full';
            } else {
                $classes[] = 'space-x-1';
            }
        }

        // Variant-specific classes
        switch ($this->variant) {
            case 'underline':
                $classes[] = $this->orientation === 'vertical'
                    ? 'border-r border-gray-200'
                    : 'border-b border-gray-200';
                break;
            case 'bordered':
                $classes[] = 'border border-gray-200 rounded-lg p-1 bg-gray-50';
                break;
        }

        return implode(' ', $classes);
    }

    private function getTabClasses(bool $isActive): string
    {
        $classes = [];
        $classes[] = 'relative inline-flex items-center justify-center font-medium transition-all duration-300';

        $classes[] = match ($this->size) {
            'small' => 'px-3 py-1.5 text-xs',
            'large' => 'px-6 py-3 text-lg',
            default => 'px-4 py-2 text-sm',
        };

        if ($this->fullWidth) {
            $classes[] = 'flex-1';
        }

        switch ($this->variant) {
            case 'underline':
                if ($isActive) {
                    $classes[] = TailwindColorUtility::getTabActiveClasses($this->color);
                    $classes[] = $this->orientation === 'vertical' ? 'border-r-2' : 'border-b-2';
                } else {
                    $classes[] = 'text-gray-500 hover:text-gray-700';
                    if ($this->orientation === 'vertical') {
                        $classes[] = 'border-r-2 border-transparent hover:border-gray-300';
                    } else {
                        $classes[] = 'border-b-2 border-transparent hover:border-gray-300';
                    }
                }
                break;

            case 'pills':
                $classes[] = $this->pill ? 'rounded-full' : 'rounded-md';
                if ($isActive) {
                    $classes[] = TailwindColorUtility::getTabActiveClasses($this->color, 'pills');
                } else {
                    $classes[] = 'text-gray-500 hover:text-gray-700 hover:bg-gray-100';
                }
                break;

            case 'bordered':
                $classes[] = 'rounded-md';
                if ($isActive) {
                    $classes[] = TailwindColorUtility::getTabActiveClasses($this->color, 'bordered');
                } else {
                    $classes[] = 'text-gray-500 hover:text-gray-700 hover:bg-gray-100';
                }
                break;
        }

        $classes[] = TailwindColorUtility::getFocusRingClasses($this->color);

        return implode(' ', $classes);
    }

    private function getContentClasses(): string
    {
        $classes = ['mt-4'];
        if ($this->orientation === 'vertical') {
            $classes[] = 'flex-1 ml-4';
        }

        return implode(' ', $classes);
    }

    private function renderTabs(): string
    {
        if (empty($this->tabs)) {
            return '';
        }

        $tabsHtml = [];
        $activeIndex = is_string($this->active)
            ? array_search($this->active, array_column($this->tabs, 'id'), true)
            : $this->active
        ;

        foreach ($this->tabs as $index => $tab) {
            $isActive = $index === (int) $activeIndex;
            $tabId = is_array($tab) ? ($tab['id'] ?? "tab-{$index}") : "tab-{$index}";
            $tabLabel = is_array($tab) ? ($tab['label'] ?? $tab['title'] ?? "Tab {$index}") : $tab;
            $tabIcon = is_array($tab) ? ($tab['icon'] ?? '') : '';
            $tabDisabled = is_array($tab) ? ($tab['disabled'] ?? false) : false;

            $tabClasses = $this->getTabClasses($isActive);

            if ($tabDisabled) {
                $tabClasses .= ' opacity-50 cursor-not-allowed pointer-events-none';
            } else {
                $tabClasses .= ' cursor-pointer';
            }

            $iconHtml = '';
            if (!empty($tabIcon)) {
                $iconSize = match ($this->size) {
                    'small' => '4',
                    'large' => '6',
                    default => '5',
                };

                $iconHtml = <<<HTML
                    <uiicon name="{$tabIcon}" variant="outline" size="{$iconSize}" class="mr-2" />
                HTML;
            }

            $ariaSelected = $isActive ? 'true' : 'false';
            $isDisabled = ($tabDisabled ? 'disabled' : '');

            $tabsHtml[] = <<<HTML
                <button 
                    type="button"
                    role="tab"
                    aria-selected="{$ariaSelected}"
                    aria-controls="tabpanel-{$tabId}"
                    id="tab-{$tabId}"
                    class="{$tabClasses}"
                    data-action-click="switchTab('{$tabId}', {$index})"
                    {$isDisabled}
                >
                    {$iconHtml}
                    {$tabLabel}
                </button>
            HTML;
        }

        return implode('', $tabsHtml);
    }

    private function renderContent(): string
    {
        if (!$this->showContent || empty($this->tabs)) {
            return '';
        }

        $contentHtml = [];
        $activeIndex = is_string($this->active) ? array_search($this->active, array_column($this->tabs, 'id'), true) : $this->active;

        foreach ($this->tabs as $index => $tab) {
            $isActive = $index === $activeIndex;
            $tabId = is_array($tab) ? ($tab['id'] ?? "tab-{$index}") : "tab-{$index}";
            $tabContent = is_array($tab) ? ($tab['content'] ?? '') : '';

            $displayClass = $isActive ? 'block' : 'hidden';

            $contentHtml[] = <<<HTML
                <div 
                    role="tabpanel"
                    id="tabpanel-{$tabId}"
                    aria-labelledby="tab-{$tabId}"
                    class="{$displayClass}"
                >
                    {$tabContent}
                </div>
            HTML;
        }

        $contentClasses = $this->getContentClasses();
        $implodeContentHtml = implode('', $contentHtml);

        return <<<HTML
            <div class="{$contentClasses}">
                {$implodeContentHtml}
            </div>
        HTML;
    }

    public function template(): string
    {
        $tabsListClasses = $this->getTabsListClasses();
        $tabsHtml = $this->renderTabs();
        $contentHtml = $this->renderContent();

        $orientation = $this->orientation;
        $wrapperClasses = $orientation === 'vertical' ? 'flex' : '';

        return <<<HTML
            <div class="ui-tabs flex flex-col" data-orientation="{$orientation}">
                <div class="{$wrapperClasses}">
                    <div 
                        role="tablist" 
                        aria-orientation="{$orientation}"
                        class="{$tabsListClasses}"
                    >
                        {$tabsHtml}
                    </div>
                    {$contentHtml}
                </div>
            </div>
        HTML;
    }
}

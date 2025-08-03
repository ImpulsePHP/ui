<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $title
 * @property string $description
 * @property string $color
 * @property string $variant
 * @property bool $withIcon
 * @property bool $withClose
 * @property string $iconName
 * @property bool $dismissible
 */
final class UIAlertComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const VARIANTS = ['filled', 'outline', 'solid'];

    public function setup(): void
    {
        $this->states([
            'title' => '',
            'description' => '',
            'withIcon' => true,
            'withClose' => false,
            'iconName' => '',
            'dismissible' => false,
        ]);

        $this->state('color', 'blue', TailwindColorUtility::getAllColors());
        $this->state('variant', 'filled', self::VARIANTS);
    }

    #[Action]
    public function dismiss(): void
    {
        $this->emit('alert-dismissed', [
            'title' => $this->title,
            'color' => $this->color,
        ]);
    }

    private function getContainerClasses(): string
    {
        $baseClasses = 'w-full rounded-md py-4 px-6';
        $variantClasses = $this->getVariantClasses();

        return "{$baseClasses} {$variantClasses}";
    }

    private function getVariantClasses(): string
    {
        return match ($this->variant) {
            'outline' => TailwindColorUtility::getAlertOutlineClasses($this->color),
            'solid' => TailwindColorUtility::getAlertSolidClasses($this->color),
            default => TailwindColorUtility::getAlertFilledClasses($this->color),
        };
    }

    private function getTitleClasses(): string
    {
        $fontWeight = $this->description !== '' ? 'font-bold' : 'font-medium';
        return "text-sm {$fontWeight}";
    }

    private function getDescriptionClasses(): string
    {
        return "text-sm font-normal";
    }

    private function getIconClasses(): string
    {
        $iconColor = $this->variant === 'solid' ? 'fill-white' : TailwindColorUtility::getAlertIconClasses($this->color);
        return "mr-1 {$iconColor}";
    }

    private function renderIcon(): string
    {
        if (!$this->withIcon) {
            return '';
        }

        if ($this->iconName) {
            $iconClasses = $this->getIconClasses();
            return <<<HTML
                <uiicon name="{$this->iconName}" size="6" class="{$iconClasses}" />
            HTML;
        }

        return '';
    }

    private function renderCloseButton(): string
    {
        if (!$this->withClose && !$this->dismissible) {
            return '';
        }

        $action = $this->dismissible ? 'data-action-click="dismiss()"' : 'data-toggle-class="hidden" data-target="#' . $this->getComponentId() . '"';

        return <<<HTML
            <div
                class="cursor-pointer my-auto opacity-65 transition-opacity duration-300 hover:opacity-100"
                {$action}
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                  <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        HTML;
    }

    public function template(): string
    {
        $containerClasses = $this->getContainerClasses();
        $titleClasses = $this->getTitleClasses();
        $descriptionClasses = $this->getDescriptionClasses();

        $icon = $this->renderIcon();
        $closeButton = $this->renderCloseButton();

        $description = '';
        if ($this->description !== '') {
            $description = <<<HTML
                <p class="{$descriptionClasses}">
                    {$this->description}
                </p>
            HTML;
        }

        return <<<HTML
            <div class="ui-alert {$containerClasses}">
                <div class="flex items-center gap-2 relative">
                    {$icon}
                    <div class="flex-1">
                        <h3 class="{$titleClasses}">
                            {$this->title}
                        </h3>
                        {$description}
                    </div>
                    {$closeButton}
                </div>
            </div>
        HTML;
    }
}

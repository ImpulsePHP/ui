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
 * @property string $iconName
 * @property string $size
 * @property string $color
 * @property array $primaryAction
 * @property array $secondaryAction
 * @property bool $showBorder
 * @property string $variant
 */
final class UIEmptyStateComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const VARIANTS = ['default', 'card'];

    /**
     * @throws \ReflectionException
     */
    public function setup(): void
    {
        $this->states([
            'title' => $this->trans('empty_state.no_items'),
            'description' => $this->trans('empty_state.description'),
            'iconName' => '',
            'showBorder' => false,
            'primaryAction' => [],
            'secondaryAction' => [],
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'slate', TailwindColorUtility::getAllColors());
        $this->state('variant', 'default', self::VARIANTS);
    }

    #[Action]
    public function primaryActionClicked(): void
    {
        if (!empty($this->primaryAction['action'])) {
            $this->emit('empty-state-action', [
                'action' => $this->primaryAction['action'],
                'type' => 'primary'
            ]);
        }
    }

    #[Action]
    public function secondaryActionClicked(): void
    {
        if (!empty($this->secondaryAction['action'])) {
            $this->emit('empty-state-action', [
                'action' => $this->secondaryAction['action'],
                'type' => 'secondary'
            ]);
        }
    }

    private function getContainerClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'py-8 px-6',
            'large' => 'py-20 px-8',
            default => 'py-12 px-6',
        };

        $variantClasses = match ($this->variant) {
            'card' => 'bg-white rounded-lg',
            default => 'bg-gray-50 rounded-lg',
        };

        $borderClasses = $this->showBorder ? 'border-2 border-dashed border-gray-300' : '';

        return "text-center {$sizeClasses} {$variantClasses} {$borderClasses}";
    }

    private function getIconContainerClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'w-12 h-12',
            'large' => 'w-20 h-20',
            default => 'w-16 h-16',
        };

        $colorClasses = TailwindColorUtility::getEmptyStateIconClasses($this->color);

        return "mx-auto rounded-full flex items-center justify-center {$sizeClasses} {$colorClasses}";
    }

    private function getIconClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'w-6 h-6',
            'large' => 'w-10 h-10',
            default => 'w-8 h-8',
        };

        $colorClasses = TailwindColorUtility::getEmptyStateIconColorClasses($this->color);

        return "{$sizeClasses} {$colorClasses}";
    }

    private function getTitleClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'text-lg',
            'large' => 'text-2xl',
            default => 'text-xl',
        };

        $marginTop = $this->iconName === '' ? 'mt-0' : 'mt-4';

        return "{$marginTop} font-semibold text-gray-900 {$sizeClasses}";
    }

    private function getDescriptionClasses(): string
    {
        $sizeClasses = match ($this->size) {
            'small' => 'text-xs',
            default => 'text-sm',
        };

        return "mt-1 text-gray-500 max-w-md mx-auto {$sizeClasses}";
    }

    private function renderIcon(): string
    {
        if ($this->iconName === '') {
            return '';
        }

        $iconContainerClasses = $this->getIconContainerClasses();
        $iconClasses = $this->getIconClasses();

        return <<<HTML
            <div class="{$iconContainerClasses}">
                <uiicon name="{$this->iconName}" class="{$iconClasses}" size="{$this->size}"></uiicon>
            </div>
        HTML;
    }

    private function renderActions(): string
    {
        if (empty($this->primaryAction) && empty($this->secondaryAction)) {
            return '';
        }

        $actionsHtml = '';

        if (!empty($this->primaryAction)) {
            $actionsHtml .= <<<HTML
                <uibutton
                    type="button"
                    color="{$this->color}"
                    variant="solid"
                    label="{$this->primaryAction['label']}"
                    size="normal"
                    data-action-click="primaryActionClicked()"
                />
            HTML;
        }

        if (!empty($this->secondaryAction)) {
            $marginClass = !empty($this->primaryAction) ? 'ml-3' : '';
            $actionsHtml .= <<<HTML
                <uibutton
                    type="button"
                    color="slate"
                    variant="filled"
                    label="{$this->secondaryAction['label']}"
                    size="normal"
                    data-action-click="secondaryActionClicked()"
                    class="{$marginClass}"
                />
            HTML;
        }

        return <<<HTML
            <div class="mt-6 flex justify-center items-center gap-1">
                {$actionsHtml}
            </div>
        HTML;
    }

    public function template(): string
    {
        $containerClasses = $this->getContainerClasses();
        $titleClasses = $this->getTitleClasses();
        $descriptionClasses = $this->getDescriptionClasses();

        $icon = $this->renderIcon();
        $actions = $this->renderActions();

        return <<<HTML
            <div class="ui-empty-state">
                <div class="{$containerClasses}">
                    {$icon}
                    <h3 class="{$titleClasses}">{$this->title}</h3>
                    <p class="{$descriptionClasses}">{$this->description}</p>
                    {$actions}
                </div>
            </div>
        HTML;
    }
}

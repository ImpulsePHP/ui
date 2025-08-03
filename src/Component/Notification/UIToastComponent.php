<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Notification;

use Impulse\Core\Component\AbstractComponent;
use Impulse\Core\Attributes\Action;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $title
 * @property string $message
 * @property string $color
 * @property string $position
 * @property int $duration
 * @property bool $dismissible
 * @property bool $visible
 * @property bool $autoHide
 * @property string $actionText
 * @property string $actionUrl
 * @property string $iconName
 * @property bool $showIcon
 * @property bool $showProgress
 * @property int $remainingTime
 */
final class UIToastComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const POSITIONS = [
        'top-right', 'top-left', 'top-center',
        'bottom-right', 'bottom-left', 'bottom-center',
        'center'
    ];

    private static int $toastCounter = 0;

    public function setup(): void
    {
        $this->states([
            'title' => '',
            'message' => '',
            'duration' => 5000,
            'dismissible' => true,
            'visible' => false,
            'autoHide' => true,
            'actionText' => '',
            'actionUrl' => '',
            'iconName' => '',
            'showIcon' => true,
            'showProgress' => true,
            'remainingTime' => 0,
        ]);

        $this->state('color', 'blue', TailwindColorUtility::getAllColors());
        $this->state('position', 'top-right', self::POSITIONS);

        $this->remainingTime = $this->duration;
    }

    #[Action]
    public function show(string $message = '', string $title = '', string $color = 'blue'): void
    {
        if ($message) {
            $this->message = $message;
        }

        if ($title) {
            $this->title = $title;
        }

        if (in_array($color, TailwindColorUtility::getAllColors(), true)) {
            $this->color = $color;
        }

        $this->visible = true;
        $this->remainingTime = $this->duration;

        $this->emit('toast-shown', [
            'color' => $this->color,
            'message' => $this->message,
            'title' => $this->title
        ]);
    }

    #[Action]
    public function hide(): void
    {
        $this->visible = false;

        $this->emit('toast-hidden', [
            'color' => $this->color,
            'message' => $this->message
        ]);
    }

    #[Action]
    public function updateTimer(int $remainingTime): void
    {
        $this->remainingTime = max(0, $remainingTime);

        if ($this->remainingTime <= 0 && $this->autoHide && $this->visible) {
            $this->hide();
        }
    }

    #[Action]
    public function performAction(): void
    {
        if ($this->actionUrl) {
            $this->emit('toast-action', [
                'url' => $this->actionUrl,
                'text' => $this->actionText
            ]);
        }

        $this->hide();
    }

    private function getToastId(): string
    {
        return 'toast-' . $this->getComponentId() . '-' . (++self::$toastCounter);
    }

    private function getPositionClasses(): string
    {
        return match ($this->position) {
            'top-left' => 'fixed top-4 left-4 z-50',
            'top-center' => 'fixed top-4 left-1/2 transform -translate-x-1/2 z-50',
            'bottom-right' => 'fixed bottom-4 right-4 z-50',
            'bottom-left' => 'fixed bottom-4 left-4 z-50',
            'bottom-center' => 'fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50',
            'center' => 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50',
            default => 'fixed top-4 right-4 z-50',
        };
    }

    private function renderIcon(): string
    {
        if (!$this->showIcon) {
            return '';
        }

        $iconName = $this->iconName ?: TailwindColorUtility::getToastDefaultIcon($this->color);
        $iconClasses = TailwindColorUtility::getToastIconClasses($this->color);

        return <<<HTML
            <div class="flex-shrink-0">
                <uiicon name="{$iconName}" size="5" class="{$iconClasses}" />
            </div>
        HTML;
    }

    private function renderTitle(): string
    {
        if (!$this->title) {
            return '';
        }

        $textClasses = TailwindColorUtility::getToastTextClasses($this->color);

        return <<<HTML
            <h4 class="text-sm font-semibold {$textClasses} mb-1">
                {$this->title}
            </h4>
        HTML;
    }

    private function renderMessage(): string
    {
        if (!$this->message) {
            return '';
        }

        $textClasses = TailwindColorUtility::getToastTextClasses($this->color);

        return <<<HTML
            <p class="text-sm {$textClasses}">
                {$this->message}
            </p>
        HTML;
    }

    private function renderAction(): string
    {
        if (!$this->actionText) {
            return '';
        }

        $textClasses = TailwindColorUtility::getToastTextClasses($this->color);

        return <<<HTML
            <div class="mt-2">
                <button 
                    type="button"
                    class="text-sm font-medium {$textClasses} hover:underline focus:outline-none focus:underline"
                    data-action-click="performAction"
                >
                    {$this->actionText}
                </button>
            </div>
        HTML;
    }

    /**
     * @throws \ReflectionException
     */
    private function renderDismissButton(): string
    {
        if (!$this->dismissible) {
            return '';
        }

        $textClasses = TailwindColorUtility::getToastTextClasses($this->color);

        return <<<HTML
            <div class="ml-auto pl-3">
                <button 
                    type="button"
                    class="inline-flex {$textClasses} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-500 rounded-md"
                    data-action-click="hide"
                >
                    <span class="sr-only">{$this->trans('toast.dismiss')}</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        HTML;
    }

    private function renderProgressBar(): string
    {
        if (!$this->showProgress || !$this->autoHide || $this->duration <= 0) {
            return '';
        }

        $progressClasses = TailwindColorUtility::getToastProgressClasses($this->color);
        $progressPercentage = $this->duration > 0 ? ($this->remainingTime / $this->duration) * 100 : 0;

        return <<<HTML
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-200 rounded-b-lg overflow-hidden">
                <div 
                    class="h-full {$progressClasses} transition-all duration-100 ease-linear"
                    style="width: {$progressPercentage}%"
                    data-toast-progress
                ></div>
            </div>
        HTML;
    }

    private function getToastAttributes(): string
    {
        $toastId = $this->getToastId();
        $attributes = [
            'id' => $toastId,
            'data-toast-id' => $toastId,
            'data-toast-color' => $this->color,
            'data-toast-position' => $this->position,
        ];

        if ($this->autoHide && $this->duration > 0) {
            $attributes['data-toast-timer'] = (string)$this->duration;
            $attributes['data-toast-auto-hide'] = 'true';
        }

        if ($this->visible) {
            $attributes['data-toast-entering'] = 'true';
        }

        $attributeString = '';
        foreach ($attributes as $key => $value) {
            $attributeString .= " {$key}=\"" . htmlspecialchars($value, ENT_QUOTES) . "\"";
        }

        return $attributeString;
    }

    /**
     * @throws \ReflectionException
     */
    public function template(): string
    {
        if (!$this->visible) {
            return '';
        }

        $positionClasses = $this->getPositionClasses();
        $backgroundClasses = TailwindColorUtility::getToastBackgroundClasses($this->color);
        $toastAttributes = $this->getToastAttributes();
        $icon = $this->renderIcon();
        $title = $this->renderTitle();
        $message = $this->renderMessage();
        $action = $this->renderAction();
        $dismissButton = $this->renderDismissButton();
        $progressBar = $this->renderProgressBar();

        return <<<HTML
            <div 
                class="ui-toast {$positionClasses} max-w-sm w-full {$backgroundClasses} border rounded-lg shadow-lg pointer-events-auto relative"
                {$toastAttributes}
                role="alert"
                aria-live="polite"
                aria-atomic="true"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        {$icon}
                        <div class="ml-3 w-0 flex-1">
                            {$title}
                            {$message}
                            {$action}
                        </div>
                        {$dismissButton}
                    </div>
                </div>
                {$progressBar}
            </div>
        HTML;
    }
}

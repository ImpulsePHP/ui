<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $title
 * @property string $content
 * @property bool $open
 * @property string $size
 * @property string $color
 * @property bool $closeOnBackdrop
 * @property bool $showFooter
 * @property string $confirmLabel
 * @property string $cancelLabel
 * @property string $confirmColor
 */
final class UIModalComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large', 'xl'];

    public function setup(): void
    {
        $this->states([
            'title' => 'Modal title',
            'content' => '',
            'open' => false,
            'closeOnBackdrop' => true,
            'showFooter' => true,
            'confirmLabel' => 'Confirm',
            'cancelLabel' => 'Cancel',
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('confirmColor', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function openModal(): void
    {
        $this->open = true;
    }

    #[Action]
    public function closeModal(): void
    {
        $this->open = false;
    }

    #[Action]
    public function toggleModal(): void
    {
        $this->open = !$this->open;
    }

    #[Action]
    public function confirm(): void
    {
        $this->emit('modal-confirmed', ['title' => $this->title]);
        $this->open = false;
    }

    #[Action]
    public function cancel(): void
    {
        $this->emit('modal-cancelled', ['title' => $this->title]);
        $this->open = false;
    }

    private function getDialogWidthClass(): string
    {
        return match ($this->size) {
            'small' => 'max-w-sm',
            'large' => 'max-w-3xl',
            'xl' => 'max-w-5xl',
            default => 'max-w-lg',
        };
    }

    private function renderFooter(): string
    {
        if (!$this->showFooter) {
            return '';
        }

        $cancelClass = 'px-3 py-2 text-sm rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50';
        $confirmClass = 'px-3 py-2 text-sm rounded-md text-white ' . TailwindColorUtility::getButtonClasses($this->confirmColor, 'solid');

        return <<<HTML
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" class="{$cancelClass}" data-action-click="cancel()">{$this->cancelLabel}</button>
                <button type="button" class="{$confirmClass}" data-action-click="confirm()">{$this->confirmLabel}</button>
            </div>
        HTML;
    }

    public function template(): string
    {
        $hiddenClass = $this->open ? '' : 'hidden';
        $dialogWidth = $this->getDialogWidthClass();
        $headerAccent = "bg-{$this->color}-50 border-{$this->color}-200 text-{$this->color}-700";
        $footer = $this->renderFooter();

        $backdropAction = $this->closeOnBackdrop ? 'data-action-click="closeModal()"' : '';
        $closeOnBackdrop = $this->closeOnBackdrop ? 'true' : 'false';
        $plainContent = htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8');
        $slotContent = $this->slot();

        return <<<HTML
            <div class="ui-modal {$hiddenClass} fixed inset-0 z-50" aria-hidden="true" data-close-on-backdrop="{$closeOnBackdrop}">
                <div class="absolute inset-0 bg-slate-900/50" {$backdropAction}></div>
                <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                    <div class="w-full {$dialogWidth} bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 border-b {$headerAccent}">
                            <h3 class="font-semibold">{$this->title}</h3>
                            <button type="button" class="text-slate-500 hover:text-slate-700" data-action-click="closeModal()">
                                <uiicon name="x-mark" size="5" class="text-current" />
                            </button>
                        </div>
                        <div class="p-4 text-sm text-slate-700 space-y-3">
                            <p>{$plainContent}</p>
                            {$slotContent}
                        </div>
                        <div class="px-4 pb-4">{$footer}</div>
                    </div>
                </div>
            </div>
        HTML;
    }
}


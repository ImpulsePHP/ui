<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $title
 * @property string $content
 * @property bool $open
 * @property string $side
 * @property string $width
 * @property bool $closeOnBackdrop
 */
final class UIDrawerComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIDES = ['left', 'right'];

    public function setup(): void
    {
        $this->states([
            'title' => $this->transOrDefault('drawer.title', 'Drawer'),
            'content' => '',
            'open' => false,
            'width' => 'w-96',
            'closeOnBackdrop' => true,
        ]);

        $this->state('side', 'right', self::SIDES);
    }

    #[Action]
    public function openDrawer(): void
    {
        $this->open = true;
    }

    #[Action]
    public function closeDrawer(): void
    {
        $this->open = false;
    }

    #[Action]
    public function toggleDrawer(): void
    {
        $this->open = !$this->open;
    }

    public function template(): string
    {
        $position = $this->side === 'left' ? 'left-0' : 'right-0';
        $backdropAction = $this->closeOnBackdrop ? 'data-action-click="closeDrawer()"' : '';
        $translateClosed = $this->side === 'left' ? '-100%' : '100%';
        $translateValue = $this->open ? '0%' : $translateClosed;
        $backdropVisible = $this->open ? 'block' : 'hidden';
        $containerPointerClass = $this->open ? '' : 'pointer-events-none';
        $closeLabel = $this->transOrDefault('common.close', 'close');

        return <<<HTML
            <div class="ui-drawer fixed inset-0 z-50 {$containerPointerClass}" aria-hidden="false">
                <div class="absolute inset-0 bg-slate-900/40 {$backdropVisible}" {$backdropAction}></div>
                <aside class="absolute top-0 bottom-0 {$position} {$this->width} bg-white border-l border-slate-200 shadow-xl" style="transform: translateX({$translateValue}); transition: transform 300ms ease; will-change: transform;">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
                        <h3 class="font-semibold text-slate-800">{$this->title}</h3>
                        <button type="button" class="text-slate-500" data-action-click="closeDrawer()">{$closeLabel}</button>
                    </div>
                    <div class="p-4 text-sm text-slate-700 space-y-3">
                        <p>{$this->content}</p>
                        {$this->slot()}
                    </div>
                </aside>
            </div>
        HTML;
    }
}


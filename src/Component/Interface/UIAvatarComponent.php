<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property string $src
 * @property string $alt
 * @property string $initials
 * @property string $name
 * @property string $size
 * @property string $shape
 * @property string $color
 * @property string $variant
 * @property bool $border
 * @property string $status
 * @property string $notification
 * @property bool $clickable
 */
final class UIAvatarComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['tiny', 'small', 'normal', 'large', 'huge'];
    private const SHAPES = ['circle', 'square', 'rounded'];
    private const VARIANTS = ['filled', 'soft', 'outline'];
    private const STATUSES = ['', 'online', 'offline', 'busy', 'away'];

    public function setup(): void
    {
        $this->states([
            'src' => '',
            'alt' => '',
            'initials' => '',
            'name' => '',
            'border' => false,
            'notification' => '',
            'clickable' => false,
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('shape', 'circle', self::SHAPES);
        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
        $this->state('variant', 'filled', self::VARIANTS);
        $this->state('status', '', self::STATUSES);
    }

    private function getInitials(): string
    {
        if (!empty($this->initials)) {
            return strtoupper(substr($this->initials, 0, 2));
        }

        if (!empty($this->name)) {
            $nameParts = explode(' ', trim($this->name));
            if (count($nameParts) >= 2) {
                return strtoupper($nameParts[0][0] . $nameParts[1][0]);
            }
            return strtoupper(substr($nameParts[0], 0, 2));
        }

        return 'AN';
    }

    private function getAvatarClasses(): string
    {
        $classes = [];
        $classes[] = 'inline-flex items-center justify-center font-semibold relative overflow-hidden';
        $classes[] = $this->getSizeClasses();
        $classes[] = $this->getShapeClasses();

        if (empty($this->src)) {
            $classes[] = $this->getColorClasses();
        } else {
            $classes[] = 'bg-gray-100';
        }

        if ($this->border) {
            $classes[] = 'ring-2 ring-white';
        }

        if ($this->clickable) {
            $classes[] = 'cursor-pointer hover:opacity-80 transition-opacity duration-200';
        }

        return implode(' ', $classes);
    }

    private function getSizeClasses(): string
    {
        return match ($this->size) {
            'tiny' => 'w-6 h-6 text-xs',
            'small' => 'w-8 h-8 text-sm',
            'large' => 'w-16 h-16 text-2xl',
            'huge' => 'w-24 h-24 text-4xl',
            default => 'w-10 h-10 text-base',
        };
    }

    private function getShapeClasses(): string
    {
        return match ($this->shape) {
            'square' => '',
            'rounded' => 'rounded-lg',
            default => 'rounded-full',
        };
    }

    private function getColorClasses(): string
    {
        return TailwindColorUtility::getAvatarClasses($this->color, $this->variant);
    }

    private function getStatusSize(): string
    {
        return match ($this->size) {
            'tiny' => 'w-1.5 h-1.5',
            'small' => 'w-2 h-2',
            'large' => 'w-4 h-4',
            'huge' => 'w-6 h-6',
            default => 'w-3 h-3',
        };
    }

    private function getStatusPosition(): string
    {
        return match ($this->size) {
            'tiny', 'small' => 'bottom-0 right-0',
            'large' => 'bottom-1 right-1',
            'huge' => 'bottom-2 right-2',
            default => 'bottom-0.5 right-0.5',
        };
    }

    private function getStatusColor(): string
    {
        return match ($this->status) {
            'online' => 'bg-green-500',
            'busy' => 'bg-red-500',
            'away' => 'bg-yellow-500',
            default => 'bg-gray-400',
        };
    }

    private function getNotificationSize(): string
    {
        return match ($this->size) {
            'tiny' => 'w-3 h-3 text-xs',
            'small' => 'w-4 h-4 text-xs',
            'large' => 'w-6 h-6 text-sm',
            'huge' => 'w-8 h-8 text-base',
            default => 'w-5 h-5 text-xs',
        };
    }

    private function getNotificationPosition(): string
    {
        return match ($this->size) {
            'tiny', 'small' => '-top-1 -right-1',
            'huge' => '-top-3 -right-3',
            default => '-top-2 -right-2',
        };
    }

    private function renderImage(): string
    {
        if (empty($this->src)) {
            return '';
        }

        $alt = $this->alt ?: $this->name ?: 'Avatar';

        return <<<HTML
            <img 
                src="{$this->src}"
                alt="{$alt}"
                class="w-full h-full object-cover"
                loading="lazy"
            />
        HTML;
    }

    private function renderInitials(): string
    {
        if (!empty($this->src)) {
            return '';
        }

        $initials = $this->getInitials();

        return <<<HTML
            <span class="text-current select-none">
                {$initials}
            </span>
        HTML;
    }

    private function renderStatus(): string
    {
        if (empty($this->status)) {
            return '';
        }

        $statusSize = $this->getStatusSize();
        $statusPosition = $this->getStatusPosition();
        $statusColor = $this->getStatusColor();

        return <<<HTML
            <span 
                class="absolute {$statusPosition} {$statusSize} {$statusColor} rounded-full ring-2 ring-white"
                aria-label="Status: {$this->status}"
            ></span>
        HTML;
    }

    private function renderNotification(): string
    {
        if (empty($this->notification)) {
            return '';
        }

        $notificationSize = $this->getNotificationSize();
        $notificationPosition = $this->getNotificationPosition();

        return <<<HTML
            <span 
                class="absolute {$notificationPosition} {$notificationSize} bg-red-500 text-white rounded-full flex items-center justify-center font-bold ring-2 ring-white"
                aria-label="Notifications: {$this->notification}"
            >
                {$this->notification}
            </span>
        HTML;
    }

    public function template(): string
    {
        $avatarClasses = $this->getAvatarClasses();
        $image = $this->renderImage();
        $initials = $this->renderInitials();
        $status = $this->renderStatus();
        $notification = $this->renderNotification();

        $clickableAttributes = '';
        if ($this->clickable) {
            $clickableAttributes = 'role="button" tabindex="0"';
        }

        return <<<HTML
            <div class="ui-avatar inline-block relative">
                <div 
                    class="{$avatarClasses}"
                    {$clickableAttributes}
                >
                    {$image}
                    {$initials}
                </div>
                {$status}
                {$notification}
            </div>
        HTML;
    }
}

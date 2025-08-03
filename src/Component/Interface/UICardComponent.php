<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $title
 * @property string $subtitle
 * @property string $description
 * @property string $imageSrc
 * @property string $imageAlt
 * @property string $imagePosition
 * @property string $size
 * @property string $variant
 * @property bool $shadow
 * @property bool $border
 * @property bool $rounded
 * @property bool $hoverable
 * @property bool $clickable
 * @property string $href
 * @property string $padding
 * @property string $spacing
 * @property bool $withDivider
 * @property array $badges
 * @property array $actions
 * @property array $icons
 * @property array $user
 */
final class UICardComponent extends AbstractComponent
{
    use UIComponentTrait;

    private const SIZES = ['small', 'normal', 'large'];
    private const VARIANTS = ['filled', 'outline', 'shadow', 'flat'];
    private const IMAGE_POSITIONS = ['top', 'left', 'right'];
    private const PADDINGS = ['none', 'small', 'normal', 'large'];
    private const SPACINGS = ['none', 'small', 'normal', 'large'];

    public function setup(): void
    {
        $this->states([
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'imageSrc' => '',
            'imageAlt' => '',
            'shadow' => false,
            'border' => false,
            'rounded' => true,
            'hoverable' => false,
            'clickable' => false,
            'href' => '',
            'withDivider' => false,
            'badges' => [],
            'actions' => [],
            'icons' => [],
            'user' => [],
        ]);

        $this->state('size', 'normal', self::SIZES);
        $this->state('variant', 'shadow', self::VARIANTS);
        $this->state('imagePosition', 'top', self::IMAGE_POSITIONS);
        $this->state('padding', 'normal', self::PADDINGS);
        $this->state('spacing', 'normal', self::SPACINGS);
    }

    private function getCardClasses(): string
    {
        $classes = [];
        $classes[] = 'ui-card relative overflow-hidden transition-all duration-200';
        $classes[] = $this->getSizeClasses();
        $classes[] = $this->getVariantClasses();

        if ($this->rounded) {
            $classes[] = 'rounded-lg';
        }

        if ($this->shadow && $this->variant !== 'shadow') {
            $classes[] = 'shadow-sm';
        }

        if ($this->border) {
            $classes[] = 'border border-gray-200';
        }

        if ($this->hoverable) {
            $classes[] = 'hover:shadow-md hover:-translate-y-0.5 cursor-pointer';
        }

        if ($this->clickable && !empty($this->href)) {
            $classes[] = 'cursor-pointer hover:shadow-lg';
        }

        return implode(' ', $classes);
    }

    private function getSizeClasses(): string
    {
        return match ($this->size) {
            'small' => 'max-w-sm',
            'large' => 'max-w-2xl',
            default => 'max-w-lg',
        };
    }

    private function getVariantClasses(): string
    {
        return match ($this->variant) {
            'filled' => 'bg-white',
            'outline' => 'bg-white border border-gray-200',
            'shadow' => 'bg-white shadow-lg',
            'flat' => 'bg-gray-50',
            default => 'bg-white shadow-md',
        };
    }

    private function getPaddingClasses(): string
    {
        return match ($this->padding) {
            'none' => 'p-0',
            'small' => 'p-4',
            'large' => 'p-8',
            default => 'p-6',
        };
    }

    private function getSpacingClasses(): string
    {
        return match ($this->spacing) {
            'none' => 'space-y-0',
            'small' => 'space-y-2',
            'large' => 'space-y-6',
            default => 'space-y-4',
        };
    }

    private function renderImage(): string
    {
        if (empty($this->imageSrc)) {
            return '';
        }

        $imageAlt = $this->imageAlt ?: 'Image de la carte';
        $imageClasses = $this->getImageClasses();

        return <<<HTML
            <div class="{$imageClasses['container']}">
                <img 
                    src="{$this->imageSrc}"
                    alt="{$imageAlt}"
                    class="{$imageClasses['image']}"
                    loading="lazy"
                />
            </div>
        HTML;
    }

    private function getImageClasses(): array
    {
        $rounded = '';
        if (!$this->shadow && !$this->border && $this->rounded) {
            $rounded = 'rounded-lg';
        }

        return match ($this->imagePosition) {
            'left', 'right' => [
                'container' => 'flex-shrink-0 w-48',
                'image' => "{$rounded} w-full h-full object-cover"
            ],
            default => [ // top
                'container' => 'w-full h-48 overflow-hidden',
                'image' => "{$rounded} w-full h-full object-cover"
            ],
        };
    }

    private function renderBadges(): string
    {
        if (empty($this->badges) || !is_array($this->badges)) {
            return '';
        }

        $badgeElements = [];
        foreach ($this->badges as $badge) {
            if (!is_array($badge)) {
                continue;
            }

            $label = $badge['label'] ?? '';
            $color = $badge['color'] ?? 'slate';
            $variant = $badge['variant'] ?? 'filled';

            if (!empty($label)) {
                $badgeElements[] = <<<HTML
                    <uibadge label="{$label}" color="{$color}" variant="{$variant}" />
                HTML;
            }
        }

        if (empty($badgeElements)) {
            return '';
        }

        $badgeContent = implode('', $badgeElements);

        return <<<HTML
            <div class="flex flex-wrap gap-2">
                {$badgeContent}
            </div>
        HTML;
    }

    private function renderHeader(): string
    {
        if (empty($this->title) && empty($this->subtitle) && empty($this->badges)) {
            return '';
        }

        $titleContent = '';
        $subtitleContent = '';

        if (!empty($this->title)) {
            $titleContent = <<<HTML
                <h3 class="text-base font-semibold text-gray-900 leading-tight">
                    {$this->title}
                </h3>
            HTML;
        }

        if (!empty($this->subtitle)) {
            $subtitleContent = <<<HTML
                <p class="text-xs text-gray-600 mt-1">
                    {$this->subtitle}
                </p>
            HTML;
        }

        $badges = $this->renderBadges();
        $badgeSection = !empty($badges) ? <<<HTML
            <div class="flex justify-end">
                {$badges}
            </div>
            HTML : '';

        return <<<HTML
            <div class="card-header">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        {$titleContent}
                        {$subtitleContent}
                    </div>
                    {$badgeSection}
                </div>
            </div>
        HTML;
    }

    private function renderBody(): string
    {
        if (empty($this->description)) {
            return '';
        }

        return <<<HTML
            <div class="card-body">
                <p class="text-gray-700 leading-relaxed">
                    {$this->description}
                </p>
            </div>
        HTML;
    }

    private function renderIcons(): string
    {
        if (empty($this->icons) || !is_array($this->icons)) {
            return '';
        }

        $iconElements = [];
        foreach ($this->icons as $icon) {
            if (!is_array($icon)) {
                continue;
            }

            $iconName = $icon['iconName'] ?? '';
            $color = $icon['color'] ?? 'gray-500';
            $value = $icon['value'] ?? '';
            $href = $icon['href'] ?? '';
            $route = $icon['route'] ?? '';

            if (empty($iconName)) {
                continue;
            }

            $iconElement = <<<HTML
                <uiicon name="{$iconName}" size="5" class="text-{$color}" />
            HTML;

            $valueElement = !empty($value) ? <<<HTML
                <span class="text-sm text-gray-600">{$value}</span>
            HTML : '';

            $content = <<<HTML
                <div class="flex items-center gap-2">
                    {$iconElement}
                    {$valueElement}
                </div>
            HTML;

            if (!empty($href) || !empty($route)) {
                $link = !empty($href) ? $href : "#{$route}";
                $iconElements[] = <<<HTML
                    <a href="{$link}" class="hover:opacity-80 transition-opacity">
                        {$content}
                    </a>
                HTML;
            } else {
                $iconElements[] = $content;
            }
        }

        if (empty($iconElements)) {
            return '';
        }

        $badgeContent = implode('', $iconElements);

        return <<<HTML
            <div class="flex items-center gap-4">
                {$badgeContent}
            </div>
        HTML;
    }

    private function renderUser(): string
    {
        if (empty($this->user) || !is_array($this->user)) {
            return '';
        }

        $image = $this->user['image'] ?? '';
        $text = $this->user['text'] ?? '';

        if (empty($image) && empty($text)) {
            return '';
        }

        $avatarProps = ['size' => 'small'];
        if (!empty($image)) {
            $avatarProps['src'] = $image;
        } else {
            $avatarProps['initials'] = $text;
        }

        $propsString = '';
        foreach ($avatarProps as $key => $value) {
            $propsString .= " {$key}=\"{$value}\"";
        }

        $valueContent = !empty($text) ? <<<HTML
            <span class="text-sm text-gray-600">{$text}</span>
        HTML : '';

        return <<<HTML
            <div class="flex items-center gap-3 pt-4">
                <uiavatar{$propsString} />
                {$valueContent}
            </div>
        HTML;
    }

    private function renderActions(): string
    {
        if (empty($this->actions) || !is_array($this->actions)) {
            return '';
        }

        $actionElements = [];
        foreach ($this->actions as $action) {
            if (!is_array($action)) {
                continue;
            }

            $label = $action['label'] ?? '';
            $color = $action['color'] ?? 'indigo';
            $href = $action['href'] ?? '';
            $route = $action['route'] ?? '';
            $variant = $action['variant'] ?? 'outline';
            $size = $action['size'] ?? 'normal';

            if (empty($label)) {
                continue;
            }

            $buttonProps = [
                'label' => $label,
                'color' => $color,
                'variant' => $variant,
                'size' => $size
            ];

            $propsString = '';
            foreach ($buttonProps as $key => $value) {
                $propsString .= " {$key}=\"{$value}\"";
            }

            if (!empty($href) || !empty($route)) {
                $link = !empty($href) ? $href : "#{$route}";
                $actionElements[] = <<<HTML
                    <a href="{$link}">
                        <uibutton{$propsString} />
                    </a>
                HTML;
            } else {
                $actionElements[] = <<<HTML
                    <uibutton{$propsString} />
                HTML;
            }
        }

        if (empty($actionElements)) {
            return '';
        }

        $badgeContent = implode('', $actionElements);

        return <<<HTML
            <div class="flex items-center justify-end gap-3">
                {$badgeContent}
            </div>
        HTML;
    }

    private function renderFooter(): string
    {
        $icons = $this->renderIcons();
        $user = $this->renderUser();
        $actions = $this->renderActions();

        if (empty($icons) && empty($user) && empty($actions)) {
            return '';
        }

        $content = '';

        if (!empty($icons)) {
            $content .= $icons;
        }

        if (!empty($user)) {
            $content .= $user;
        }

        if (!empty($actions)) {
            $content .= $actions;
        }

        return <<<HTML
            <div class="card-footer space-y-3">
                {$content}
            </div>
        HTML;
    }

    private function getContentLayout(): string
    {
        $paddingClasses = $this->getPaddingClasses();
        $spacingClasses = $this->getSpacingClasses();

        $header = $this->renderHeader();
        $body = $this->renderBody();
        $footer = $this->renderFooter();

        $divider = '';
        if ($this->withDivider && !empty($header) && (!empty($body) || !empty($footer))) {
            $divider = '<hr class="border-gray-200">';
        }

        return <<<HTML
            <div class="{$paddingClasses} {$spacingClasses}">
                {$header}
                {$divider}
                {$body}
                {$footer}
            </div>
        HTML;
    }

    public function template(): string
    {
        $cardClasses = $this->getCardClasses();
        $image = $this->renderImage();
        $content = $this->getContentLayout();

        if ($this->imagePosition === 'left') {
            $cardContent = <<<HTML
                <div class="flex">
                    {$image}
                    <div class="flex-1">
                        {$content}
                    </div>
                </div>
            HTML;
        } elseif ($this->imagePosition === 'right') {
            $cardContent = <<<HTML
                <div class="flex">
                    <div class="flex-1">
                        {$content}
                    </div>
                    {$image}
                </div>
            HTML;
        } else {
            $cardContent = $image . $content;
        }

        $wrapperTag = 'div';
        $wrapperAttributes = '';

        if ($this->clickable && !empty($this->href)) {
            $wrapperTag = 'a';
            $wrapperAttributes = "href=\"{$this->href}\"";
        }

        return <<<HTML
            <{$wrapperTag} class="{$cardClasses}" {$wrapperAttributes}>
                {$cardContent}
            </{$wrapperTag}>
        HTML;
    }
}

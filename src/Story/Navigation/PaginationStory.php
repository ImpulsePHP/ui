<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UIPaginationComponent;

final class PaginationStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string
    {
        return 'Pagination';
    }

    public function description(): string
    {
        return 'Composant pagination avec resume, navigation et fenetre intelligente.';
    }

    public function componentClass(): string
    {
        return UIPaginationComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'page' => 1,
            'totalPages' => 12,
            'perPage' => 10,
            'totalItems' => 118,
            'maxVisible' => 7,
            'showSummary' => true,
            'size' => 'normal',
            'color' => 'indigo',
            'previousLabel' => 'Previous',
            'nextLabel' => 'Next',
        ];
    }

    public function variants(): array
    {
        return [
            'default' => [],
            'middle range' => [
                'page' => 6,
            ],
            'last page' => [
                'page' => 12,
            ],
            'compact' => [
                'size' => 'small',
                'maxVisible' => 5,
                'color' => 'slate',
            ],
            'large controls' => [
                'size' => 'large',
                'color' => 'blue',
            ],
            'no summary' => [
                'showSummary' => false,
                'color' => 'green',
            ],
            'custom labels' => [
                'previousLabel' => 'Back',
                'nextLabel' => 'Forward',
                'color' => 'purple',
            ],
        ];
    }
}

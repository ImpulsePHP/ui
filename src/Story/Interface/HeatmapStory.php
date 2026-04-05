<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIHeatmapComponent;
use Impulse\UI\Utility\TailwindColorUtility;

final class HeatmapStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Heatmap'; }
    public function description(): string { return 'Carte de chaleur simple.'; }
    public function componentClass(): string { return UIHeatmapComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'data' => [
                ['label' => '2026-04-01', 'v' => 2],
                ['label' => '2026-04-02', 'v' => 4]
            ],
            'color' => 'indigo',
        ];
    }

    public function variants(): array
    {
        return [
            'different color' => [
                'color' => 'blue'
            ],
            'more data' => [
                'data' => [
                    ['label' => '2026-04-01', 'v' => 1],
                    ['label' => '2026-04-02', 'v' => 2],
                    ['label' => '2026-04-03', 'v' => 1],
                    ['label' => '2026-04-04', 'v' => 4],
                    ['label' => '2026-04-05', 'v' => 3]
                ],
            ],
        ];
    }
}




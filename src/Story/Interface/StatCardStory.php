<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIStatCardComponent;

final class StatCardStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'StatCard'; }
    public function description(): string { return 'Carte KPI dashboard.'; }
    public function componentClass(): string { return UIStatCardComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['title' => 'Revenue', 'value' => '$12,400', 'delta' => '+12% vs last month', 'icon' => 'chart-bar', 'positive' => true];
    }

    public function variants(): array
    {
        return [
            'positive' => [],
            'negative' => ['title' => 'Churn', 'value' => '8.3%', 'delta' => '-1.2pt', 'icon' => 'arrow-trending-down', 'positive' => false, 'color' => 'red'],
            'without icon' => ['icon' => ''],
        ];
    }
}


<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UITimelineComponent;

final class TimelineStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Timeline'; }
    public function description(): string { return 'Chronologie d evenements produit/projet.'; }
    public function componentClass(): string { return UITimelineComponent::class; }

    protected function getBaseArgs(): array
    {
        return [
            'items' => [
                ['time' => '09:00', 'title' => 'Kickoff', 'description' => 'Project launched'],
                ['time' => '11:00', 'title' => 'Review', 'description' => 'Design review complete'],
                ['time' => '15:30', 'title' => 'Deploy', 'description' => 'Version pushed to prod'],
            ],
        ];
    }

    public function variants(): array
    {
        return [
            'default' => [],
            'custom colors' => ['items' => [['time' => '08:00', 'title' => 'Build', 'description' => 'CI passed', 'color' => 'green'], ['time' => '10:00', 'title' => 'Tests', 'description' => 'E2E running', 'color' => 'amber']]],
            'single item' => ['items' => [['time' => 'Now', 'title' => 'Created', 'description' => 'Entity created']]],
        ];
    }
}


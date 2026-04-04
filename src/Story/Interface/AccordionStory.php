<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIAccordionComponent;

final class AccordionStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Accordion';
    }

    public function description(): string
    {
        return 'Composant accordion pour FAQs, sections detaillees et panneaux repliables.';
    }

    public function componentClass(): string
    {
        return UIAccordionComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'items' => [
                ['title' => 'What is Impulse UI?', 'content' => 'A reusable component library for ImpulsePHP apps.'],
                ['title' => 'Can I use stories?', 'content' => 'Yes, all components can be previewed with impulsephp/story.'],
                ['title' => 'Does it support events?', 'content' => 'Yes, interactive components emit events.'],
            ],
            'openItems' => [0],
            'multiple' => false,
            'bordered' => true,
            'flush' => false,
            'color' => 'indigo',
        ];
    }

    public function variants(): array
    {
        return [
            'single open' => [],
            'multiple open' => [
                'multiple' => true,
                'openItems' => [0, 2],
                'color' => 'blue',
            ],
            'flush style' => [
                'flush' => true,
                'bordered' => false,
                'color' => 'slate',
            ],
            'green theme' => [
                'color' => 'green',
                'openItems' => [1],
            ],
            'with disabled item' => [
                'items' => [
                    ['title' => 'General settings', 'content' => 'System-wide configuration.'],
                    ['title' => 'Enterprise settings', 'content' => 'Locked for your plan.', 'disabled' => true],
                    ['title' => 'Billing settings', 'content' => 'Manage invoices and payment methods.'],
                ],
                'openItems' => [0],
                'color' => 'amber',
            ],
        ];
    }
}


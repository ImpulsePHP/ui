<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIStepperComponent;

final class StepperStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'Stepper'; }
    public function description(): string { return 'Etapes de formulaire/process.'; }
    public function componentClass(): string { return UIStepperComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['steps' => ['Account', 'Profile', 'Confirm'], 'currentStep' => 2, 'allowJump' => false];
    }

    public function variants(): array
    {
        return [
            'default' => [],
            'first step' => ['currentStep' => 1],
            'last step' => ['currentStep' => 3],
            'jump enabled' => ['allowJump' => true],
        ];
    }
}


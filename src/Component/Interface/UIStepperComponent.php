<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;
use Impulse\UI\Utility\TailwindColorUtility;

/**
 * @property array $steps
 * @property int $currentStep
 * @property bool $allowJump
 * @property string $color
 */
final class UIStepperComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'steps' => [],
            'currentStep' => 1,
            'allowJump' => false,
        ]);

        $this->state('color', 'indigo', TailwindColorUtility::getAllColors());
    }

    #[Action]
    public function nextStep(): void
    {
        $max = max(1, count((array) $this->steps));
        $this->currentStep = min($max, (int) $this->currentStep + 1);
    }

    #[Action]
    public function previousStep(): void
    {
        $this->currentStep = max(1, (int) $this->currentStep - 1);
    }

    #[Action]
    public function goToStep(int $step): void
    {
        if (!$this->allowJump) {
            return;
        }

        $max = max(1, count((array) $this->steps));
        $this->currentStep = max(1, min($step, $max));
    }

    public function template(): string
    {
        $steps = (array) $this->steps;
        if ($steps === []) {
            return '<div class="ui-stepper text-sm text-slate-500">' . $this->transOrDefault('stepper.no_steps', 'No steps configured.') . '</div>';
        }

        $items = [];
        $stepLabelPrefix = $this->transOrDefault('stepper.step_prefix', 'Step');
        foreach ($steps as $index => $step) {
            $num = $index + 1;
            $label = is_array($step) ? (string) ($step['label'] ?? ($stepLabelPrefix . ' ' . $num)) : (string) $step;
            $active = $num === (int) $this->currentStep;
            $done = $num < (int) $this->currentStep;

            $dotClass = $active ? 'bg-' . $this->color . '-600 text-white' : ($done ? 'bg-' . $this->color . '-100 text-' . $this->color . '-700' : 'bg-slate-100 text-slate-500');
            $action = $this->allowJump ? 'data-action-click="goToStep(' . $num . ')"' : '';

            $items[] = '<button type="button" class="inline-flex items-center gap-2" ' . $action . '><span class="h-6 w-6 rounded-full text-xs flex items-center justify-center ' . $dotClass . '">' . $num . '</span><span class="text-sm text-slate-700">' . $label . '</span></button>';
        }

        $content = implode('<span class="text-slate-300">-</span>', $items);
        $previousLabel = $this->transOrDefault('pagination.previous', 'Previous');
        $nextLabel = $this->transOrDefault('pagination.next', 'Next');

        return <<<HTML
            <div class="ui-stepper space-y-3">
                <div class="flex items-center gap-2 flex-wrap">{$content}</div>
                <div class="flex gap-2">
                    <button type="button" class="px-3 py-2 text-xs border rounded" data-action-click="previousStep()">{$previousLabel}</button>
                    <button type="button" class="px-3 py-2 text-xs border rounded" data-action-click="nextStep()">{$nextLabel}</button>
                </div>
            </div>
        HTML;
    }
}


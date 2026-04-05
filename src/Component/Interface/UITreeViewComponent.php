<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * Simple Tree / Nested list component
 * Props: items (array), selectable, multiple, expandedNodes, selected
 */
final class UITreeViewComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            // default items must be provided as first element of config array to avoid states() treating it as [default, allowedValues]
            'items' => [[], null],
            'selectable' => true,
            'multiple' => false,
            'expandedNodes' => [],
            'selected' => [],
            'id' => uniqid('tree')
        ]);
    }

    #[Action]
    public function toggleNode(string $nodeId): void
    {
        $expanded = (array) $this->expandedNodes;
        if (in_array($nodeId, $expanded, true)) {
            $this->expandedNodes = array_values(array_filter($expanded, static fn($n) => $n !== $nodeId));
        } else {
            $expanded[] = $nodeId;
            $this->expandedNodes = $expanded;
        }
    }

    #[Action]
    public function selectNode(string $nodeId): void
    {
        if (!$this->selectable) {
            return;
        }

        if ($this->multiple) {
            $selected = is_array($this->selected) ? $this->selected : [];
            if (in_array($nodeId, $selected, true)) {
                $this->selected = array_values(array_filter($selected, static fn($s) => $s !== $nodeId));
            } else {
                $selected[] = $nodeId;
                $this->selected = $selected;
            }
        } else {
            $this->selected = $nodeId;
        }

        $this->emit('tree-select', ['selected' => $this->selected]);
    }

    private function renderNodes(array $nodes): string
    {
        $html = [];
        foreach ($nodes as $node) {
            $id = (string) ($node['id'] ?? uniqid('n'));
            $label = htmlspecialchars((string) ($node['label'] ?? $id), ENT_QUOTES | ENT_SUBSTITUTE);
            $children = is_array($node['children'] ?? null) ? $node['children'] : [];
            $isExpanded = in_array($id, (array) $this->expandedNodes, true);
            $hasChildren = $children !== [];

            $expandBtn = '';
            if ($hasChildren) {
                // Use a clear chevron-right when closed and chevron-down when opened
                $iconName = $isExpanded ? 'chevron-down' : 'chevron-right';
                // reserve a fixed width for the expand icon so child labels align with parent labels
                $expandBtn = "<span class=\"inline-flex items-center justify-center w-5 mr-2 text-slate-400\"><button type=\"button\" class=\"inline-flex items-center justify-center\" data-action-click=\"toggleNode('{$id}')\" aria-expanded=\"" . ($isExpanded ? 'true' : 'false') . "\">" . '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="' . ($isExpanded ? 'M19 9l-7 7-7-7' : 'M5 15l7-7 7 7') . '"/></svg>' . "</button></span>";
            }

            $selectedClass = '';
            if ($this->multiple && is_array($this->selected) && in_array($id, $this->selected, true)) {
                $selectedClass = ' bg-slate-100';
            }
            if (!$this->multiple && is_string($this->selected) && $this->selected === $id) {
                $selectedClass = ' bg-slate-100';
            }

            $nodeHtml = "<div class=\"flex items-center py-1 px-2 text-sm{$selectedClass}\">{$expandBtn}<button type=\"button\" class=\"flex-1 text-left truncate\" data-action-click=\"selectNode('{$id}')\">{$label}</button></div>";

            if ($hasChildren) {
                $childrenHtml = $isExpanded ? $this->renderNodes($children) : '';
                // use left margin equal to expand icon width to align labels
                $nodeHtml .= "<div class=\"ml-5\" style=\"display: " . ($isExpanded ? 'block' : 'none') . ";\">{$childrenHtml}</div>";
            }

            $html[] = "<li role=\"treeitem\">{$nodeHtml}</li>";
        }

        return '<ul role="group" class="space-y-0">' . implode('', $html) . '</ul>';
    }

    public function template(): string
    {
        $nodes = is_array($this->items) ? $this->items : [];
        $content = $this->renderNodes($nodes);

        return <<<HTML
            <div class="ui-tree text-sm" id="{$this->id}" role="tree">
                {$content}
            </div>
        HTML;
    }
}






<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UICodeBlockComponent;

final class CodeBlockStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'CodeBlock'; }
    public function description(): string { return 'Bloc de code mis en forme.'; }
    public function componentClass(): string { return UICodeBlockComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['code' => "<?php\nfunction hello() { echo 'Hello world'; }\n?>", 'language' => 'php'];
    }

    public function variants(): array
    {
        return [
            'php' => [],
            'javascript' => ['language' => 'js', 'code' => "function greet() { console.log('hi'); }"],
            'html' => ['language' => 'html', 'code' => "<div>Hello</div>"],
        ];
    }
}



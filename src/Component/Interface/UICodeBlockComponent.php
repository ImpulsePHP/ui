<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class UICodeBlockComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'code' => '',
            'language' => 'php',
            'id' => uniqid('code', true)
        ]);
    }

    public function template(): string
    {
        $codeRaw = (string) $this->code;
        $lang = strtolower((string) $this->language);

        // Escape first, then apply simple server-side replacements to highlight a few tokens.
        $escaped = htmlspecialchars($codeRaw, ENT_QUOTES | ENT_SUBSTITUTE);

        if ($lang === 'php') {
            // highlight php open/close tags and common keywords (operate on escaped content)
            $escaped = preg_replace_callback('/(&lt;\?php|\?&gt;)/', fn($m) => '<span class="text-purple-300">' . $m[1] . '</span>', $escaped);
            $escaped = preg_replace_callback('/\b(function|class|public|protected|private|return|echo|if|else|foreach|for|while|switch|case)\b/', fn($m) => '<span class="text-indigo-300">' . $m[1] . '</span>', $escaped);
        } elseif ($lang === 'js' || $lang === 'javascript') {
            $escaped = preg_replace_callback('/\b(function|const|let|var|return|if|else|for|while|switch|case|class)\b/', fn($m) => '<span class="text-indigo-300">' . $m[1] . '</span>', $escaped);
        }

        // Inline style to ensure monospaced font even if tailwind isn't loaded yet.
        $monoStyle = 'font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, "Roboto Mono", "Courier New", monospace;';

        return <<<HTML
            <div class="ui-codeblock my-2">
                <pre style="{$monoStyle}" class="rounded bg-slate-900 text-slate-100 p-3 overflow-auto font-mono text-sm"><code class="language-{$lang}" data-lang="{$lang}">{$escaped}</code></pre>
            </div>
        HTML;
    }
}





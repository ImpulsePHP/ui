<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Interface;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class UIMediaPlayerComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'src' => '',
            'controls' => true,
            'autoplay' => false,
            'muted' => false,
            'poster' => '',
            'id' => uniqid('media')
        ]);

        $this->state('type', 'video', ['video', 'audio']);
    }

    public function template(): string
    {
        $src = htmlspecialchars((string) $this->src, ENT_QUOTES | ENT_SUBSTITUTE);
        $poster = htmlspecialchars((string) $this->poster, ENT_QUOTES | ENT_SUBSTITUTE);
        $controls = $this->controls ? 'controls' : '';
        $autoplay = $this->autoplay ? 'autoplay' : '';
        $muted = $this->muted ? 'muted' : '';

        if ($this->type === 'audio') {
            return <<<HTML
                <div class="ui-media-player" id="{$this->id}">
                    <audio src="{$src}" {$controls} {$autoplay} {$muted} class="w-full"></audio>
                </div>
            HTML;
        }

        return <<<HTML
            <div class="ui-media-player" id="{$this->id}">
                <video src="{$src}" poster="{$poster}" {$controls} {$autoplay} {$muted} class="w-full rounded bg-black"></video>
            </div>
        HTML;
    }
}


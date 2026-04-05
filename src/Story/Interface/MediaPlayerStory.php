<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIMediaPlayerComponent;

final class MediaPlayerStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string { return 'MediaPlayer'; }
    public function description(): string { return 'Lecteur media (audio / vidéo).'; }
    public function componentClass(): string { return UIMediaPlayerComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['src' => 'https://example.com/video.mp4', 'type' => 'video'];
    }

    public function variants(): array
    {
        return ['video' => [], 'audio' => ['type' => 'audio']];
    }
}


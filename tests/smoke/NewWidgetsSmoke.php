<?php

declare(strict_types=1);

require __DIR__ . '/../../../core/vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

use Impulse\UI\Component\Interface\UITreeViewComponent;
use Impulse\UI\Component\Interface\UIColorPickerComponent;
use Impulse\UI\Component\Interface\UICodeBlockComponent;
use Impulse\UI\Component\Interface\UIHeatmapComponent;
use Impulse\UI\Component\Interface\UIMediaPlayerComponent;

$components = [
    new UITreeViewComponent('smoke-tree', null, ['items' => [
        ['id' => '1', 'label' => 'Root', 'children' => [
            ['id' => '1.1', 'label' => 'Child']
        ]]
    ]]),
    new UIColorPickerComponent('smoke-cp', null, ['value' => '#ff0000']),
    new UICodeBlockComponent('smoke-code', null, ['code' => "<?php echo 'hi'; ?>", 'language' => 'php']),
    new UIHeatmapComponent('smoke-heat', null, ['data' => [['label' => '2026-04-01', 'v' => 2], ['label' => '2026-04-02', 'v' => 4]]]),
    new UIMediaPlayerComponent('smoke-media', null, ['src' => 'https://example.com/video.mp4', 'type' => 'video']),
    // print component removed
];

foreach ($components as $component) {
    $html = $component->template();

    if (!is_string($html) || trim($html) === '') {
        throw new RuntimeException('Empty template for ' . $component::class);
    }
}

echo "New widgets smoke test passed." . PHP_EOL;





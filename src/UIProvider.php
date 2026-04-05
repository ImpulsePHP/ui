<?php

declare(strict_types=1);

namespace Impulse\UI;

use Impulse\Core\Container\ImpulseContainer;
use Impulse\Core\Contracts\HasComponentNamespacesInterface;
use Impulse\Translation\Contract\TranslatorInterface;
use Impulse\UI\Exceptions\UIException;
use Impulse\Core\Provider\AbstractProvider;
use Impulse\Core\Support\Config;
use Impulse\Validator\Contract\ValidatorInterface;

final class UIProvider extends AbstractProvider implements HasComponentNamespacesInterface
{
    /**
     * @throws \JsonException
     * @throws \Exception
     */
    protected function onBoot(ImpulseContainer $container): void
    {
        // Add story path if not already present to avoid duplicates
        $storyPath = 'vendor/impulsephp/ui/src/Story';
        $existingPaths = Config::get('story.paths', []);
        if (!in_array($storyPath, $existingPaths, true)) {
            Config::append('story.paths', [$storyPath]);
        }

        // Add css entry only if an equivalent entry isn't already present
        $cssEntry = [
            'path' => '/../public/css/ui.css',
            'base' => __DIR__,
            'inline' => true,
        ];

        $existingCss = Config::get('css', []);
        $found = false;
        foreach ($existingCss as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            if ((($entry['path'] ?? null) === $cssEntry['path']) && (($entry['base'] ?? null) === $cssEntry['base'])) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            Config::append('css', [$cssEntry]);
        }

        $this->ensureTranslatorIsAvailable($container);
        $this->ensureValidatorIsAvailable($container);
    }

    /**
     * @throws \Exception
     */
    private function ensureTranslatorIsAvailable(ImpulseContainer $container): void
    {
        if (!$container->has(TranslatorInterface::class)) {
            throw new UIException(
                'Translation service is required for UI components. ' .
                'Please ensure TranslatorProvider is registered in your providers configuration.'
            );
        }

        $translator = $container->get(TranslatorInterface::class);
        $this->registerDefaultTranslations($translator);
    }

    /**
     * @throws \JsonException
     */
    private function ensureValidatorIsAvailable(ImpulseContainer $container): void
    {
        if (!$container->has(ValidatorInterface::class)) {
            throw new UIException(
                'Validator service is required for UI components. ' .
                'Please ensure ValidatorProvider is registered in your providers configuration.'
            );
        }
    }

    private function registerDefaultTranslations(TranslatorInterface $translator): void
    {
        $packagePath = __DIR__ . '/../translations';
        if (is_dir($packagePath)) {
            $translator->addNamespace('ui', $packagePath);
        }
    }

    public function getComponentNamespaces(): array
    {
        return [
            'Impulse\\UI\\Component\\',
        ];
    }
}

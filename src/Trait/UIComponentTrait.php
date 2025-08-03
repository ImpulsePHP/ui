<?php

declare(strict_types=1);

namespace Impulse\UI\Trait;

use Impulse\Core\App;
use Impulse\Validator\Contract\ValidatorInterface;
use Impulse\Translation\Contract\TranslatorInterface;

trait UIComponentTrait
{
    protected ?TranslatorInterface $translator = null;
    protected ?ValidatorInterface $validator = null;

    public function shouldExposeStates(): bool
    {
        return true;
    }

    /**
     * @throws \ReflectionException
     */
    protected function validateCurrentField(string $name, mixed $value, ?string $rules): ?string
    {
        if (!$rules || !$name) {
            return null;
        }

        return $this->getValidator()->validateField($name, $value, $rules);
    }

    /**
     * @throws \ReflectionException
     */
    protected function trans(string $key, array $parameters = []): string
    {
        return $this->getTranslator()->trans("ui::ui.{$key}", $parameters);
    }

    /**
     * @throws \ReflectionException
     */
    private function getTranslator(): TranslatorInterface
    {
        return $this->translator ??= App::get(TranslatorInterface::class);
    }

    /**
     * @throws \ReflectionException
     */
    private function getValidator(): ValidatorInterface
    {
        return $this->validator ??= App::get(ValidatorInterface::class);
    }
}


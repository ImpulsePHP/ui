<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UIFileUploadComponent;

final class FileUploadStory extends AbstractStory
{
    protected string $category = 'Form';

    public function name(): string { return 'FileUpload'; }
    public function description(): string { return 'Upload avec liste des fichiers et erreurs.'; }
    public function componentClass(): string { return UIFileUploadComponent::class; }

    protected function getBaseArgs(): array
    {
        return ['label' => 'Attachments', 'accept' => '.pdf,.png,.jpg', 'maxFiles' => 3];
    }

    public function variants(): array
    {
        return [
            'empty' => [],
            'with files' => ['files' => [['name' => 'invoice.pdf', 'size' => '220 KB'], ['name' => 'logo.png', 'size' => '38 KB']]],
            'with error' => ['errorMessage' => 'Maximum file count reached.'],
            'disabled' => ['disabled' => true],
        ];
    }
}


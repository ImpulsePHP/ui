<?php

declare(strict_types=1);

namespace Impulse\UI\Component\Form;

use Impulse\Core\Attributes\Action;
use Impulse\Core\Component\AbstractComponent;
use Impulse\UI\Trait\UIComponentTrait;

/**
 * @property string $label
 * @property array $files
 * @property bool $multiple
 * @property int $maxFiles
 * @property string $accept
 * @property string $errorMessage
 * @property bool $disabled
 */
final class UIFileUploadComponent extends AbstractComponent
{
    use UIComponentTrait;

    public function setup(): void
    {
        $this->states([
            'label' => '',
            'files' => [],
            'multiple' => true,
            'maxFiles' => 5,
            'accept' => '*/*',
            'errorMessage' => '',
            'disabled' => false,
        ]);
    }

    #[Action]
    public function addFile(string $fileName, string $size = '0 KB'): void
    {
        if ($this->disabled) {
            return;
        }

        $files = is_array($this->files) ? $this->files : [];
        if (count($files) >= max(1, (int) $this->maxFiles)) {
            $this->errorMessage = $this->transOrDefault('file_upload.max_files_reached', 'Maximum file count reached.');
            return;
        }

        $files[] = ['name' => $fileName, 'size' => $size];
        $this->files = $files;
        $this->errorMessage = '';

        $this->emit('file-added', ['name' => $fileName, 'size' => $size, 'count' => count($this->files)]);
    }

    #[Action]
    public function removeFile(int $index): void
    {
        $files = is_array($this->files) ? $this->files : [];
        if (!isset($files[$index])) {
            return;
        }

        unset($files[$index]);
        $this->files = array_values($files);
        $this->emit('file-removed', ['index' => $index, 'count' => count($this->files)]);
    }

    public function template(): string
    {
        $label = $this->label ? '<label class="block text-sm font-medium text-slate-700 mb-1">' . $this->label . '</label>' : '';
        $disabled = $this->disabled ? 'opacity-50 pointer-events-none' : '';
        $error = $this->errorMessage !== '' ? '<p class="text-xs text-red-600 mt-1">' . $this->errorMessage . '</p>' : '';
        $removeLabel = $this->transOrDefault('file_upload.remove', 'remove');
        $dropLabel = $this->transOrDefault('file_upload.drop_zone', 'Drag and drop files here or use action addFile().');
        $acceptLabel = $this->transOrDefault('file_upload.accept', 'Accept');
        $maxFilesLabel = $this->transOrDefault('file_upload.max_files', 'Max files');

        $filesHtml = [];
        foreach ((array) $this->files as $index => $file) {
            if (!is_array($file)) {
                continue;
            }

            $name = (string) ($file['name'] ?? 'file');
            $size = (string) ($file['size'] ?? '');
            $filesHtml[] = <<<HTML
                <li class="flex items-center justify-between px-2 py-1 rounded bg-slate-50 border border-slate-200 text-sm">
                    <span class="truncate">{$name} <span class="text-slate-400">{$size}</span></span>
                    <button type="button" class="text-red-600" data-action-click="removeFile({$index})">{$removeLabel}</button>
                </li>
            HTML;
        }

        $list = implode('', $filesHtml);

        return <<<HTML
            <div class="ui-file-upload space-y-2 {$disabled}">
                {$label}
                <div class="rounded-lg border-2 border-dashed border-slate-300 p-4 text-center bg-white">
                    <p class="text-sm text-slate-600">{$dropLabel}</p>
                    <p class="text-xs text-slate-400 mt-1">{$acceptLabel}: {$this->accept} | {$maxFilesLabel}: {$this->maxFiles}</p>
                </div>
                <ul class="space-y-1">{$list}</ul>
                {$error}
            </div>
        HTML;
    }
}


<?php

declare(strict_types=1);

require __DIR__ . '/../../../core/vendor/autoload.php';
require __DIR__ . '/../../../translation/vendor/autoload.php';
require __DIR__ . '/../../../validator/vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

use Impulse\Core\App;
use Impulse\Core\Support\Config;
use Impulse\UI\Component\Form\UIInputComponent;
use Impulse\UI\Component\Form\UISelectComponent;
use Impulse\UI\Component\Form\UITextareaComponent;

/**
 * Mini smoke test manuel pour valider les flux de validation
 * après les correctifs validator lazy-loading.
 */
function assertOk(string $label, bool $condition): void
{
    echo ($condition ? '[OK] ' : '[KO] ') . $label . PHP_EOL;

    if (!$condition) {
        throw new RuntimeException('Assertion failed: ' . $label);
    }
}

$tmpRoot = sys_get_temp_dir() . '/impulse-ui-smoke';
$tmpRuntime = $tmpRoot . '/runtime';

if (!is_dir($tmpRuntime)) {
    mkdir($tmpRuntime, 0777, true);
}

$configPath = $tmpRoot . '/impulse.php';
file_put_contents($configPath, <<<'PHP'
<?php

return [
    'template_engine' => '',
    'template_path' => 'views',
    'middlewares' => [],
    'providers' => [
        Impulse\Translation\TranslatorProvider::class,
        Impulse\Validator\ValidatorProvider::class,
        Impulse\UI\UIProvider::class,
    ],
    'locale' => 'fr',
    'supported' => ['fr', 'en'],
    'cache' => ['enabled' => false, 'ttl' => 0],
    'devtools' => false,
];
PHP);

chdir($tmpRuntime);

Config::reset();
Config::set('providers', [
    \Impulse\Translation\TranslatorProvider::class,
    \Impulse\Validator\ValidatorProvider::class,
    \Impulse\UI\UIProvider::class,
]);

App::boot();

echo "Mini non-regression UI form" . PHP_EOL;

$select = new UISelectComponent('smoke-select', null, [
    'name' => 'team',
    'label' => 'Team',
    'multiple' => true,
    'rules' => 'required',
    'searchable' => false,
    'options' => [
        ['value' => 'alice', 'label' => 'Alice'],
        ['value' => 'bob', 'label' => 'Bob'],
    ],
    'value' => ['alice', 'bob'],
]);

$select->removeBadge('alice');
assertOk('UISelect removeBadge retire une valeur sans fatal', $select->value === ['bob']);
assertOk('UISelect reste valide avec une valeur restante', $select->errorMessage === '');

$select->removeBadge('bob');
assertOk('UISelect required renvoie une erreur une fois vide', $select->errorMessage !== '');

$input = new UIInputComponent('smoke-input', null, [
    'name' => 'email',
    'rules' => 'required',
]);

$input->updateValue('email', '');
assertOk('UIInput remonte une erreur sur valeur vide', $input->errorMessage !== '');

$input->updateValue('email', 'alice@example.com');
assertOk('UIInput efface l erreur avec une valeur valide', $input->errorMessage === '');

$textarea = new UITextareaComponent('smoke-textarea', null, [
    'name' => 'message',
    'rules' => 'required',
]);

$textarea->updateValue('message', '');
assertOk('UITextarea remonte une erreur sur valeur vide', $textarea->errorMessage !== '');

$textarea->updateValue('message', 'message assez long');
assertOk('UITextarea efface l erreur avec une valeur valide', $textarea->errorMessage === '');

echo 'All checks passed.' . PHP_EOL;


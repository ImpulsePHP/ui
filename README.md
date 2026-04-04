# ImpulsePHP UI

`impulsephp/ui` fournit une bibliothèque de composants d’interface prêts à l’emploi pour ImpulsePHP. Le package aide à construire rapidement des interfaces cohérentes en proposant des composants de formulaire, de navigation, de notification et des stories de démonstration intégrées.

## Ce que fait le package

- expose des composants UI réutilisables ;
- s’intègre avec `impulsephp/validator` pour la validation ;
- s’intègre avec `impulsephp/translation` pour les libellés et messages ;
- embarque des stories prêtes à l’emploi pour `impulsephp/story` ;
- charge une feuille de style fournie par le package.

## Prérequis

- PHP 8.2 ou supérieur ;
- `impulsephp/core` ;
- `impulsephp/translation` ;
- `impulsephp/validator`.

## Installation

```bash
composer require impulsephp/ui
```

Le package déclare un provider dans `composer.json`. Si votre application n’utilise pas l’auto-découverte, enregistrez `Impulse\UI\UIProvider` manuellement.

## Dépendances recommandées

Le package s’appuie sur deux services externes au moment du boot :

- `Impulse\Translation\Contract\TranslatorInterface`
- `Impulse\Validator\Contract\ValidatorInterface`

En pratique, il est recommandé de charger les providers suivants avant `UIProvider` :

```php
return [
    'providers' => [
        Impulse\Translation\TranslatorProvider::class,
        Impulse\Validator\ValidatorProvider::class,
        Impulse\UI\UIProvider::class,
    ],
];
```

## Ce que fait le provider

Au démarrage, `UIProvider` :

- enregistre l’espace de noms `Impulse\UI\Component\` ;
- ajoute `vendor/impulsephp/ui/src/Story` aux chemins scannés par `impulsephp/story` ;
- ajoute `public/css/ui.css` à la configuration CSS ;
- enregistre le namespace de traduction `ui` ;
- vérifie la présence du validateur et du traducteur dans le conteneur.

## Composants disponibles

Le package est organisé par familles dans `src/Component/` :

- `Form/`
- `Navigation/`
- `Notification/`
- `Interface/`

On y trouve notamment :

- `UIInputComponent`
- `UIButtonComponent`
- `UISelectComponent`
- `UITextareaComponent`
- `UICheckboxRadioComponent`
- `UIToggleComponent`

## Exemple d’usage complet

Le composant `Impulse\UI\Component\Form\UIInputComponent` gère par exemple le libellé, la valeur, la couleur, la taille et les règles de validation.

```php
use Impulse\UI\Component\Form\UIInputComponent;

$component = UIInputComponent::class;

$args = [
    'label' => 'Adresse email',
    'type' => 'email',
    'name' => 'email',
    'placeholder' => 'vous@example.com',
    'rules' => 'required|email',
    'required' => true,
    'helpText' => 'Nous utiliserons cette adresse pour vous contacter.',
    'color' => 'indigo',
];
```

Lorsqu’une règle est définie, certains composants UI déclenchent automatiquement une validation de champ et exposent le message d’erreur correspondant.

## Explorer les composants avec Story

Le package contient des stories prêtes à l’emploi dans `src/Story/`. Si `impulsephp/story` est installé et activé, les composants UI apparaissent automatiquement dans l’explorateur visuel sans configuration supplémentaire.

## Assets CSS

Le package embarque une feuille de style compilée dans `public/css/ui.css`. Elle est chargée par le provider sous forme de ressource inline afin de simplifier l’intégration.

## Traductions

Les traductions du package sont stockées dans `translations/en` et `translations/fr`, puis chargées sous le namespace `ui`.

```php
$translator->trans('ui::ui.select.search_placeholder');
```

## Aller plus loin

`impulsephp/ui` est particulièrement intéressant en combinaison avec :

- `impulsephp/story` pour documenter les variantes visuelles ;
- `impulsephp/validator` pour les formulaires ;
- `impulsephp/translation` pour les interfaces multilingues.

## Tests

```bash
composer test
```

## Licence

MIT




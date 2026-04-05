# ImpulsePHP UI

`impulsephp/ui` fournit une bibliothèque de composants d’interface réutilisables pour ImpulsePHP, avec des stories de démonstration intégrées et des helpers pour accélérer le prototypage d’interfaces.

Cette README a été mise à jour pour refléter les améliorations récentes : coloration du composant `CodeBlock`, contrôle des couleurs pour `Heatmap`, support d'éléments embarqués dans `Breadcrumb`, comportement amélioré du `Tooltip` et ajustements visuels pour `DataTable` / `TreeView`.

## Fonctionnalités principales

- Composants UI pour formulaires, navigation, notifications et widgets d'interface.
- Stories intégrées (dossier `src/Story`) pour parcourir et tester visuellement les composants.
- Intégration avec `impulsephp/translation` et `impulsephp/validator`.
- Assets CSS fournis dans `public/css/ui.css`.

## Nouveautés récentes

- `UIHeatmapComponent` : possibilité de choisir une couleur principale (Tailwind) ou de fournir une palette hex; les stories proposent désormais un contrôle `color`.
- `UIBreadcrumbComponent` : les items peuvent contenir du `html` brut ou un `{ component, props, slot }` pour insérer, par exemple, un `<select>` dans un segment de breadcrumb.
- `UITooltipComponent` : support d'un soulignement en tirets configurable (`underline`, `underlineColor`) et améliorations pour hover/click/focus.
- `UIDataTableComponent` : chevrons de tri affichés pour la colonne triée et rendu SVG côté serveur pour fiabilité visuelle.
- `UITreeViewComponent` : meilleure alignement des labels enfants sous le label parent.
- Certaines stories ont été enrichies pour faciliter les tests (variants, contrôles de couleur/position etc.).

## Prérequis

- PHP 8.2 ou supérieur
- `impulsephp/core`
- (optionnel) `impulsephp/translation` et `impulsephp/validator` pour fonctionnalités additionnelles

## Installation

```bash
composer require impulsephp/ui
```

Si votre application n’utilise pas l’auto-découverte de composer, enregistrez manuellement le provider `Impulse\\UI\\UIProvider`.

## Provider

Au démarrage, `UIProvider` :

- enregistre l’espace de noms `Impulse\\UI\\Component\\` ;
- ajoute `src/Story` aux chemins scannés par `impulsephp/story` ;
- ajoute `public/css/ui.css` à la configuration CSS ;
- enregistre le namespace de traduction `ui` ;
- vérifie la présence du validateur et du traducteur dans le conteneur.

## Composants et organisation

Les composants sont rangés sous `src/Component/` par famille : `Form/`, `Navigation/`, `Notification/`, `Interface/`.

Exemples notables : `UIInputComponent`, `UIButtonComponent`, `UISelectComponent`, `UIModalComponent`, `UIDataTableComponent`, `UIDrawerComponent`, `UITooltipComponent`, `UIPopoverComponent`, `UIHeatmapComponent`, `UICodeBlockComponent`, `UIBreadcrumbComponent`, `UITreeViewComponent`, `UISidebarComponent`, etc.

Note : le composant `UIPrintComponent` est désactivé / deprecated dans la version courante (template vide). Si vous souhaitez une suppression complète, contactez l'équipe ou supprimez les références aux stories associées.

## Stories et contrôles

Les stories fournissent des arguments de base (`getBaseArgs`) et des `variants()` pour tester les variantes visuelles. Pour faciliter l'ajout de contrôles (dropdowns) dans les stories, la convention suivante est autorisée dans les stories :

- fournir un argument sous la forme `[defaultValue, allowedValuesArray]` pour indiquer au UI explorer qu'il y a un contrôle avec des options. Exemple : `['side' => ['right', ['left','right']]]`.

Le loader de story ne transmettra que la `defaultValue` au composant lors du rendu, évitant d'envoyer le tableau `allowedValues` en tant que valeur d'état côté serveur.

## Exemples d'utilisation

Rendre un composant dans une story :

```php
use Impulse\\UI\\Component\\Interface\\UIDataTableComponent;

$component = UIDataTableComponent::class;
$args = [
    'columns' => [['key' => 'name', 'label' => 'Name']],
    'rows' => [['name' => 'Alice']],
    'sortBy' => 'name',
];
```

## Assets JS (engine)

Le répertoire `js/` contient l'engine JS du package. Pour construire l'artefact :

```bash
cd js
npm install
npm run build
```

Le `package.json` inclut des scripts utiles : `build`, `watch` et `test`.

## Tests

Tests unitaires et smoke tests se trouvent dans `tests/`. Pour exécuter les smoke tests du package UI :

```bash
cd ui
./vendor/bin/phpunit tests/smoke
```

## Traductions

Les fichiers de traduction sont disponibles dans `translations/en` et `translations/fr` et chargés sous le namespace `ui`. Exemple :

```php
$translator->trans('ui::ui.select.search_placeholder');
```

## Contribution et développement

Pour contribuer :

1. Ouvrez une branche dédiée.
2. Ajoutez des tests pour les comportements modifiés.
3. Vérifiez les styles Tailwind si vous ajoutez des classes dynamiques (pré-déclarez les classes utilisées pour éviter leur purge).

## Licence

MIT


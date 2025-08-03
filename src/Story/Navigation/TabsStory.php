<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Navigation;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Navigation\UITabsComponent;

final class TabsStory extends AbstractStory
{
    protected string $category = 'Navigation';

    public function name(): string
    {
        return 'Tabs';
    }

    public function description(): string
    {
        return 'Composant onglets avec support de différents variants et orientations';
    }

    public function componentClass(): string
    {
        return UITabsComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'tabs' => [
                ['label' => 'Accueil', 'content' => '<p>Contenu de l\'accueil</p>'],
                ['label' => 'Profil', 'content' => '<p>Contenu du profil</p>'],
                ['label' => 'Paramètres', 'content' => '<p>Contenu des paramètres</p>'],
            ],
            'active' => 0,
            'color' => 'indigo',
            'variant' => 'underline',
            'size' => 'normal',
            'orientation' => 'horizontal',
            'fullWidth' => false,
            'pill' => false,
            'showContent' => true,
        ];
    }

    public function variants(): array
    {
        return [
            'underline basic' => [
                'variant' => 'underline',
                'tabs' => [
                    ['label' => 'Dashboard', 'content' => '<div class="p-4"><h3 class="font-semibold">Dashboard</h3><p>Vue d\'ensemble de votre activité</p></div>'],
                    ['label' => 'Analytics', 'content' => '<div class="p-4"><h3 class="font-semibold">Analytics</h3><p>Statistiques détaillées</p></div>'],
                    ['label' => 'Reports', 'content' => '<div class="p-4"><h3 class="font-semibold">Reports</h3><p>Rapports et données</p></div>'],
                ],
            ],
            'pills variant' => [
                'variant' => 'pills',
                'color' => 'blue',
                'tabs' => [
                    ['label' => 'Général', 'content' => '<div class="p-4">Configuration générale</div>'],
                    ['label' => 'Sécurité', 'content' => '<div class="p-4">Paramètres de sécurité</div>'],
                    ['label' => 'Notifications', 'content' => '<div class="p-4">Préférences de notification</div>'],
                ],
            ],
            'bordered variant' => [
                'variant' => 'bordered',
                'color' => 'green',
                'tabs' => [
                    ['label' => 'Produits', 'content' => '<div class="p-4">Liste des produits</div>'],
                    ['label' => 'Catégories', 'content' => '<div class="p-4">Gestion des catégories</div>'],
                    ['label' => 'Stock', 'content' => '<div class="p-4">État du stock</div>'],
                ],
            ],
            'with icons' => [
                'variant' => 'underline',
                'color' => 'indigo',
                'tabs' => [
                    ['label' => 'Accueil', 'icon' => 'home', 'content' => '<div class="p-4">Page d\'accueil</div>'],
                    ['label' => 'Utilisateurs', 'icon' => 'users', 'content' => '<div class="p-4">Gestion des utilisateurs</div>'],
                    ['label' => 'Paramètres', 'icon' => 'cog-6-tooth', 'content' => '<div class="p-4">Configuration</div>'],
                ],
            ],
            'full width' => [
                'variant' => 'pills',
                'fullWidth' => true,
                'color' => 'emerald',
                'tabs' => [
                    ['label' => 'Tous', 'content' => '<div class="p-4">Tous les éléments</div>'],
                    ['label' => 'Actifs', 'content' => '<div class="p-4">Éléments actifs</div>'],
                    ['label' => 'Archivés', 'content' => '<div class="p-4">Éléments archivés</div>'],
                ],
            ],
            'large size' => [
                'variant' => 'underline',
                'size' => 'large',
                'color' => 'red',
                'tabs' => [
                    ['label' => 'Commandes', 'content' => '<div class="p-6 text-lg">Gestion des commandes</div>'],
                    ['label' => 'Clients', 'content' => '<div class="p-6 text-lg">Base clients</div>'],
                    ['label' => 'Facturation', 'content' => '<div class="p-6 text-lg">Facturation et paiements</div>'],
                ],
            ],
            'small size' => [
                'variant' => 'pills',
                'size' => 'small',
                'color' => 'slate',
                'tabs' => [
                    ['label' => 'HTML', 'content' => '<div class="p-2 text-sm">Code HTML</div>'],
                    ['label' => 'CSS', 'content' => '<div class="p-2 text-sm">Styles CSS</div>'],
                    ['label' => 'JS', 'content' => '<div class="p-2 text-sm">JavaScript</div>'],
                ],
            ],
            'vertical orientation' => [
                'variant' => 'underline',
                'orientation' => 'vertical',
                'color' => 'cyan',
                'tabs' => [
                    ['label' => 'Navigation', 'content' => '<div class="p-4"><h3 class="font-semibold">Navigation</h3><p>Configuration de la navigation</p></div>'],
                    ['label' => 'Apparence', 'content' => '<div class="p-4"><h3 class="font-semibold">Apparence</h3><p>Thèmes et couleurs</p></div>'],
                    ['label' => 'Fonctionnalités', 'content' => '<div class="p-4"><h3 class="font-semibold">Fonctionnalités</h3><p>Modules disponibles</p></div>'],
                ],
            ],
            'with disabled tab' => [
                'variant' => 'pills',
                'color' => 'orange',
                'tabs' => [
                    ['label' => 'Disponible', 'content' => '<div class="p-4">Contenu disponible</div>'],
                    ['label' => 'Bientôt', 'content' => '<div class="p-4">Bientôt disponible</div>', 'disabled' => true],
                    ['label' => 'Beta', 'content' => '<div class="p-4">Version beta</div>'],
                ],
            ],
            'pills rounded' => [
                'variant' => 'pills',
                'pill' => true,
                'color' => 'pink',
                'tabs' => [
                    ['label' => 'Messages', 'content' => '<div class="p-4">Boîte de réception</div>'],
                    ['label' => 'Envoyés', 'content' => '<div class="p-4">Messages envoyés</div>'],
                    ['label' => 'Brouillons', 'content' => '<div class="p-4">Brouillons sauvegardés</div>'],
                ],
            ],
        ];
    }
}

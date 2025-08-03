<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UICardComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class CardStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Card';
    }

    public function description(): string
    {
        return 'Composant Card flexible pour afficher du contenu structuré avec images, badges, actions, icônes et utilisateur';
    }

    public function componentClass(): string
    {
        return UICardComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'imageSrc' => '',
            'imageAlt' => '',
            'imagePosition' => 'top',
            'size' => 'normal',
            'variant' => 'shadow',
            'shadow' => true,
            'border' => false,
            'rounded' => true,
            'hoverable' => false,
            'clickable' => false,
            'href' => '',
            'padding' => 'normal',
            'spacing' => 'normal',
            'withDivider' => false,
            'badges' => [],
            'actions' => [],
            'icons' => [],
            'user' => [],
        ];
    }

    public function variants(): array
    {
        return [
            'simple card' => [
                'title' => 'Titre de la carte',
                'description' => 'Voici une description simple de cette carte avec du contenu informatif.',
                'variant' => 'shadow',
            ],
            'with subtitle' => [
                'title' => 'Article de blog',
                'subtitle' => 'Publié le 15 janvier 2024',
                'description' => 'Un guide complet sur l\'utilisation des composants UI modernes dans vos applications web.',
                'variant' => 'shadow',
            ],
            'with badges' => [
                'title' => 'Nouveau produit',
                'subtitle' => 'Innovation technologique',
                'description' => 'Découvrez notre dernière création qui révolutionne l\'industrie.',
                'badges' => [
                    ['label' => 'Nouveau', 'color' => 'green', 'variant' => 'filled'],
                    ['label' => 'Populaire', 'color' => 'blue', 'variant' => 'soft']
                ],
            ],
            'with single action' => [
                'title' => 'Article intéressant',
                'description' => 'Un contenu passionnant qui mérite d\'être lu en détail.',
                'actions' => [
                    ['label' => 'Lire la suite', 'color' => 'indigo', 'variant' => 'filled', 'href' => '/article']
                ],
            ],
            'with multiple actions' => [
                'title' => 'Gestion des utilisateurs',
                'description' => 'Administrez les comptes utilisateurs de votre application.',
                'actions' => [
                    ['label' => 'Éditer', 'color' => 'blue', 'variant' => 'outline', 'route' => 'edit-user'],
                    ['label' => 'Supprimer', 'color' => 'red', 'variant' => 'outline', 'route' => 'delete-user']
                ],
            ],
            'with icons' => [
                'title' => 'Publication populaire',
                'description' => 'Cette publication a reçu de nombreuses interactions de la communauté.',
                'icons' => [
                    ['iconName' => 'heart', 'color' => 'red-500', 'value' => '24'],
                    ['iconName' => 'eye', 'color' => 'gray-500', 'value' => '1.2k'],
                    ['iconName' => 'chatBubbleLeft', 'color' => 'blue-500', 'value' => '8']
                ],
            ],
            'with clickable icons' => [
                'title' => 'Statistiques interactives',
                'description' => 'Cliquez sur les icônes pour voir les détails.',
                'icons' => [
                    ['iconName' => 'heart', 'color' => 'red-500', 'value' => '156', 'href' => '/likes'],
                    ['iconName' => 'share', 'color' => 'green-500', 'value' => '42', 'route' => 'share-content']
                ],
            ],
            'with user info' => [
                'title' => 'Profil développeur',
                'description' => 'Spécialisé dans le développement d\'applications web modernes.',
                'user' => [
                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face',
                    'text' => 'Jean Dupont'
                ],
            ],
            'with user initials' => [
                'title' => 'Rapport mensuel',
                'description' => 'Analyse des performances du mois dernier.',
                'user' => [
                    'text' => 'Marie Martin'
                ],
            ],
            'complete card' => [
                'title' => 'Projet collaboratif',
                'subtitle' => 'Équipe de développement',
                'description' => 'Un projet innovant développé par une équipe talentueuse avec de nombreuses fonctionnalités.',
                'badges' => [
                    ['label' => 'En cours', 'color' => 'yellow', 'variant' => 'filled'],
                    ['label' => 'Priorité haute', 'color' => 'red', 'variant' => 'soft']
                ],
                'icons' => [
                    ['iconName' => 'star', 'color' => 'yellow-500', 'value' => '4.8'],
                    ['iconName' => 'users', 'color' => 'blue-500', 'value' => '12']
                ],
                'actions' => [
                    ['label' => 'Voir détails', 'color' => 'indigo', 'variant' => 'filled'],
                    ['label' => 'Collaborer', 'color' => 'green', 'variant' => 'outline']
                ],
                'user' => [
                    'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b5bc?w=100&h=100&fit=crop&crop=face',
                    'text' => 'Sarah Chen'
                ],
            ],
            'minimal card' => [
                'title' => 'Carte minimaliste',
                'variant' => 'flat',
                'shadow' => false,
                'padding' => 'small',
            ],
            'image top' => [
                'title' => 'Paysage montagneux',
                'description' => 'Une vue magnifique sur les Alpes françaises au coucher du soleil.',
                'imageSrc' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=200&fit=crop',
                'imageAlt' => 'Paysage de montagne',
                'imagePosition' => 'top',
            ],
            'image left' => [
                'title' => 'Profil utilisateur',
                'subtitle' => 'Développeur Senior',
                'description' => 'Spécialisé dans le développement d\'applications web modernes avec React et PHP.',
                'imageSrc' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
                'imageAlt' => 'Photo de profil',
                'imagePosition' => 'left',
            ],
            'image right' => [
                'title' => 'Nouveau produit',
                'subtitle' => 'Disponible maintenant',
                'description' => 'Découvrez notre dernière innovation technologique qui révolutionne l\'industrie.',
                'imageSrc' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=150&h=150&fit=crop',
                'imageAlt' => 'Image produit',
                'imagePosition' => 'right',
            ],
            'image with actions' => [
                'title' => 'Article technique',
                'subtitle' => 'Guide avancé',
                'description' => 'Un guide détaillé sur les meilleures pratiques de développement.',
                'imageSrc' => 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=400&h=200&fit=crop',
                'imageAlt' => 'Code sur écran',
                'imagePosition' => 'top',
                'actions' => [
                    ['label' => 'Lire', 'color' => 'indigo', 'variant' => 'filled'],
                    ['label' => 'Sauvegarder', 'color' => 'gray', 'variant' => 'outline']
                ],
            ],
            'small card' => [
                'title' => 'Carte petite',
                'description' => 'Contenu compact pour les espaces restreints.',
                'size' => 'small',
                'padding' => 'small',
                'spacing' => 'small',
            ],
            'normal card' => [
                'title' => 'Carte normale',
                'description' => 'Taille standard pour la plupart des cas d\'usage avec un équilibre parfait.',
                'size' => 'normal',
            ],
            'large card' => [
                'title' => 'Grande carte',
                'subtitle' => 'Plus d\'espace pour le contenu',
                'description' => 'Parfaite pour les contenus détaillés nécessitant plus d\'espace d\'affichage et une meilleure lisibilité.',
                'size' => 'large',
                'padding' => 'large',
                'spacing' => 'large',
            ],
            'filled variant' => [
                'title' => 'Carte standard',
                'description' => 'Style simple avec fond blanc.',
                'variant' => 'filled',
            ],
            'outline variant' => [
                'title' => 'Carte avec contour',
                'description' => 'Style minimaliste avec bordure.',
                'variant' => 'outline',
                'border' => true,
            ],
            'shadow variant' => [
                'title' => 'Carte avec ombre',
                'description' => 'L\'ombre apporte de la profondeur.',
                'variant' => 'shadow',
            ],
            'flat variant' => [
                'title' => 'Carte plate',
                'description' => 'Style complètement plat sans relief.',
                'variant' => 'flat',
                'shadow' => false,
            ],
            'hoverable card' => [
                'title' => 'Carte interactive',
                'description' => 'Survolez cette carte pour voir l\'effet d\'animation.',
                'hoverable' => true,
            ],
            'clickable card' => [
                'title' => 'Carte cliquable',
                'description' => 'Cette carte est entièrement cliquable et redirige vers une autre page.',
                'clickable' => true,
                'href' => '/exemple',
                'hoverable' => true,
            ],
            'clickable with image' => [
                'title' => 'Article complet',
                'subtitle' => 'Cliquez pour lire',
                'description' => 'Un article passionnant qui mérite d\'être lu en entier.',
                'imageSrc' => 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?w=400&h=200&fit=crop',
                'imageAlt' => 'Article',
                'imagePosition' => 'top',
                'clickable' => true,
                'href' => '/article',
                'hoverable' => true,
            ],
            'with divider' => [
                'title' => 'Carte avec séparateur',
                'subtitle' => 'Organisation visuelle',
                'description' => 'Le séparateur aide à organiser visuellement les différentes sections.',
                'withDivider' => true,
                'actions' => [
                    ['label' => 'Action', 'color' => 'indigo', 'variant' => 'outline']
                ],
            ],
            'social card' => [
                'title' => 'Publication sociale',
                'description' => 'Une publication qui génère beaucoup d\'engagement sur les réseaux sociaux.',
                'badges' => [
                    ['label' => 'Viral', 'color' => 'purple', 'variant' => 'filled']
                ],
                'icons' => [
                    ['iconName' => 'heart', 'color' => 'red-500', 'value' => '2.4k', 'href' => '/likes'],
                    ['iconName' => 'chatBubbleLeft', 'color' => 'blue-500', 'value' => '89'],
                    ['iconName' => 'share', 'color' => 'green-500', 'value' => '156']
                ],
                'user' => [
                    'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b5bc?w=100&h=100&fit=crop&crop=face',
                    'text' => 'Influenceur Digital'
                ],
            ],
            'product card' => [
                'title' => 'Smartphone Premium',
                'subtitle' => '999€',
                'description' => 'Le dernier smartphone avec des fonctionnalités révolutionnaires et un design élégant.',
                'imageSrc' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=200&fit=crop',
                'imageAlt' => 'Smartphone',
                'badges' => [
                    ['label' => 'Nouveau', 'color' => 'green', 'variant' => 'filled'],
                    ['label' => 'Livraison gratuite', 'color' => 'blue', 'variant' => 'soft']
                ],
                'icons' => [
                    ['iconName' => 'star', 'color' => 'yellow-500', 'value' => '4.9'],
                    ['iconName' => 'users', 'color' => 'gray-500', 'value' => '2.1k avis']
                ],
                'actions' => [
                    ['label' => 'Acheter', 'color' => 'indigo', 'variant' => 'filled'],
                    ['label' => 'Comparer', 'color' => 'gray', 'variant' => 'outline']
                ],
            ],
            'team member card' => [
                'title' => 'Équipe de développement',
                'subtitle' => 'Équipe Backend',
                'description' => 'Notre équipe experte travaille sur l\'architecture et les performances de l\'application.',
                'icons' => [
                    ['iconName' => 'users', 'color' => 'blue-500', 'value' => '8 membres'],
                    ['iconName' => 'codebracket', 'color' => 'green-500', 'value' => '12 projets']
                ],
                'actions' => [
                    ['label' => 'Contacter', 'color' => 'indigo', 'variant' => 'filled'],
                    ['label' => 'Voir projets', 'color' => 'gray', 'variant' => 'outline']
                ],
                'user' => [
                    'text' => 'Lead Developer'
                ],
            ],
        ];
    }

    public function controls(): array
    {
        return [
            'title' => [
                'type' => 'text',
                'label' => 'Titre',
                'default' => '',
            ],
            'subtitle' => [
                'type' => 'text',
                'label' => 'Sous-titre',
                'default' => '',
            ],
            'description' => [
                'type' => 'textarea',
                'label' => 'Description',
                'default' => '',
            ],
            'imageSrc' => [
                'type' => 'text',
                'label' => 'URL de l\'image',
                'default' => '',
            ],
            'imageAlt' => [
                'type' => 'text',
                'label' => 'Texte alternatif de l\'image',
                'default' => '',
            ],
            'imagePosition' => [
                'type' => 'select',
                'label' => 'Position de l\'image',
                'default' => 'top',
                'options' => [
                    'top' => 'Haut',
                    'left' => 'Gauche',
                    'right' => 'Droite',
                ],
            ],
            'size' => [
                'type' => 'select',
                'label' => 'Taille',
                'default' => 'normal',
                'options' => [
                    'small' => 'Petite',
                    'normal' => 'Normale',
                    'large' => 'Grande',
                ],
            ],
            'variant' => [
                'type' => 'select',
                'label' => 'Variante',
                'default' => 'shadow',
                'options' => [
                    'filled' => 'Remplie',
                    'outline' => 'Contour',
                    'shadow' => 'Ombre',
                    'flat' => 'Plate',
                ],
            ],
            'padding' => [
                'type' => 'select',
                'label' => 'Espacement interne',
                'default' => 'normal',
                'options' => [
                    'none' => 'Aucun',
                    'small' => 'Petit',
                    'normal' => 'Normal',
                    'large' => 'Grand',
                ],
            ],
            'spacing' => [
                'type' => 'select',
                'label' => 'Espacement entre éléments',
                'default' => 'normal',
                'options' => [
                    'none' => 'Aucun',
                    'small' => 'Petit',
                    'normal' => 'Normal',
                    'large' => 'Grand',
                ],
            ],
            'shadow' => [
                'type' => 'boolean',
                'label' => 'Ombre',
                'default' => true,
            ],
            'border' => [
                'type' => 'boolean',
                'label' => 'Bordure',
                'default' => false,
            ],
            'rounded' => [
                'type' => 'boolean',
                'label' => 'Coins arrondis',
                'default' => true,
            ],
            'hoverable' => [
                'type' => 'boolean',
                'label' => 'Effet au survol',
                'default' => false,
            ],
            'clickable' => [
                'type' => 'boolean',
                'label' => 'Cliquable',
                'default' => false,
            ],
            'href' => [
                'type' => 'text',
                'label' => 'Lien (href)',
                'default' => '',
            ],
            'withDivider' => [
                'type' => 'boolean',
                'label' => 'Avec séparateur',
                'default' => false,
            ],
        ];
    }
}

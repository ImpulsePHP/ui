<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIBadgeComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class BadgeStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Badge';
    }

    public function description(): string
    {
        return 'Composant Badge pour afficher des étiquettes, statuts et compteurs avec différents styles';
    }

    public function componentClass(): string
    {
        return UIBadgeComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => 'Badge',
            'color' => 'slate',
            'variant' => 'filled',
            'shape' => 'rounded',
            'dot' => false,
            'dotColor' => '',
            'pulse' => false,
            'withClose' => false,
            'dismissible' => false,
        ];
    }

    public function variants(): array
    {
        return [
            // === TEST DES BOUTONS DE FERMETURE ===
            'removable badge' => [
                'label' => 'Tag supprimable',
                'withClose' => true,
                'dismissible' => false,
                'color' => 'blue',
            ],

            'dismissible badge' => [
                'label' => 'Badge avec événement',
                'withClose' => false,
                'dismissible' => true,
                'color' => 'green',
            ],

            'both close options' => [
                'label' => 'Double option',
                'withClose' => true,
                'dismissible' => true,
                'color' => 'purple',
            ],

            // === BASIQUES ===
            'simple badge' => [
                'label' => 'Nouveau',
                'color' => 'blue',
            ],

            'with number' => [
                'label' => '42',
                'color' => 'red',
                'shape' => 'pill',
            ],

            'status badge' => [
                'label' => 'Actif',
                'color' => 'green',
                'dot' => true,
            ],

            // === VARIANTS ===
            'filled variant' => [
                'label' => 'Rempli',
                'variant' => 'filled',
                'color' => 'blue',
            ],

            'outline variant' => [
                'label' => 'Contour',
                'variant' => 'outline',
                'color' => 'green',
            ],

            'soft variant' => [
                'label' => 'Doux',
                'variant' => 'soft',
                'color' => 'purple',
            ],

            'solid variant' => [
                'label' => 'Solide',
                'variant' => 'solid',
                'color' => 'red',
            ],

            // === FORMES ===
            'rounded shape' => [
                'label' => 'Arrondi',
                'shape' => 'rounded',
                'color' => 'blue',
            ],

            'pill shape' => [
                'label' => 'Pilule',
                'shape' => 'pill',
                'color' => 'green',
            ],

            'square shape' => [
                'label' => 'Carré',
                'shape' => 'square',
                'color' => 'red',
            ],

            // === AVEC DOT ===
            'with dot' => [
                'label' => 'En ligne',
                'dot' => true,
                'color' => 'green',
            ],

            'dot different color' => [
                'label' => 'Occupé',
                'dot' => true,
                'dotColor' => 'yellow',
                'color' => 'slate',
            ],

            'pulsing dot' => [
                'label' => 'Live',
                'dot' => true,
                'pulse' => true,
                'color' => 'red',
            ],

            // === CAS D'USAGE ===
            'notification count' => [
                'label' => '99+',
                'color' => 'red',
                'variant' => 'solid',
                'shape' => 'pill',
            ],

            'beta tag' => [
                'label' => 'BETA',
                'color' => 'purple',
                'variant' => 'solid',
                'shape' => 'rounded',
            ],

            'category tag' => [
                'label' => 'Développement',
                'color' => 'slate',
                'variant' => 'filled',
                'withClose' => true,
            ],

            'file type' => [
                'label' => 'PDF',
                'color' => 'red',
                'variant' => 'outline',
                'shape' => 'square',
            ],

            'language tag' => [
                'label' => 'Français',
                'color' => 'blue',
                'variant' => 'filled',
                'withClose' => true,
                'shape' => 'pill',
            ],

            // === STATUTS ===
            'success status' => [
                'label' => 'Succès',
                'color' => 'green',
                'dot' => true,
                'variant' => 'soft',
            ],

            'warning status' => [
                'label' => 'Attention',
                'color' => 'amber',
                'dot' => true,
                'variant' => 'soft',
            ],

            'error status' => [
                'label' => 'Erreur',
                'color' => 'red',
                'dot' => true,
                'variant' => 'soft',
            ],

            'info status' => [
                'label' => 'Information',
                'color' => 'blue',
                'dot' => true,
                'variant' => 'soft',
            ],

            // === COLLECTIONS ===
            'team member' => [
                'label' => 'Équipe Design',
                'color' => 'pink',
                'variant' => 'filled',
                'dot' => true,
                'dotColor' => 'green',
            ],

            'version tag' => [
                'label' => 'v2.1.0',
                'color' => 'emerald',
                'variant' => 'outline',
                'shape' => 'rounded',
            ],
        ];
    }
}

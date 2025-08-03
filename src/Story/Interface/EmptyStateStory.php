<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIEmptyStateComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class EmptyStateStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Empty States';
    }

    public function description(): string
    {
        return 'Composant pour afficher des états vides avec icônes, illustrations et actions';
    }

    public function componentClass(): string
    {
        return UIEmptyStateComponent::class;
    }

    /**
     * @throws \ReflectionException
     */
    protected function getBaseArgs(): array
    {
        return [
            'title' => $this->trans('empty_state.no_items'),
            'description' => $this->trans('empty_state.description'),
            'iconName' => '',
            'size' => 'normal',
            'color' => 'indigo',
            'variant' => 'default',
            'showBorder' => false,
            'primaryAction' => [],
            'secondaryAction' => [],
        ];
    }

    public function variants(): array
    {
        return [
            // === BASIQUES ===
            'simple empty state' => [
                'title' => 'Aucun résultat',
                'description' => 'Votre recherche n\'a donné aucun résultat.',
                'iconName' => 'inbox',
                'color' => 'gray',
            ],

            'with primary action' => [
                'title' => 'Aucun fichier',
                'description' => 'Vous n\'avez encore téléchargé aucun fichier.',
                'iconName' => 'document',
                'color' => 'blue',
                'primaryAction' => [
                    'label' => 'Télécharger un fichier',
                    'action' => 'upload-file'
                ],
            ],

            'with both actions' => [
                'title' => 'Aucun projet',
                'description' => 'Commencez par créer votre premier projet ou importez-en un existant.',
                'iconName' => 'folder',
                'color' => 'indigo',
                'primaryAction' => [
                    'label' => 'Nouveau projet',
                    'action' => 'create-project'
                ],
                'secondaryAction' => [
                    'label' => 'Importer',
                    'action' => 'import-project'
                ],
            ],

            // === VARIANTS ===
            'card variant' => [
                'title' => 'Panier vide',
                'description' => 'Votre panier d\'achats est actuellement vide.',
                'iconName' => 'shopping-cart',
                'variant' => 'card',
                'color' => 'green',
                'primaryAction' => [
                    'label' => 'Continuer les achats',
                    'action' => 'continue-shopping'
                ],
            ],
            'minimal variant' => [
                'title' => 'Aucune notification',
                'description' => 'Vous êtes à jour !',
                'iconeName' => '',
                'size' => 'small',
            ],

            // === AVEC BORDURE ===
            'dashed border' => [
                'title' => 'Zone de dépôt',
                'description' => 'Glissez et déposez vos fichiers ici ou cliquez pour sélectionner.',
                'iconName' => 'document',
                'showBorder' => true,
                'color' => 'blue',
                'variant' => 'default',
                'primaryAction' => [
                    'label' => 'Sélectionner des fichiers',
                    'action' => 'select-files'
                ],
            ],

            // === TAILLES ===
            'small size' => [
                'title' => 'Liste vide',
                'description' => 'Aucun élément dans cette liste.',
                'iconName' => 'inbox',
                'size' => 'small',
                'color' => 'gray',
            ],

            'large size' => [
                'title' => 'Bienvenue !',
                'description' => 'Vous êtes maintenant connecté. Explorez les fonctionnalités disponibles.',
                'iconName' => 'heart',
                'size' => 'large',
                'color' => 'pink',
                'primaryAction' => [
                    'label' => 'Commencer la visite',
                    'action' => 'start-tour'
                ],
            ],

            // === TYPES D'ICÔNES ===
            'no icon' => [
                'title' => 'Contenu indisponible',
                'description' => 'Le contenu demandé n\'est pas disponible actuellement.',
                'iconType' => 'none',
                'color' => 'slate',
                'primaryAction' => [
                    'label' => 'Réessayer',
                    'action' => 'retry'
                ],
            ],

            // === CONTEXTES SPÉCIFIQUES ===
            'users empty' => [
                'title' => 'Aucun utilisateur',
                'description' => 'Invitez des membres à rejoindre votre équipe.',
                'iconName' => 'users',
                'color' => 'purple',
                'primaryAction' => [
                    'label' => 'Inviter des utilisateurs',
                    'action' => 'invite-users'
                ],
                'secondaryAction' => [
                    'label' => 'Voir les invitations',
                    'action' => 'view-invitations'
                ],
            ],

            'photos empty' => [
                'title' => 'Aucune photo',
                'description' => 'Ajoutez vos premières photos à votre galerie.',
                'iconName' => 'photo',
                'color' => 'sky',
                'variant' => 'card',
                'primaryAction' => [
                    'label' => 'Ajouter des photos',
                    'action' => 'add-photos'
                ],
            ],

            'mail empty' => [
                'title' => 'Boîte de réception vide',
                'description' => 'Tous vos messages ont été traités. Excellent travail !',
                'iconName' => 'envelope',
                'color' => 'green',
                'size' => 'small',
            ],

            'favorites empty' => [
                'title' => 'Aucun favori',
                'description' => 'Marquez des éléments comme favoris pour les retrouver facilement.',
                'iconName' => 'heart',
                'color' => 'rose',
                'primaryAction' => [
                    'label' => 'Explorer le contenu',
                    'action' => 'explore-content'
                ],
            ],

            // === ERREURS ===
            'error state' => [
                'title' => 'Erreur de chargement',
                'description' => 'Impossible de charger le contenu. Vérifiez votre connexion.',
                'iconName' => 'arrow-path',
                'color' => 'red',
                'variant' => 'card',
                'primaryAction' => [
                    'label' => 'Réessayer',
                    'action' => 'retry-loading'
                ],
                'secondaryAction' => [
                    'label' => 'Signaler le problème',
                    'action' => 'report-issue'
                ],
            ],
        ];
    }
}

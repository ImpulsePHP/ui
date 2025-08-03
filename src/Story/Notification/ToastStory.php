<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Notification;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Notification\UIToastComponent;

final class ToastStory extends AbstractStory
{
    protected string $category = 'Notification';

    public function name(): string
    {
        return 'Toast';
    }

    public function description(): string
    {
        return 'Composant de notification toast avec auto-dismiss, actions personnalisées et positionnement flexible';
    }

    public function componentClass(): string
    {
        return UIToastComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'title' => '',
            'message' => '',
            'color' => 'indigo',
            'position' => 'top-right',
            'duration' => 5000,
            'dismissible' => true,
            'visible' => true,
            'autoHide' => true,
            'actionText' => '',
            'actionUrl' => '',
            'iconName' => '',
            'showIcon' => true,
            'showProgress' => true,
            'remainingTime' => 5000,
        ];
    }

    public function variants(): array
    {
        return [
            'success simple' => [
                'color' => 'green',
                'message' => 'Votre profil a été mis à jour avec succès !',
                'visible' => true,
            ],

            'success with title' => [
                'color' => 'green',
                'title' => 'Opération réussie',
                'message' => 'Vos modifications ont été enregistrées.',
                'visible' => true,
            ],

            'error notification' => [
                'color' => 'red',
                'title' => 'Erreur de validation',
                'message' => 'Veuillez corriger les erreurs dans le formulaire.',
                'visible' => true,
            ],

            'warning alert' => [
                'color' => 'yellow',
                'title' => 'Attention',
                'message' => 'Cette action ne peut pas être annulée.',
                'visible' => true,
            ],

            'info with action' => [
                'color' => 'blue',
                'title' => 'Nouveau message',
                'message' => 'Vous avez reçu 3 nouveaux messages.',
                'actionText' => 'Voir les messages',
                'actionUrl' => '/messages',
                'visible' => true,
            ],

            'custom icon' => [
                'color' => 'green',
                'title' => 'Téléchargement terminé',
                'message' => 'Le fichier a été téléchargé avec succès.',
                'iconName' => 'cloud-arrow-down',
                'visible' => true,
            ],

            'no icon' => [
                'color' => 'blue',
                'message' => 'Toast sans icône pour un style plus épuré.',
                'showIcon' => false,
                'visible' => true,
            ],

            'no progress bar' => [
                'color' => 'yellow',
                'title' => 'Maintenance programmée',
                'message' => 'Le système sera indisponible de 2h à 4h.',
                'showProgress' => false,
                'visible' => true,
            ],

            'not dismissible' => [
                'color' => 'red',
                'title' => 'Erreur critique',
                'message' => 'Une erreur système nécessite votre attention.',
                'dismissible' => false,
                'autoHide' => false,
                'visible' => true,
            ],

            'no auto hide' => [
                'color' => 'blue',
                'title' => 'Information importante',
                'message' => 'Ce message reste affiché jusqu\'à ce que vous le fermiez.',
                'autoHide' => false,
                'visible' => true,
            ],

            'long duration' => [
                'color' => 'green',
                'message' => 'Ce toast reste visible pendant 10 secondes.',
                'duration' => 10000,
                'remainingTime' => 10000,
                'visible' => true,
            ],

            'short duration' => [
                'color' => 'yellow',
                'message' => 'Toast rapide (2 secondes).',
                'duration' => 2000,
                'remainingTime' => 2000,
                'visible' => true,
            ],

            // Différentes positions
            'top left' => [
                'color' => 'blue',
                'message' => 'Toast positionné en haut à gauche.',
                'position' => 'top-left',
                'visible' => true,
            ],

            'top center' => [
                'color' => 'green',
                'message' => 'Toast centré en haut.',
                'position' => 'top-center',
                'visible' => true,
            ],

            'bottom right' => [
                'color' => 'yellow',
                'message' => 'Toast en bas à droite.',
                'position' => 'bottom-right',
                'visible' => true,
            ],

            'bottom left' => [
                'color' => 'red',
                'message' => 'Toast en bas à gauche.',
                'position' => 'bottom-left',
                'visible' => true,
            ],

            'bottom center' => [
                'color' => 'blue',
                'message' => 'Toast centré en bas.',
                'position' => 'bottom-center',
                'visible' => true,
            ],

            'center screen' => [
                'color' => 'yellow',
                'title' => 'Message important',
                'message' => 'Toast centré au milieu de l\'écran.',
                'position' => 'center',
                'visible' => true,
            ],

            'complete example' => [
                'color' => 'green',
                'title' => 'Commande confirmée',
                'message' => 'Votre commande #12345 a été confirmée et sera livrée sous 2-3 jours.',
                'actionText' => 'Suivre la commande',
                'actionUrl' => '/orders/12345',
                'duration' => 8000,
                'remainingTime' => 8000,
                'visible' => true,
            ],
        ];
    }
}

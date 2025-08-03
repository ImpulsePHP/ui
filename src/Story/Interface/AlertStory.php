<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIAlertComponent;
use Impulse\UI\Utility\TailwindColorUtility;

final class AlertStory extends AbstractStory
{
    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Alert';
    }

    public function description(): string
    {
        return 'Composant d\'alerte avec différents types, styles et couleurs Tailwind';
    }

    public function componentClass(): string
    {
        return UIAlertComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'title' => 'Message d\'alerte',
            'description' => '',
            'withIcon' => false,
            'withClose' => false,
            'iconName' => '',
            'dismissible' => false,
            'color' => 'blue',
            'variant' => 'filled',
        ];
    }

    public function variants(): array
    {
        return [
            // === VARIANTES DE BASE ===
            'info' => [
                'title' => 'Information importante',
                'description' => 'Voici une information que vous devriez connaître.',
                'color' => 'blue',
                'iconName' => 'information-circle',
            'withIcon' => true,],


            'success' => [
                'title' => 'Opération réussie',
                'description' => 'Votre action a été effectuée avec succès !',
                'color' => 'green',
                'iconName' => 'check-circle',
            'withIcon' => true,],


            'warning' => [
                'title' => 'Attention requise',
                'description' => 'Attention, cette action nécessite votre confirmation.',
                'color' => 'amber',
                'iconName' => 'exclamation-triangle',
            'withIcon' => true,],


            'error' => [
                'title' => 'Erreur détectée',
                'description' => 'Une erreur s\'est produite lors du traitement.',
                'color' => 'red',
                'iconName' => 'x-circle',
            'withIcon' => true,],


            // === VARIANTS ===
            'filled variant' => [
                'title' => 'Alerte remplie',
                'description' => 'Style par défaut avec fond coloré léger.',
                'variant' => 'filled',
                'color' => 'purple',
            ],

            'outline variant' => [
                'title' => 'Alerte contour',
                'description' => 'Style avec bordure colorée et fond blanc.',
                'variant' => 'outline',
                'color' => 'indigo',
            ],

            'solid variant' => [
                'title' => 'Alerte solide',
                'description' => 'Style avec fond plein et texte blanc.',
                'variant' => 'solid',
                'color' => 'rose',
            ],

            // === AVEC DESCRIPTION ===
            'with long description' => [
                'title' => 'Alerte détaillée',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid pariatur, ipsum similique veniam quo totam eius aperiam dolorum. Distinctio, eum at.',
                'color' => 'cyan',
            ],

            // === AVEC ACTIONS ===
            'with close button' => [
                'title' => 'Alerte fermable',
                'description' => 'Cliquez sur la croix pour fermer cette alerte.',
                'withClose' => true,
                'color' => 'teal',
            ],

            'dismissible alert' => [
                'title' => 'Alerte avec événement',
                'description' => 'Cette alerte émet un événement lors de la fermeture.',
                'dismissible' => true,
                'color' => 'orange',
                'iconName' => 'bell',
            'withIcon' => true,],


            // === SANS ICÔNE ===
            'without icon' => [
                'title' => 'Message simple',
                'description' => 'Alerte sans icône pour un style plus minimaliste.',
                'withIcon' => false,
                'color' => 'slate',
            ],

            // === AVEC ICÔNE PERSONNALISÉE ===
            'custom icon' => [
                'title' => 'Alerte personnalisée',
                'description' => 'Avec une icône personnalisée.',
                'iconName' => 'star',
                'withIcon' => true,
                'color' => 'yellow',
            ],

            // === TITRE SEUL ===
            'title only' => [
                'title' => 'Message court sans description',
                'color' => 'emerald',
                'iconName' => 'check',
            'withIcon' => true,],


            // === TOUTES LES COULEURS ===
            'slate color' => [
                'title' => 'Alerte Slate',
                'description' => 'Couleur neutre et élégante.',
                'color' => 'slate',
            ],

            'gray color' => [
                'title' => 'Alerte Gray',
                'description' => 'Couleur grise classique.',
                'color' => 'gray',
            ],

            'zinc color' => [
                'title' => 'Alerte Zinc',
                'description' => 'Couleur zinc moderne.',
                'color' => 'zinc',
            ],

            'neutral color' => [
                'title' => 'Alerte Neutral',
                'description' => 'Couleur neutre équilibrée.',
                'color' => 'neutral',
            ],

            'stone color' => [
                'title' => 'Alerte Stone',
                'description' => 'Couleur pierre naturelle.',
                'color' => 'stone',
            ],

            'red color' => [
                'title' => 'Alerte Red',
                'description' => 'Pour les erreurs et alertes critiques.',
                'color' => 'red',
            ],

            'orange color' => [
                'title' => 'Alerte Orange',
                'description' => 'Pour les notifications importantes.',
                'color' => 'orange',
            ],

            'amber color' => [
                'title' => 'Alerte Amber',
                'description' => 'Pour les avertissements.',
                'color' => 'amber',
            ],

            'yellow color' => [
                'title' => 'Alerte Yellow',
                'description' => 'Pour attirer l\'attention.',
                'color' => 'yellow',
            ],

            'lime color' => [
                'title' => 'Alerte Lime',
                'description' => 'Couleur vive et énergique.',
                'color' => 'lime',
            ],

            'green color' => [
                'title' => 'Alerte Green',
                'description' => 'Pour les succès et confirmations.',
                'color' => 'green',
            ],

            'emerald color' => [
                'title' => 'Alerte Emerald',
                'description' => 'Vert émeraude élégant.',
                'color' => 'emerald',
            ],

            'teal color' => [
                'title' => 'Alerte Teal',
                'description' => 'Bleu-vert apaisant.',
                'color' => 'teal',
            ],

            'cyan color' => [
                'title' => 'Alerte Cyan',
                'description' => 'Cyan rafraîchissant.',
                'color' => 'cyan',
            ],

            'sky color' => [
                'title' => 'Alerte Sky',
                'description' => 'Bleu ciel lumineux.',
                'color' => 'sky',
            ],

            'blue color' => [
                'title' => 'Alerte Blue',
                'description' => 'Pour les informations générales.',
                'color' => 'blue',
            ],

            'indigo color' => [
                'title' => 'Alerte Indigo',
                'description' => 'Indigo profond et professionnel.',
                'color' => 'indigo',
            ],

            'violet color' => [
                'title' => 'Alerte Violet',
                'description' => 'Violet créatif et moderne.',
                'color' => 'violet',
            ],

            'purple color' => [
                'title' => 'Alerte Purple',
                'description' => 'Violet royal et élégant.',
                'color' => 'purple',
            ],

            'fuchsia color' => [
                'title' => 'Alerte Fuchsia',
                'description' => 'Rose-violet vibrant.',
                'color' => 'fuchsia',
            ],

            'pink color' => [
                'title' => 'Alerte Pink',
                'description' => 'Rose doux et accueillant.',
                'color' => 'pink',
            ],

            'rose color' => [
                'title' => 'Alerte Rose',
                'description' => 'Rose classique et chaleureux.',
                'color' => 'rose',
            ],

            // === CAS D'USAGE RÉELS ===
            'maintenance notice' => [
                'title' => 'Maintenance programmée',
                'description' => 'Le système sera indisponible demain de 2h à 4h du matin pour maintenance.',
                'color' => 'amber',
                'variant' => 'outline',
                'iconName' => 'wrench',
                'withIcon' => true,
                'withClose' => true,
            ],

            'update available' => [
                'title' => 'Mise à jour disponible',
                'description' => 'Une nouvelle version est disponible. Veuillez redémarrer l\'application.',
                'color' => 'blue',
                'iconName' => 'arrow-down-tray',
                'withIcon' => true,
                'dismissible' => true,
            ],

            'data saved' => [
                'title' => 'Données sauvegardées',
                'color' => 'green',
                'variant' => 'filled',
                'iconName' => 'check',
            'withIcon' => true,],


            'quota exceeded' => [
                'title' => 'Quota dépassé',
                'description' => 'Vous avez atteint la limite de votre forfait. Veuillez mettre à niveau votre compte pour continuer.',
                'color' => 'red',
                'variant' => 'solid',
                'iconName' => 'exclamation-triangle',
            'withIcon' => true,],


            'welcome message' => [
                'title' => 'Bienvenue !',
                'description' => 'Merci de vous être inscrit. Votre compte a été créé avec succès.',
                'color' => 'purple',
                'iconName' => 'sparkles',
                'withIcon' => true,
                'withClose' => true,
            ],

            'connection lost' => [
                'title' => 'Connexion perdue',
                'description' => 'La connexion au serveur a été interrompue. Tentative de reconnexion...',
                'color' => 'orange',
                'variant' => 'outline',
                'iconName' => 'wifi',
            'withIcon' => true,],


            // === COMBINAISONS COMPLEXES ===
            'critical error solid' => [
                'title' => 'Erreur critique',
                'description' => 'Une erreur système critique s\'est produite. Veuillez contacter le support technique.',
                'color' => 'red',
                'variant' => 'solid',
                'iconName' => 'shield-exclamation',
                'withIcon' => true,
                'dismissible' => true,
            ],

            'success outline dismissible' => [
                'title' => 'Opération terminée',
                'description' => 'Votre fichier a été téléchargé et traité avec succès.',
                'color' => 'emerald',
                'variant' => 'outline',
                'iconName' => 'cloud-arrow-down',
                'withIcon' => true,
                'dismissible' => true,
            ],
        ];
    }
}

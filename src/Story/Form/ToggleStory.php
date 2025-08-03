<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UIToggleComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class ToggleStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Form';

    public function name(): string
    {
        return 'Toggle Switch';
    }

    public function description(): string
    {
        return 'Composant Toggle avec switch moderne pour activer/désactiver des options';
    }

    public function componentClass(): string
    {
        return UIToggleComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => '',
            'value' => false,
            'name' => uniqid('toggle'),
            'id' => uniqid('toggle_id_'),
            'size' => 'normal',
            'color' => 'indigo',
            'disabled' => false,
            'required' => false,
            'helpText' => '',
            'errorMessage' => '',
            'labelPosition' => 'right',
            'onLabel' => '',
            'offLabel' => '',
            'showLabels' => false,
            'rules' => '',
        ];
    }

    public function variants(): array
    {
        return [
            // === BASIQUES ===
            'simple toggle' => [
                'label' => 'Activer les notifications',
                'helpText' => 'Recevez des notifications push',
            ],

            'toggle activated' => [
                'label' => 'Mode sombre',
                'value' => true,
                'color' => 'indigo',
                'helpText' => 'Interface en thème sombre',
            ],

            'required toggle' => [
                'label' => 'Accepter les conditions',
                'required' => true,
                'rules' => 'required',
                'color' => 'red',
                'helpText' => 'Acceptation obligatoire',
            ],

            // === TAILLES ===
            'small toggle' => [
                'label' => 'Option compacte',
                'size' => 'small',
                'color' => 'green',
            ],

            'large toggle' => [
                'label' => 'Option importante',
                'size' => 'large',
                'value' => true,
                'color' => 'blue',
            ],

            // === POSITIONS DU LABEL ===
            'label left' => [
                'label' => 'Synchronisation automatique',
                'labelPosition' => 'left',
                'color' => 'emerald',
                'value' => true,
            ],

            'label top' => [
                'label' => 'Préférences avancées',
                'labelPosition' => 'top',
                'color' => 'purple',
                'helpText' => 'Label au-dessus du toggle',
            ],

            'label bottom' => [
                'label' => 'Configuration système',
                'labelPosition' => 'bottom',
                'color' => 'orange',
                'helpText' => 'Label en dessous du toggle',
            ],

            // === AVEC LABELS ON/OFF ===
            'with on off labels' => [
                'label' => 'Mode maintenance',
                'showLabels' => true,
                'onLabel' => 'ACTIVÉ',
                'offLabel' => 'DÉSACTIVÉ',
                'color' => 'red',
                'helpText' => 'Active le mode maintenance',
            ],

            'custom labels' => [
                'label' => 'Visibilité du profil',
                'showLabels' => true,
                'onLabel' => 'PUBLIC',
                'offLabel' => 'PRIVÉ',
                'value' => true,
                'color' => 'blue',
                'size' => 'large',
            ],

            // === COULEURS ===
            'colors - green toggle' => [
                'label' => 'Fonction activée',
                'value' => true,
                'color' => 'green',
                'showLabels' => true,
            ],

            'colors - red toggle' => [
                'label' => 'Alerte critique',
                'value' => true,
                'color' => 'red',
                'size' => 'large',
            ],

            'colors - yellow toggle' => [
                'label' => 'Mode test',
                'color' => 'yellow',
                'showLabels' => true,
                'onLabel' => 'TEST',
                'offLabel' => 'PROD',
            ],

            // === ÉTATS ===
            'disabled off' => [
                'label' => 'Option désactivée',
                'disabled' => true,
                'color' => 'slate',
                'helpText' => 'Cette option ne peut pas être modifiée',
            ],

            'disabled on' => [
                'label' => 'Toujours activé',
                'value' => true,
                'disabled' => true,
                'color' => 'slate',
                'helpText' => 'Défini par l\'administrateur',
            ],

            // === AVEC VALIDATION ===
            'with error' => [
                'label' => 'Accepter les CGU',
                'required' => true,
                'rules' => 'required',
                'errorMessage' => 'Vous devez accepter les conditions',
                'color' => 'red',
            ],

            // === CAS D'USAGE ===
            'privacy setting' => [
                'label' => 'Profil public',
                'labelPosition' => 'left',
                'showLabels' => true,
                'onLabel' => 'PUBLIC',
                'offLabel' => 'PRIVÉ',
                'color' => 'blue',
                'helpText' => 'Contrôle la visibilité de votre profil',
            ],

            'feature flag' => [
                'label' => 'Nouvelle interface (Beta)',
                'color' => 'purple',
                'size' => 'large',
                'helpText' => 'Activer la nouvelle interface utilisateur',
            ],

            'notification setting' => [
                'label' => 'Notifications push',
                'value' => true,
                'color' => 'green',
                'showLabels' => true,
                'onLabel' => 'OUI',
                'offLabel' => 'NON',
                'helpText' => 'Recevoir des notifications sur votre appareil',
            ],
        ];
    }
}

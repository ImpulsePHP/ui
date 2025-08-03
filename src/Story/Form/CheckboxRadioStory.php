<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UICheckboxRadioComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class CheckboxRadioStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Form';

    public function name(): string
    {
        return 'Checkbox & Radio';
    }

    public function description(): string
    {
        return 'Composant unifié pour les cases à cocher et boutons radio avec support des options multiples et validation';
    }

    public function componentClass(): string
    {
        return UICheckboxRadioComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'type' => 'checkbox',
            'label' => '',
            'value' => '',
            'name' => uniqid('input'),
            'id' => uniqid('id_'),
            'options' => [],
            'size' => 'normal',
            'color' => 'indigo',
            'orientation' => 'vertical',
            'disabled' => false,
            'required' => false,
            'helpText' => '',
            'errorMessage' => '',
            'inline' => false,
            'rules' => '',
        ];
    }

    public function variants(): array
    {
        $preferences = [
            'email' => 'Notifications par email',
            'sms' => 'Notifications SMS',
            'push' => 'Notifications push',
            'newsletter' => 'Newsletter hebdomadaire',
            'promo' => 'Offres promotionnelles',
        ];

        $skills = [
            'php' => 'PHP',
            'javascript' => 'JavaScript',
            'python' => 'Python',
            'java' => 'Java',
            'csharp' => 'C#',
            'golang' => 'Go',
            'typescript' => 'TypeScript',
        ];

        $languages = [
            'fr' => 'Français',
            'en' => 'English',
            'es' => 'Español',
            'de' => 'Deutsch',
            'it' => 'Italiano',
        ];

        $priorities = [
            'low' => 'Basse',
            'medium' => 'Moyenne',
            'high' => 'Haute',
            'urgent' => 'Urgente',
        ];

        $themes = [
            'light' => 'Thème clair',
            'dark' => 'Thème sombre',
            'auto' => 'Automatique',
        ];

        $hobbies = [
            'reading' => [
                'label' => 'Lecture',
                'description' => 'Romans, essais, bandes dessinées'
            ],
            'sports' => [
                'label' => 'Sport',
                'description' => 'Football, tennis, natation'
            ],
            'music' => [
                'label' => 'Musique',
                'description' => 'Écoute et pratique instrumentale'
            ],
            'travel' => [
                'label' => 'Voyage',
                'description' => 'Découverte de nouvelles cultures'
            ],
            'cooking' => [
                'label' => 'Cuisine',
                'description' => 'Préparation de plats variés'
            ],
        ];

        return [
            // === CHECKBOX SIMPLE ===
            'single checkbox' => [
                'type' => 'checkbox',
                'label' => 'J\'accepte les conditions d\'utilisation',
                'color' => 'blue',
                'helpText' => 'Case à cocher simple avec description',
            ],

            'checkbox with value' => [
                'type' => 'checkbox',
                'label' => 'Recevoir les notifications',
                'value' => ['on'],
                'color' => 'green',
                'helpText' => 'Case cochée par défaut',
            ],

            'required checkbox' => [
                'type' => 'checkbox',
                'label' => 'Accepter la politique de confidentialité',
                'required' => true,
                'rules' => 'required',
                'color' => 'red',
                'helpText' => 'Cette acceptation est obligatoire',
            ],

            // === CHECKBOX MULTIPLES ===
            'checkbox preferences' => [
                'type' => 'checkbox',
                'label' => 'Préférences de notification',
                'options' => $preferences,
                'value' => ['email', 'push'],
                'color' => 'indigo',
                'helpText' => 'Sélectionnez vos préférences de notification',
            ],

            'checkbox skills horizontal' => [
                'type' => 'checkbox',
                'label' => 'Compétences techniques',
                'options' => $skills,
                'value' => ['php', 'javascript', 'python'],
                'orientation' => 'horizontal',
                'color' => 'blue',
                'helpText' => 'Disposées horizontalement pour gagner de l\'espace',
            ],
            'checkbox inline compact' => [
                'type' => 'checkbox',
                'label' => 'Options rapides',
                'options' => [
                    'urgent' => 'Urgent',
                    'important' => 'Important',
                    'follow' => 'Suivi',
                ],
                'inline' => true,
                'size' => 'small',
                'color' => 'yellow',
                'helpText' => 'Format compact en ligne',
            ],

            // === RADIO SIMPLE ===
            'single radio option' => [
                'type' => 'radio',
                'label' => 'Mode de livraison premium',
                'color' => 'emerald',
                'helpText' => 'Livraison express sous 24h (5€ supplémentaires)',
            ],

            // === RADIO MULTIPLES ===
            'radio languages' => [
                'type' => 'radio',
                'label' => 'Langue préférée',
                'options' => $languages,
                'value' => 'fr',
                'color' => 'blue',
                'helpText' => 'Sélection unique parmi plusieurs langues',
            ],

            'radio priority' => [
                'type' => 'radio',
                'label' => 'Niveau de priorité',
                'options' => $priorities,
                'value' => 'medium',
                'color' => 'yellow',
                'helpText' => 'Définissez le niveau de priorité de la tâche',
            ],

            'radio themes horizontal' => [
                'type' => 'radio',
                'label' => 'Thème de l\'interface',
                'options' => $themes,
                'value' => 'auto',
                'orientation' => 'horizontal',
                'color' => 'purple',
                'helpText' => 'Choix du thème visuel (disposition horizontale)',
            ],

            // === ÉTATS ET VALIDATION ===
            'checkbox required validation' => [
                'type' => 'checkbox',
                'label' => 'Compétences requises (minimum 2)',
                'options' => $skills,
                'required' => true,
                'rules' => 'required|min_count:2',
                'color' => 'red',
                'helpText' => 'Sélectionnez au moins 2 compétences',
            ],

            'radio required validation' => [
                'type' => 'radio',
                'label' => 'Département (obligatoire)',
                'options' => [
                    'it' => 'Informatique',
                    'hr' => 'Ressources Humaines',
                    'finance' => 'Finance',
                    'marketing' => 'Marketing',
                ],
                'required' => true,
                'rules' => 'required',
                'color' => 'red',
                'helpText' => 'La sélection d\'un département est obligatoire',
            ],

            'with validation error' => [
                'type' => 'checkbox',
                'label' => 'Conditions d\'utilisation',
                'options' => [
                    'terms' => 'J\'accepte les conditions générales',
                    'privacy' => 'J\'accepte la politique de confidentialité',
                ],
                'required' => true,
                'rules' => 'required|min_count:2',
                'errorMessage' => 'Vous devez accepter toutes les conditions',
                'color' => 'red',
                'helpText' => 'Acceptation obligatoire',
            ],

            // === TAILLES ===
            'small size checkbox' => [
                'type' => 'checkbox',
                'label' => 'Options compactes',
                'options' => [
                    'opt1' => 'Option 1',
                    'opt2' => 'Option 2',
                    'opt3' => 'Option 3',
                ],
                'size' => 'small',
                'color' => 'slate',
                'helpText' => 'Taille réduite pour interfaces compactes',
            ],

            'large size radio' => [
                'type' => 'radio',
                'label' => 'Choix principal',
                'options' => [
                    'option1' => 'Première option',
                    'option2' => 'Deuxième option',
                ],
                'size' => 'large',
                'value' => 'option1',
                'color' => 'green',
                'helpText' => 'Taille agrandie pour plus de visibilité',
            ],

            // === COULEURS ===
            'colors - emerald checkbox' => [
                'type' => 'checkbox',
                'label' => 'Fonctionnalités activées',
                'options' => [
                    'feature1' => 'Synchronisation cloud',
                    'feature2' => 'Notifications temps réel',
                    'feature3' => 'Mode hors ligne',
                ],
                'value' => ['feature1', 'feature2'],
                'color' => 'emerald',
            ],

            'colors - pink radio' => [
                'type' => 'radio',
                'label' => 'Style visuel',
                'options' => [
                    'minimal' => 'Minimaliste',
                    'colorful' => 'Coloré',
                    'classic' => 'Classique',
                ],
                'color' => 'pink',
                'value' => 'colorful',
            ],

            'colors - violet checkbox' => [
                'type' => 'checkbox',
                'label' => 'Services additionnels',
                'options' => [
                    'backup' => 'Sauvegarde automatique',
                    'support' => 'Support premium',
                    'analytics' => 'Analyses avancées',
                ],
                'color' => 'violet',
                'value' => ['backup'],
            ],

            // === ÉTATS SPÉCIAUX ===
            'disabled checkbox' => [
                'type' => 'checkbox',
                'label' => 'Options désactivées',
                'options' => [
                    'disabled1' => 'Option désactivée 1',
                    'disabled2' => 'Option désactivée 2',
                ],
                'value' => ['disabled1'],
                'disabled' => true,
                'color' => 'slate',
                'helpText' => 'Ces options ne peuvent pas être modifiées',
            ],

            'disabled radio' => [
                'type' => 'radio',
                'label' => 'Configuration système',
                'options' => [
                    'config1' => 'Configuration automatique',
                    'config2' => 'Configuration manuelle',
                ],
                'value' => 'config1',
                'disabled' => true,
                'color' => 'slate',
                'helpText' => 'Défini par l\'administrateur système',
            ],

            // === CAS D'USAGE COMPLEXES ===
            'complex preferences' => [
                'type' => 'checkbox',
                'label' => 'Préférences de communication complètes',
                'options' => [
                    'email_daily' => [
                        'label' => 'Email quotidien',
                    ],
                    'email_weekly' => [
                        'label' => 'Email hebdomadaire',
                    ],
                    'sms_urgent' => [
                        'label' => 'SMS urgents',
                    ],
                    'push_realtime' => [
                        'label' => 'Push temps réel',
                    ],
                ],
                'value' => ['email_weekly', 'push_realtime'],
                'color' => 'blue',
                'helpText' => 'Personnalisez finement vos notifications',
                'required' => true,
                'rules' => 'required',
            ],

            'delivery method radio' => [
                'type' => 'radio',
                'label' => 'Mode de livraison',
                'options' => [
                    'standard' => [
                        'label' => 'Standard (Gratuit)',
                    ],
                    'express' => [
                        'label' => 'Express (+5€)',
                    ],
                    'same_day' => [
                        'label' => 'Jour même (+15€)',
                    ],
                ],
                'value' => 'standard',
                'color' => 'green',
                'helpText' => 'Choisissez votre mode de livraison préféré',
                'required' => true,
                'rules' => 'required',
            ],
        ];
    }
}

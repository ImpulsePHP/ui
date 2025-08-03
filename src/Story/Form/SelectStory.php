<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UISelectComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class SelectStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Form';

    public function name(): string
    {
        return 'Select';
    }

    public function description(): string
    {
        return 'Composant select avec sélection multiple, badges et recherche intégrée';
    }

    public function componentClass(): string
    {
        return UISelectComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'size' => 'normal',
            'color' => 'indigo',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'multiple' => false,
            'searchable' => false,
            'searchPlaceholder' => $this->trans('select.search_placeholder'),
            'name' => uniqid('select'),
            'id' => uniqid('id_select'),
            'helpText' => '',
            'errorMessage' => '',
            'rules' => '',
            'options' => [],
            'iconName' => '',
            'iconPosition' => 'left',
        ];
    }

    public function variants(): array
    {
        $simpleOptions = [
            ['value' => 'fr', 'label' => 'Français'],
            ['value' => 'en', 'label' => 'English'],
            ['value' => 'es', 'label' => 'Español'],
            ['value' => 'de', 'label' => 'Deutsch'],
            ['value' => 'it', 'label' => 'Italiano'],
        ];

        $countries = [
            ['value' => 'fr', 'label' => 'France'],
            ['value' => 'be', 'label' => 'Belgique'],
            ['value' => 'ch', 'label' => 'Suisse'],
            ['value' => 'ca', 'label' => 'Canada'],
            ['value' => 'us', 'label' => 'États-Unis'],
            ['value' => 'uk', 'label' => 'Royaume-Uni'],
            ['value' => 'de', 'label' => 'Allemagne'],
            ['value' => 'es', 'label' => 'Espagne'],
            ['value' => 'it', 'label' => 'Italie'],
            ['value' => 'pt', 'label' => 'Portugal'],
            ['value' => 'nl', 'label' => 'Pays-Bas'],
            ['value' => 'se', 'label' => 'Suède'],
            ['value' => 'no', 'label' => 'Norvège'],
            ['value' => 'dk', 'label' => 'Danemark'],
            ['value' => 'fi', 'label' => 'Finlande'],
        ];

        $skills = [
            ['value' => 'php', 'label' => 'PHP'],
            ['value' => 'javascript', 'label' => 'JavaScript'],
            ['value' => 'python', 'label' => 'Python'],
            ['value' => 'java', 'label' => 'Java'],
            ['value' => 'csharp', 'label' => 'C#'],
            ['value' => 'golang', 'label' => 'Go'],
            ['value' => 'rust', 'label' => 'Rust'],
            ['value' => 'typescript', 'label' => 'TypeScript'],
            ['value' => 'swift', 'label' => 'Swift'],
            ['value' => 'kotlin', 'label' => 'Kotlin'],
            ['value' => 'ruby', 'label' => 'Ruby'],
            ['value' => 'scala', 'label' => 'Scala'],
            ['value' => 'perl', 'label' => 'Perl'],
            ['value' => 'r', 'label' => 'R'],
            ['value' => 'matlab', 'label' => 'MATLAB'],
        ];

        $teamMembers = [
            ['value' => 'alice', 'label' => 'Alice Dupont - Développeur Senior'],
            ['value' => 'bob', 'label' => 'Bob Martin - Designer UX/UI'],
            ['value' => 'claire', 'label' => 'Claire Dubois - Chef de Projet'],
            ['value' => 'david', 'label' => 'David Bernard - Testeur QA'],
            ['value' => 'emma', 'label' => 'Emma Petit - DevOps Engineer'],
            ['value' => 'felix', 'label' => 'Félix Moreau - Architecte Logiciel'],
            ['value' => 'grace', 'label' => 'Grace Laurent - Product Owner'],
            ['value' => 'henri', 'label' => 'Henri Roux - Analyste Business'],
        ];

        $categories = [
            ['value' => 'tech', 'label' => 'Technologie'],
            ['value' => 'design', 'label' => 'Design'],
            ['value' => 'marketing', 'label' => 'Marketing'],
            ['value' => 'sales', 'label' => 'Ventes'],
            ['value' => 'support', 'label' => 'Support'],
            ['value' => 'hr', 'label' => 'Ressources Humaines'],
        ];

        return [
            'basic single select' => [
                'label' => 'Langue préférée',
                'options' => $simpleOptions,
                'color' => 'indigo',
                'helpText' => 'Sélectionnez votre langue préférée',
            ],
            'with language icon' => [
                'label' => 'Langue préférée',
                'options' => $simpleOptions,
                'iconName' => 'language',
                'iconPosition' => 'left',
                'color' => 'blue',
                'helpText' => 'Icône de langue intégrée',
                'value' => 'fr',
            ],
            'countries with map icon' => [
                'label' => 'Pays de résidence',
                'options' => $countries,
                'iconName' => 'globe-americas',
                'iconPosition' => 'left',
                'searchable' => true,
                'searchPlaceholder' => 'Rechercher un pays...',
                'color' => 'green',
                'helpText' => 'Sélection avec icône de carte du monde',
                'value' => 'fr',
            ],
            'with icon right position' => [
                'label' => 'Catégorie de projet',
                'options' => $categories,
                'iconName' => 'folder',
                'iconPosition' => 'right',
                'color' => 'purple',
                'helpText' => 'Icône positionnée à droite du champ',
                'value' => 'tech',
                'searchable' => false,
            ],
            'multiple with icon and badges' => [
                'label' => 'Compétences techniques',
                'options' => $skills,
                'iconName' => 'code-bracket',
                'iconPosition' => 'left',
                'multiple' => true,
                'value' => ['php', 'javascript', 'python'],
                'color' => 'blue',
                'searchable' => true,
                'searchPlaceholder' => 'Rechercher une compétence...',
                'helpText' => 'Sélection multiple avec icône et badges colorés',
                'placeholder' => 'Aucune compétence sélectionnée...',
            ],
            'with preselected value' => [
                'label' => 'Langue par défaut',
                'options' => $simpleOptions,
                'value' => 'fr',
                'color' => 'blue',
                'helpText' => 'Langue définie par défaut',
            ],
            'multiple selection' => [
                'label' => 'Compétences techniques',
                'options' => $skills,
                'multiple' => true,
                'value' => ['php', 'javascript'],
                'color' => 'blue',
                'helpText' => 'Sélectionnez toutes vos compétences',
                'placeholder' => 'Choisissez vos compétences...',
            ],
            'multiple empty' => [
                'label' => 'Technologies à apprendre',
                'options' => $skills,
                'multiple' => true,
                'color' => 'green',
                'helpText' => 'Quelles technologies souhaitez-vous apprendre ?',
                'placeholder' => 'Aucune sélection...',
            ],
            'searchable countries' => [
                'label' => 'Pays de résidence',
                'options' => $countries,
                'searchable' => true,
                'searchPlaceholder' => 'Rechercher un pays...',
                'color' => 'green',
                'helpText' => 'Utilisez la recherche pour trouver votre pays',
            ],
            'multiple with search' => [
                'label' => 'Pays visités',
                'options' => $countries,
                'multiple' => true,
                'searchable' => true,
                'value' => ['fr', 'be', 'ch'],
                'color' => 'purple',
                'helpText' => 'Sélectionnez tous les pays que vous avez visités',
                'searchPlaceholder' => 'Rechercher des pays...',
            ],
            'team selection' => [
                'label' => 'Membres de l\'équipe',
                'options' => $teamMembers,
                'multiple' => true,
                'searchable' => true,
                'value' => ['alice', 'claire'],
                'color' => 'indigo',
                'helpText' => 'Choisissez les membres de votre équipe projet',
                'searchPlaceholder' => 'Rechercher un membre...',
            ],
            'required field' => [
                'label' => 'Catégorie obligatoire',
                'options' => [
                    ['value' => 'web', 'label' => 'Développement Web'],
                    ['value' => 'mobile', 'label' => 'Applications Mobiles'],
                    ['value' => 'desktop', 'label' => 'Applications Desktop'],
                    ['value' => 'api', 'label' => 'APIs et Services'],
                    ['value' => 'data', 'label' => 'Science des Données'],
                    ['value' => 'security', 'label' => 'Cybersécurité'],
                ],
                'required' => true,
                'rules' => 'required',
                'color' => 'red',
                'helpText' => 'Ce champ est obligatoire',
            ],
            'multiple required' => [
                'label' => 'Compétences requises (min 2)',
                'options' => $skills,
                'multiple' => true,
                'required' => true,
                'rules' => 'required|min_count:2',
                'color' => 'red',
                'helpText' => 'Sélectionnez au moins 2 compétences',
                'placeholder' => 'Aucune compétence sélectionnée',
            ],
            'with validation error' => [
                'label' => 'Sélection avec erreur',
                'options' => $simpleOptions,
                'rules' => 'required',
                'errorMessage' => 'Veuillez sélectionner au moins une option',
                'color' => 'red',
                'helpText' => 'Une sélection est requise',
            ],
            'disabled state' => [
                'label' => 'Sélection désactivée',
                'options' => $simpleOptions,
                'value' => 'fr',
                'disabled' => true,
                'helpText' => 'Ce champ ne peut pas être modifié',
            ],
            'readonly state' => [
                'label' => 'Configuration système',
                'options' => $simpleOptions,
                'value' => 'fr',
                'readonly' => true,
                'color' => 'slate',
                'helpText' => 'Valeur définie par le système',
            ],
            'small size' => [
                'label' => 'Priorité',
                'options' => [
                    ['value' => 'low', 'label' => 'Basse'],
                    ['value' => 'medium', 'label' => 'Moyenne'],
                    ['value' => 'high', 'label' => 'Haute'],
                    ['value' => 'urgent', 'label' => 'Urgente'],
                ],
                'size' => 'small',
                'color' => 'yellow',
                'helpText' => 'Niveau de priorité de la tâche',
            ],
            'large size' => [
                'label' => 'Projet principal',
                'options' => [
                    ['value' => 'proj1', 'label' => 'Site Web Corporate'],
                    ['value' => 'proj2', 'label' => 'Application Mobile E-commerce'],
                    ['value' => 'proj3', 'label' => 'API Gateway Microservices'],
                    ['value' => 'proj4', 'label' => 'Dashboard Analytics Temps Réel'],
                    ['value' => 'proj5', 'label' => 'Plateforme IoT Industrielle'],
                ],
                'size' => 'large',
                'color' => 'indigo',
                'helpText' => 'Sélectionnez le projet principal',
            ],
            'full width' => [
                'label' => 'Technologies utilisées',
                'options' => $skills,
                'multiple' => true,
                'block' => true,
                'value' => ['php', 'javascript', 'python'],
                'color' => 'green',
                'helpText' => 'Toutes les technologies que vous maîtrisez',
            ],
            'without search' => [
                'label' => 'Statut utilisateur',
                'options' => [
                    ['value' => 'active', 'label' => 'Actif'],
                    ['value' => 'inactive', 'label' => 'Inactif'],
                    ['value' => 'pending', 'label' => 'En attente'],
                    ['value' => 'suspended', 'label' => 'Suspendu'],
                    ['value' => 'banned', 'label' => 'Banni'],
                ],
                'searchable' => false,
                'color' => 'slate',
                'helpText' => 'Statut actuel du compte utilisateur',
            ],
            'colors variants - blue' => [
                'label' => 'Départements',
                'options' => [
                    ['value' => 'it', 'label' => 'Informatique'],
                    ['value' => 'hr', 'label' => 'Ressources Humaines'],
                    ['value' => 'finance', 'label' => 'Finance'],
                    ['value' => 'marketing', 'label' => 'Marketing'],
                ],
                'color' => 'blue',
                'value' => 'it',
            ],
            'colors variants - green' => [
                'label' => 'Environnement',
                'options' => [
                    ['value' => 'dev', 'label' => 'Développement'],
                    ['value' => 'staging', 'label' => 'Test'],
                    ['value' => 'prod', 'label' => 'Production'],
                ],
                'color' => 'green',
                'value' => 'dev',
            ],
            'colors variants - purple' => [
                'label' => 'Thème interface',
                'options' => [
                    ['value' => 'light', 'label' => 'Clair'],
                    ['value' => 'dark', 'label' => 'Sombre'],
                    ['value' => 'auto', 'label' => 'Automatique'],
                ],
                'color' => 'purple',
                'value' => 'auto',
            ],
            'colors variants - yellow' => [
                'label' => 'Niveau d\'alerte',
                'options' => [
                    ['value' => 'info', 'label' => 'Information'],
                    ['value' => 'warning', 'label' => 'Avertissement'],
                    ['value' => 'critical', 'label' => 'Critique'],
                ],
                'color' => 'yellow',
                'value' => 'warning',
            ],
            'long list searchable' => [
                'label' => 'Pays du monde',
                'options' => array_merge($countries, [
                    ['value' => 'au', 'label' => 'Australie'],
                    ['value' => 'br', 'label' => 'Brésil'],
                    ['value' => 'cn', 'label' => 'Chine'],
                    ['value' => 'in', 'label' => 'Inde'],
                    ['value' => 'jp', 'label' => 'Japon'],
                    ['value' => 'kr', 'label' => 'Corée du Sud'],
                    ['value' => 'mx', 'label' => 'Mexique'],
                    ['value' => 'ru', 'label' => 'Russie'],
                    ['value' => 'za', 'label' => 'Afrique du Sud'],
                    ['value' => 'eg', 'label' => 'Égypte'],
                ]),
                'searchable' => true,
                'color' => 'indigo',
                'helpText' => 'Liste complète avec recherche indispensable',
                'searchPlaceholder' => 'Tapez le nom du pays...',
            ],
            'complex multiple selection' => [
                'label' => 'Équipe projet complète',
                'options' => $teamMembers,
                'multiple' => true,
                'searchable' => true,
                'value' => ['alice', 'bob', 'claire'],
                'required' => true,
                'rules' => 'required|min_count:3|max_count:6',
                'color' => 'blue',
                'helpText' => 'Sélectionnez entre 3 et 6 membres pour l\'équipe',
                'searchPlaceholder' => 'Rechercher par nom ou rôle...',
            ],
        ];
    }
}

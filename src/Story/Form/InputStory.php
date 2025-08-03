<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UIInputComponent;

final class InputStory extends AbstractStory
{
    protected string $category = 'Form';

    public function name(): string
    {
        return 'Input';
    }

    public function description(): string
    {
        return 'Composant input avec validation intégrée et gestion d\'état avancée';
    }

    public function componentClass(): string
    {
        return UIInputComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => 'Label',
            'placeholder' => '',
            'value' => '',
            'type' => 'text',
            'size' => 'normal',
            'color' => 'indigo',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'name' => uniqid('name'),
            'id' => '',
            'helpText' => '',
            'errorMessage' => '',
            'rules' => '',
            'iconName' => '',
            'iconPosition' => 'left',
        ];
    }

    public function variants(): array
    {
        return [
            'basic text' => [
                'type' => 'text',
                'label' => 'Nom',
                'placeholder' => 'Votre nom complet',
                'color' => 'indigo',
                'helpText' => 'Saisissez votre nom et prénom',
            ],
            'search with icon' => [
                'type' => 'search',
                'label' => 'Rechercher',
                'placeholder' => 'Rechercher...',
                'iconName' => 'magnifying-glass',
                'helpText' => 'Icône de recherche intégrée',
            ],
            'right icon' => [
                'type' => 'number',
                'label' => 'Montant',
                'placeholder' => '0.00',
                'iconName' => 'calculator',
                'iconPosition' => 'right',
                'color' => 'green',
                'helpText' => 'Icône positionnée à droite',
            ],
            'email with validation' => [
                'type' => 'email',
                'label' => 'Adresse email',
                'placeholder' => 'exemple@email.com',
                'rules' => 'required|email',
                'color' => 'blue',
                'helpText' => 'Nous utiliserons cet email pour vous contacter',
                'required' => true,
            ],
            'password secure' => [
                'type' => 'password',
                'label' => 'Mot de passe',
                'placeholder' => '••••••••',
                'rules' => 'required|min_length:8',
                'color' => 'purple',
                'helpText' => 'Au moins 8 caractères requis',
                'required' => true,
            ],
            'number with constraints' => [
                'type' => 'number',
                'label' => 'Âge',
                'placeholder' => '0',
                'rules' => 'required|integer|min:1|max:120',
                'color' => 'green',
                'helpText' => 'Entre 1 et 120 ans',
                'required' => true,
            ],
            'url validation' => [
                'type' => 'url',
                'label' => 'Site web',
                'placeholder' => 'https://exemple.com',
                'rules' => 'url',
                'color' => 'yellow',
                'helpText' => 'URL complète avec protocole (optionnel)',
            ],
            'phone number' => [
                'type' => 'tel',
                'label' => 'Téléphone',
                'placeholder' => '+33 1 23 45 67 89',
                'rules' => 'phone',
                'color' => 'slate',
                'helpText' => 'Format international recommandé',
            ],
            'search field' => [
                'type' => 'search',
                'label' => 'Rechercher',
                'placeholder' => 'Saisissez votre recherche...',
                'color' => 'blue',
                'size' => 'large',
                'helpText' => 'Utilisez des mots-clés pour affiner votre recherche',
            ],
            'date picker' => [
                'type' => 'date',
                'label' => 'Date de naissance',
                'rules' => 'required|date|date_before:today',
                'color' => 'green',
                'helpText' => 'Sélectionnez votre date de naissance',
                'required' => true,
            ],
            'time picker' => [
                'type' => 'time',
                'label' => 'Heure de rendez-vous',
                'rules' => 'required|time',
                'color' => 'indigo',
                'helpText' => 'Format 24h (ex: 14:30)',
                'required' => true,
            ],
            'with error state' => [
                'type' => 'email',
                'label' => 'Email avec erreur',
                'value' => 'email-invalide',
                'rules' => 'required|email',
                'errorMessage' => 'Le format de l\'email est invalide',
                'color' => 'red',
                'helpText' => 'Corrigez le format de l\'adresse email',
            ],
            'small size' => [
                'type' => 'text',
                'label' => 'Code postal',
                'placeholder' => '75001',
                'size' => 'small',
                'rules' => 'required|length:5',
                'color' => 'slate',
                'helpText' => 'Exactement 5 chiffres',
            ],
            'large size' => [
                'type' => 'text',
                'label' => 'Titre principal',
                'placeholder' => 'Un titre accrocheur...',
                'size' => 'large',
                'color' => 'purple',
                'helpText' => 'Titre principal de votre contenu',
            ],
            'full width' => [
                'type' => 'text',
                'label' => 'Adresse complète',
                'placeholder' => '123 Rue de la Paix, 75001 Paris',
                'block' => true,
                'color' => 'green',
                'helpText' => 'Adresse complète avec code postal et ville',
            ],
            'disabled state' => [
                'type' => 'text',
                'label' => 'Champ désactivé',
                'value' => 'Valeur non modifiable',
                'disabled' => true,
                'helpText' => 'Ce champ ne peut pas être modifié',
            ],
            'readonly state' => [
                'type' => 'text',
                'label' => 'Identifiant unique',
                'value' => 'USR-2024-001234',
                'readonly' => true,
                'color' => 'slate',
                'helpText' => 'Identifiant généré automatiquement',
            ],
            'required field' => [
                'type' => 'text',
                'label' => 'Nom d\'entreprise',
                'placeholder' => 'Votre entreprise',
                'required' => true,
                'rules' => 'required|min_length:2',
                'color' => 'red',
                'helpText' => 'Ce champ est obligatoire',
            ],
            'with custom validation' => [
                'type' => 'text',
                'label' => 'Code produit',
                'placeholder' => 'PRD-XXXX-YYYY',
                'rules' => 'required|regex:/^PRD-[A-Z]{4}-[0-9]{4}$/',
                'color' => 'yellow',
                'helpText' => 'Format: PRD-ABCD-1234',
            ],
        ];
    }
}

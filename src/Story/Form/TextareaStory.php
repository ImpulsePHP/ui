<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Form;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Form\UITextareaComponent;

final class TextareaStory extends AbstractStory
{
    protected string $category = 'Form';

    public function name(): string
    {
        return 'Textarea';
    }

    public function description(): string
    {
        return 'Composant textarea avec validation intégrée et gestion d\'état avancée';
    }

    public function componentClass(): string
    {
        return UITextareaComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'label' => '',
            'placeholder' => '',
            'value' => '',
            'name' => uniqid('textarea'),
            'id' => '',
            'color' => 'indigo',
            'size' => 'normal',
            'rows' => 4,
            'helpText' => '',
            'errorMessage' => '',
            'block' => false,
            'disabled' => false,
            'required' => false,
            'readonly' => false,
            'maxLength' => null,
            'countLength' => 'count',
            'iconName' => '',
            'iconPosition' => 'left',
            'rules' => '',
        ];
    }

    public function variants(): array
    {
        return [
            'basic text' => [
                'label' => 'Description',
                'placeholder' => 'Décrivez votre projet en quelques mots...',
                'color' => 'indigo',
                'helpText' => 'Apprenons-en plus sur votre projet',
            ],
            'with character count' => [
                'label' => 'Message avec limite',
                'placeholder' => 'Tapez votre message...',
                'maxLength' => 150,
                'countLength' => 'count',
                'helpText' => 'Maximum 150 caractères',
                'rules' => 'max:150',
            ],
            'with countdown' => [
                'label' => 'Tweet',
                'placeholder' => 'Quoi de neuf ?',
                'maxLength' => 280,
                'countLength' => 'countdown',
                'helpText' => 'Partagez vos pensées',
                'rules' => 'max:280',
            ],
            'required field' => [
                'label' => 'Commentaire obligatoire',
                'placeholder' => 'Votre commentaire est requis...',
                'required' => true,
                'color' => 'blue',
                'helpText' => 'Ce champ est obligatoire',
                'rules' => 'required|min:10',
                'rows' => 5,
            ],
            'with error state' => [
                'label' => 'Message avec erreur',
                'placeholder' => 'Tapez un message plus long...',
                'value' => 'Court',
                'errorMessage' => 'Le message doit contenir au moins 20 caractères',
                'color' => 'red',
                'rules' => 'min:20',
                'rows' => 3,
            ],
            'with icon left' => [
                'label' => 'Retour d\'expérience',
                'placeholder' => 'Partagez votre expérience...',
                'iconName' => 'chat-bubble-left',
                'iconPosition' => 'left',
                'color' => 'green',
                'helpText' => 'Avec icône de commentaire',
                'rows' => 6,
            ],
            'with icon right' => [
                'label' => 'Notes privées',
                'placeholder' => 'Vos notes personnelles...',
                'iconName' => 'pencil-square',
                'iconPosition' => 'right',
                'color' => 'purple',
                'helpText' => 'Icône positionnée à droite',
                'rows' => 4,
            ],
            'small size' => [
                'label' => 'Note rapide',
                'placeholder' => 'Une note courte...',
                'size' => 'small',
                'color' => 'slate',
                'rows' => 2,
                'helpText' => 'Format compact pour notes rapides',
            ],
            'large size' => [
                'label' => 'Article de blog',
                'placeholder' => 'Rédigez votre article...',
                'size' => 'large',
                'color' => 'indigo',
                'rows' => 8,
                'helpText' => 'Format étendu pour contenu long',
            ],
            'readonly with content' => [
                'label' => 'Contenu en lecture seule',
                'value' => 'Ce contenu ne peut pas être modifié. Il s\'agit d\'un exemple de textarea en mode lecture seule avec du contenu pré-rempli.',
                'readonly' => true,
                'color' => 'slate',
                'rows' => 4,
                'helpText' => 'Contenu non modifiable',
            ],
            'disabled state' => [
                'label' => 'Champ désactivé',
                'placeholder' => 'Ce champ est désactivé...',
                'disabled' => true,
                'color' => 'slate',
                'helpText' => 'Temporairement indisponible',
                'rows' => 3,
            ],
            'feedback form' => [
                'label' => 'Votre avis nous intéresse',
                'placeholder' => 'Dites-nous ce que vous pensez de notre service...',
                'iconName' => 'star',
                'iconPosition' => 'left',
                'color' => 'yellow',
                'required' => true,
                'rows' => 6,
                'maxLength' => 500,
                'countLength' => 'countdown',
                'helpText' => 'Votre retour est précieux pour nous améliorer',
                'rules' => 'required|min:30|max:500',
            ],
            'support ticket' => [
                'label' => 'Description du problème',
                'placeholder' => 'Décrivez en détail le problème rencontré...',
                'iconName' => 'exclamation-triangle',
                'iconPosition' => 'left',
                'color' => 'red',
                'required' => true,
                'rows' => 8,
                'maxLength' => 1000,
                'countLength' => 'count',
                'helpText' => 'Plus vous êtes précis, plus nous pourrons vous aider rapidement',
                'rules' => 'required|min:50|max:1000',
            ],
            'newsletter content' => [
                'label' => 'Contenu de la newsletter',
                'placeholder' => 'Rédigez le contenu de votre newsletter...',
                'iconName' => 'envelope',
                'iconPosition' => 'left',
                'color' => 'blue',
                'rows' => 12,
                'maxLength' => 2000,
                'countLength' => 'countdown',
                'helpText' => 'Rédigez un contenu engageant pour vos abonnés',
                'rules' => 'max:2000',
                'block' => true,
            ],
            'social media post' => [
                'label' => 'Publication LinkedIn',
                'placeholder' => 'Partagez une réflexion professionnelle...',
                'iconName' => 'share',
                'iconPosition' => 'right',
                'color' => 'blue',
                'rows' => 5,
                'maxLength' => 3000,
                'countLength' => 'countdown',
                'helpText' => 'Optimisé pour les réseaux sociaux professionnels',
                'rules' => 'max:3000',
            ]
        ];
    }
}

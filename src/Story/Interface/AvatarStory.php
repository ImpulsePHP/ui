<?php

declare(strict_types=1);

namespace Impulse\UI\Story\Interface;

use Impulse\Story\Component\AbstractStory;
use Impulse\UI\Component\Interface\UIAvatarComponent;
use Impulse\UI\Trait\UIComponentTrait;

final class AvatarStory extends AbstractStory
{
    use UIComponentTrait;

    protected string $category = 'Interface';

    public function name(): string
    {
        return 'Avatar';
    }

    public function description(): string
    {
        return 'Composant Avatar pour afficher des images de profil ou des initiales avec différentes formes, tailles et indicateurs de statut';
    }

    public function componentClass(): string
    {
        return UIAvatarComponent::class;
    }

    protected function getBaseArgs(): array
    {
        return [
            'src' => '',
            'alt' => '',
            'initials' => '',
            'name' => '',
            'size' => 'normal',
            'shape' => 'circle',
            'color' => 'indigo',
            'variant' => 'filled',
            'border' => false,
            'status' => '',
            'notification' => '',
            'clickable' => false,
        ];
    }

    public function variants(): array
    {
        return [
            'image avatar' => [
                'src' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
                'name' => 'John Doe',
                'alt' => 'Photo de profil de John Doe',
                'size' => 'normal',
                'shape' => 'circle',
            ],
            'image with status' => [
                'src' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
                'name' => 'Jane Smith',
                'alt' => 'Photo de profil de Jane Smith',
                'size' => 'large',
                'shape' => 'circle',
                'status' => 'online',
                'border' => true,
            ],
            'image with notification' => [
                'src' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
                'name' => 'Mike Johnson',
                'alt' => 'Photo de profil de Mike Johnson',
                'size' => 'large',
                'shape' => 'rounded',
                'notification' => '3',
            ],
            'clickable avatar' => [
                'src' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
                'name' => 'Sarah Wilson',
                'alt' => 'Photo de profil de Sarah Wilson',
                'size' => 'normal',
                'shape' => 'circle',
                'clickable' => true,
                'status' => 'away',
            ],
            'initials basic' => [
                'name' => 'Alexandre Dupont',
                'color' => 'blue',
                'variant' => 'filled',
                'size' => 'normal',
                'shape' => 'circle',
            ],
            'custom initials' => [
                'initials' => 'JD',
                'color' => 'green',
                'variant' => 'soft',
                'size' => 'large',
                'shape' => 'rounded',
            ],
            'single name' => [
                'name' => 'Utilisateur',
                'color' => 'purple',
                'variant' => 'outline',
                'size' => 'normal',
                'shape' => 'circle',
            ],
            'tiny avatar' => [
                'name' => 'Petit Avatar',
                'size' => 'tiny',
                'color' => 'red',
                'shape' => 'circle',
            ],
            'small avatar' => [
                'name' => 'Avatar Petit',
                'size' => 'small',
                'color' => 'orange',
                'shape' => 'circle',
                'status' => 'online',
            ],
            'normal avatar' => [
                'name' => 'Avatar Normal',
                'size' => 'normal',
                'color' => 'yellow',
                'shape' => 'circle',
                'notification' => '5',
            ],
            'large avatar' => [
                'name' => 'Avatar Grand',
                'size' => 'large',
                'color' => 'green',
                'shape' => 'circle',
                'status' => 'busy',
                'border' => true,
            ],
            'huge avatar' => [
                'name' => 'Avatar Énorme',
                'size' => 'huge',
                'color' => 'blue',
                'shape' => 'circle',
                'variant' => 'soft',
            ],
            'circle shape' => [
                'name' => 'Avatar Rond',
                'shape' => 'circle',
                'color' => 'indigo',
                'size' => 'large',
            ],
            'rounded shape' => [
                'name' => 'Avatar Arrondi',
                'shape' => 'rounded',
                'color' => 'purple',
                'size' => 'large',
                'variant' => 'soft',
            ],
            'square shape' => [
                'name' => 'Avatar Carré',
                'shape' => 'square',
                'color' => 'pink',
                'size' => 'large',
                'variant' => 'outline',
            ],
            'filled variant' => [
                'name' => 'Avatar Rempli',
                'variant' => 'filled',
                'color' => 'blue',
                'size' => 'large',
            ],
            'soft variant' => [
                'name' => 'Avatar Doux',
                'variant' => 'soft',
                'color' => 'green',
                'size' => 'large',
            ],
            'outline variant' => [
                'name' => 'Avatar Contour',
                'variant' => 'outline',
                'color' => 'red',
                'size' => 'large',
            ],
            'online status' => [
                'name' => 'En Ligne',
                'status' => 'online',
                'color' => 'green',
                'size' => 'large',
                'shape' => 'circle',
            ],
            'offline status' => [
                'name' => 'Hors Ligne',
                'status' => 'offline',
                'color' => 'gray',
                'size' => 'large',
                'shape' => 'circle',
            ],
            'busy status' => [
                'name' => 'Occupé',
                'status' => 'busy',
                'color' => 'red',
                'size' => 'large',
                'shape' => 'circle',
            ],
            'away status' => [
                'name' => 'Absent',
                'status' => 'away',
                'color' => 'yellow',
                'size' => 'large',
                'shape' => 'circle',
            ],
            'single notification' => [
                'name' => 'Une Notification',
                'notification' => '1',
                'color' => 'blue',
                'size' => 'large',
            ],
            'multiple notifications' => [
                'name' => 'Plusieurs Notifications',
                'notification' => '9',
                'color' => 'green',
                'size' => 'large',
            ],
            'high notifications' => [
                'name' => 'Beaucoup de Notifications',
                'notification' => '99+',
                'color' => 'purple',
                'size' => 'large',
            ],
            'complete avatar' => [
                'src' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&h=150&fit=crop&crop=face',
                'name' => 'Utilisateur Complet',
                'alt' => 'Avatar avec toutes les options',
                'size' => 'large',
                'shape' => 'circle',
                'status' => 'online',
                'notification' => '3',
                'border' => true,
                'clickable' => true,
            ],
            'team leader' => [
                'name' => 'Chef Équipe',
                'color' => 'purple',
                'variant' => 'filled',
                'size' => 'large',
                'shape' => 'rounded',
                'status' => 'online',
                'border' => true,
            ],
            'admin user' => [
                'initials' => 'AD',
                'color' => 'red',
                'variant' => 'solid',
                'size' => 'normal',
                'shape' => 'square',
                'notification' => '!',
                'clickable' => true,
            ],
            'slate color' => [
                'name' => 'Couleur Slate',
                'color' => 'slate',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'gray color' => [
                'name' => 'Couleur Gray',
                'color' => 'gray',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'zinc color' => [
                'name' => 'Couleur Zinc',
                'color' => 'zinc',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'red color' => [
                'name' => 'Couleur Rouge',
                'color' => 'red',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'orange color' => [
                'name' => 'Couleur Orange',
                'color' => 'orange',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'amber color' => [
                'name' => 'Couleur Ambre',
                'color' => 'amber',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'yellow color' => [
                'name' => 'Couleur Jaune',
                'color' => 'yellow',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'lime color' => [
                'name' => 'Couleur Lime',
                'color' => 'lime',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'green color' => [
                'name' => 'Couleur Verte',
                'color' => 'green',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'emerald color' => [
                'name' => 'Couleur Émeraude',
                'color' => 'emerald',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'teal color' => [
                'name' => 'Couleur Teal',
                'color' => 'teal',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'cyan color' => [
                'name' => 'Couleur Cyan',
                'color' => 'cyan',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'sky color' => [
                'name' => 'Couleur Ciel',
                'color' => 'sky',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'blue color' => [
                'name' => 'Couleur Bleue',
                'color' => 'blue',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'indigo color' => [
                'name' => 'Couleur Indigo',
                'color' => 'indigo',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'violet color' => [
                'name' => 'Couleur Violette',
                'color' => 'violet',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'purple color' => [
                'name' => 'Couleur Pourpre',
                'color' => 'purple',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'fuchsia color' => [
                'name' => 'Couleur Fuchsia',
                'color' => 'fuchsia',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'pink color' => [
                'name' => 'Couleur Rose',
                'color' => 'pink',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'rose color' => [
                'name' => 'Couleur Rose',
                'color' => 'rose',
                'variant' => 'filled',
                'size' => 'normal',
            ],
            'user profile' => [
                'src' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&h=150&fit=crop&crop=face',
                'name' => 'Marie Dubois',
                'alt' => 'Profil utilisateur',
                'size' => 'large',
                'shape' => 'circle',
                'status' => 'online',
                'clickable' => true,
                'border' => true,
            ],
            'chat participant' => [
                'name' => 'Participant Chat',
                'size' => 'small',
                'color' => 'blue',
                'shape' => 'circle',
                'status' => 'online',
            ],
            'notification sender' => [
                'initials' => 'SY',
                'size' => 'tiny',
                'color' => 'green',
                'shape' => 'circle',
                'notification' => '2',
            ],
            'team member card' => [
                'src' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=150&h=150&fit=crop&crop=face',
                'name' => 'Thomas Martin',
                'alt' => 'Membre de l\'équipe',
                'size' => 'huge',
                'shape' => 'rounded',
                'status' => 'busy',
                'border' => true,
            ],
            'guest user' => [
                'name' => 'Invité',
                'color' => 'gray',
                'variant' => 'outline',
                'size' => 'normal',
                'shape' => 'circle',
                'status' => 'offline',
            ],
            'premium user' => [
                'name' => 'Utilisateur Premium',
                'color' => 'yellow',
                'variant' => 'filled',
                'size' => 'large',
                'shape' => 'circle',
                'border' => true,
                'notification' => '★',
            ],
        ];
    }
}

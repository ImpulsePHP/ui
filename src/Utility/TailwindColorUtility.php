<?php

declare(strict_types=1);

namespace Impulse\UI\Utility;

/**
 * Utilitaire pour centraliser la gestion des couleurs Tailwind CSS
 *
 * IMPORTANT: Toutes les classes sont explicitement déclarées pour garantir
 * leur compilation par Tailwind CSS - NE PAS SUPPRIMER LES COMMENTAIRES !
 *
 * Classes de badge (bg-100 + text-800 + border-200):
 * bg-slate-100 text-slate-800 border-slate-200 bg-gray-100 text-gray-800 border-gray-200
 * bg-zinc-100 text-zinc-800 border-zinc-200 bg-neutral-100 text-neutral-800 border-neutral-200
 * bg-stone-100 text-stone-800 border-stone-200 bg-red-100 text-red-800 border-red-200
 * bg-orange-100 text-orange-800 border-orange-200 bg-amber-100 text-amber-800 border-amber-200
 * bg-yellow-100 text-yellow-800 border-yellow-200 bg-lime-100 text-lime-800 border-lime-200
 * bg-green-100 text-green-800 border-green-200 bg-emerald-100 text-emerald-800 border-emerald-200
 * bg-teal-100 text-teal-800 border-teal-200 bg-cyan-100 text-cyan-800 border-cyan-200
 * bg-sky-100 text-sky-800 border-sky-200 bg-blue-100 text-blue-800 border-blue-200
 * bg-indigo-100 text-indigo-800 border-indigo-200 bg-violet-100 text-violet-800 border-violet-200
 * bg-purple-100 text-purple-800 border-purple-200 bg-fuchsia-100 text-fuchsia-800 border-fuchsia-200
 * bg-pink-100 text-pink-800 border-pink-200 bg-rose-100 text-rose-800 border-rose-200
 *
 * Classes d'état actif (bordure + ring):
 * border-slate-400 ring-1 ring-slate-400 border-gray-400 ring-1 ring-gray-400
 * border-zinc-400 ring-1 ring-zinc-400 border-neutral-400 ring-1 ring-neutral-400
 * border-stone-400 ring-1 ring-stone-400 border-red-400 ring-1 ring-red-400
 * border-orange-400 ring-1 ring-orange-400 border-amber-400 ring-1 ring-amber-400
 * border-yellow-400 ring-1 ring-yellow-400 border-lime-400 ring-1 ring-lime-400
 * border-green-400 ring-1 ring-green-400 border-emerald-400 ring-1 ring-emerald-400
 * border-teal-400 ring-1 ring-teal-400 border-cyan-400 ring-1 ring-cyan-400
 * border-sky-400 ring-1 ring-sky-400 border-blue-400 ring-1 ring-blue-400
 * border-indigo-400 ring-1 ring-indigo-400 border-violet-400 ring-1 ring-violet-400
 * border-purple-400 ring-1 ring-purple-400 border-fuchsia-400 ring-1 ring-fuchsia-400
 * border-pink-400 ring-1 ring-pink-400 border-rose-400 ring-1 ring-rose-400
 *
 * Classes de focus:
 * focus:border-slate-400 focus:ring-slate-400 focus:border-gray-400 focus:ring-gray-400
 * focus:border-zinc-400 focus:ring-zinc-400 focus:border-neutral-400 focus:ring-neutral-400
 * focus:border-stone-400 focus:ring-stone-400 focus:border-red-400 focus:ring-red-400
 * focus:border-orange-400 focus:ring-orange-400 focus:border-amber-400 focus:ring-amber-400
 * focus:border-yellow-400 focus:ring-yellow-400 focus:border-lime-400 focus:ring-lime-400
 * focus:border-green-400 focus:ring-green-400 focus:border-emerald-400 focus:ring-emerald-400
 * focus:border-teal-400 focus:ring-teal-400 focus:border-cyan-400 focus:ring-cyan-400
 * focus:border-sky-400 focus:ring-sky-400 focus:border-blue-400 focus:ring-blue-400
 * focus:border-indigo-400 focus:ring-indigo-400 focus:border-violet-400 focus:ring-violet-400
 * focus:border-purple-400 focus:ring-purple-400 focus:border-fuchsia-400 focus:ring-fuchsia-400
 * focus:border-pink-400 focus:ring-pink-400 focus:border-rose-400 focus:ring-rose-400
 *
 * Classes de bordure:
 * border-slate-300 border-gray-300 border-zinc-300 border-neutral-300 border-stone-300
 * border-red-300 border-orange-300 border-amber-300 border-yellow-300 border-lime-300
 * border-green-300 border-emerald-300 border-teal-300 border-cyan-300 border-sky-300
 * border-blue-300 border-indigo-300 border-violet-300 border-purple-300 border-fuchsia-300
 * border-pink-300 border-rose-300
 *
 * Classes de background:
 * bg-slate-50 bg-slate-100 bg-slate-500 bg-slate-600 bg-gray-50 bg-gray-100 bg-gray-500 bg-gray-600
 * bg-zinc-50 bg-zinc-100 bg-zinc-500 bg-zinc-600 bg-neutral-50 bg-neutral-100 bg-neutral-500 bg-neutral-600
 * bg-stone-50 bg-stone-100 bg-stone-500 bg-stone-600 bg-red-50 bg-red-100 bg-red-500 bg-red-600
 * bg-orange-50 bg-orange-100 bg-orange-500 bg-orange-600 bg-amber-50 bg-amber-100 bg-amber-500 bg-amber-600
 * bg-yellow-50 bg-yellow-100 bg-yellow-500 bg-yellow-600 bg-lime-50 bg-lime-100 bg-lime-500 bg-lime-600
 * bg-green-50 bg-green-100 bg-green-500 bg-green-600 bg-emerald-50 bg-emerald-100 bg-emerald-500 bg-emerald-600
 * bg-teal-50 bg-teal-100 bg-teal-500 bg-teal-600 bg-cyan-50 bg-cyan-100 bg-cyan-500 bg-cyan-600
 * bg-sky-50 bg-sky-100 bg-sky-500 bg-sky-600 bg-blue-50 bg-blue-100 bg-blue-500 bg-blue-600
 * bg-indigo-50 bg-indigo-100 bg-indigo-500 bg-indigo-600 bg-violet-50 bg-violet-100 bg-violet-500 bg-violet-600
 * bg-purple-50 bg-purple-100 bg-purple-500 bg-purple-600 bg-fuchsia-50 bg-fuchsia-100 bg-fuchsia-500 bg-fuchsia-600
 * bg-pink-50 bg-pink-100 bg-pink-500 bg-pink-600 bg-rose-50 bg-rose-100 bg-rose-500 bg-rose-600
 *
 * Classes de texte:
 * text-slate-600 text-slate-700 text-slate-800 text-gray-600 text-gray-700 text-gray-800
 * text-zinc-600 text-zinc-700 text-zinc-800 text-neutral-600 text-neutral-700 text-neutral-800
 * text-stone-600 text-stone-700 text-stone-800 text-red-600 text-red-700 text-red-800
 * text-orange-600 text-orange-700 text-orange-800 text-amber-600 text-amber-700 text-amber-800
 * text-yellow-600 text-yellow-700 text-yellow-800 text-lime-600 text-lime-700 text-lime-800
 * text-green-600 text-green-700 text-green-800 text-emerald-600 text-emerald-700 text-emerald-800
 * text-teal-600 text-teal-700 text-teal-800 text-cyan-600 text-cyan-700 text-cyan-800
 * text-sky-600 text-sky-700 text-sky-800 text-blue-600 text-blue-700 text-blue-800
 * text-indigo-600 text-indigo-700 text-indigo-800 text-violet-600 text-violet-700 text-violet-800
 * text-purple-600 text-purple-700 text-purple-800 text-fuchsia-600 text-fuchsia-700 text-fuchsia-800
 * text-pink-600 text-pink-700 text-pink-800 text-rose-600 text-rose-700 text-rose-800
 *
 * Classes de hover:
 * hover:bg-slate-100 hover:bg-gray-100 hover:bg-zinc-100 hover:bg-neutral-100 hover:bg-stone-100
 * hover:bg-red-100 hover:bg-orange-100 hover:bg-amber-100 hover:bg-yellow-100 hover:bg-lime-100
 * hover:bg-green-100 hover:bg-emerald-100 hover:bg-teal-100 hover:bg-cyan-100 hover:bg-sky-100
 * hover:bg-blue-100 hover:bg-indigo-100 hover:bg-violet-100 hover:bg-purple-100 hover:bg-fuchsia-100
 * hover:bg-pink-100 hover:bg-rose-100 hover:bg-slate-600 hover:bg-gray-600 hover:bg-zinc-600
 * hover:bg-neutral-600 hover:bg-stone-600 hover:bg-red-600 hover:bg-orange-600 hover:bg-amber-600
 * hover:bg-yellow-600 hover:bg-lime-600 hover:bg-green-600 hover:bg-emerald-600 hover:bg-teal-600
 * hover:bg-cyan-600 hover:bg-sky-600 hover:bg-blue-600 hover:bg-indigo-600 hover:bg-violet-600
 * hover:bg-purple-600 hover:bg-fuchsia-600 hover:bg-pink-600 hover:bg-rose-600
 *
 * Classes d'accent:
 * accent-slate-500 accent-gray-500 accent-zinc-500 accent-neutral-500 accent-stone-500
 * accent-red-500 accent-orange-500 accent-amber-600 accent-yellow-600 accent-lime-600
 * accent-green-600 accent-emerald-500 accent-teal-500 accent-cyan-600 accent-sky-500
 * accent-blue-500 accent-indigo-500 accent-violet-500 accent-purple-500 accent-fuchsia-500
 * accent-pink-500 accent-rose-500
 *
 * Classes de switch actif:
 * checked:bg-slate-400 checked:bg-gray-400 checked:bg-zinc-400 checked:bg-neutral-400 checked:bg-stone-400
 * checked:bg-red-400 checked:bg-orange-400 checked:bg-amber-400 checked:bg-yellow-400 checked:bg-lime-400
 * checked:bg-green-400 checked:bg-emerald-400 checked:bg-teal-400 checked:bg-cyan-400 checked:bg-sky-400
 * checked:bg-blue-400 checked:bg-indigo-400 checked:bg-violet-400 checked:bg-purple-400 checked:bg-fuchsia-400
 * checked:bg-pink-400 checked:bg-rose-400
 *
 * Classes de switch bordure:
 * peer-checked:border-slate-800 peer-checked:border-gray-800 peer-checked:border-zinc-800 peer-checked:border-neutral-800 peer-checked:border-stone-800
 * peer-checked:border-red-600 peer-checked:border-orange-600 peer-checked:border-amber-600 peer-checked:border-yellow-600 peer-checked:border-lime-600
 * peer-checked:border-green-600 peer-checked:border-emerald-600 peer-checked:border-teal-600 peer-checked:border-cyan-600 peer-checked:border-sky-600
 * peer-checked:border-blue-600 peer-checked:border-indigo-600 peer-checked:border-violet-600 peer-checked:border-purple-600 peer-checked:border-fuchsia-600
 * peer-checked:border-pink-600 peer-checked:border-rose-600
 *
 * Classes de texte intermédiaire:
 * text-slate-500 text-gray-500 text-zinc-500 text-neutral-500 text-stone-500
 * text-red-500 text-orange-500 text-amber-500 text-yellow-500 text-lime-500
 * text-green-500 text-emerald-500 text-teal-500 text-cyan-500 text-sky-500
 * text-blue-500 text-indigo-500 text-violet-500 text-purple-500 text-fuchsia-500
 * text-pink-500 text-rose-500
 *
 * Classes de remplissage d'icône:
 * fill-slate-400 fill-gray-400 fill-zinc-400 fill-neutral-400 fill-stone-400
 * fill-red-400 fill-orange-400 fill-amber-400 fill-yellow-400 fill-lime-400
 * fill-green-400 fill-emerald-400 fill-teal-400 fill-cyan-400 fill-sky-400
 * fill-blue-400 fill-indigo-400 fill-violet-400 fill-purple-400 fill-fuchsia-400
 * fill-pink-400 fill-rose-400
 *
 *  Classes pour les tabs
 *  text-slate-600 border-slate-600 bg-slate-600 bg-slate-50 border-slate-200
 *  text-gray-600 border-gray-600 bg-gray-600 bg-gray-50 border-gray-200
 *  text-zinc-600 border-zinc-600 bg-zinc-600 bg-zinc-50 border-zinc-200
 *  text-neutral-600 border-neutral-600 bg-neutral-600 bg-neutral-50 border-neutral-200
 *  text-stone-600 border-stone-600 bg-stone-600 bg-stone-50 border-stone-200
 *  text-red-600 border-red-600 bg-red-600 bg-red-50 border-red-200
 *  text-orange-600 border-orange-600 bg-orange-600 bg-orange-50 border-orange-200
 *  text-amber-600 border-amber-600 bg-amber-600 bg-amber-50 border-amber-200
 *  text-yellow-600 border-yellow-600 bg-yellow-600 bg-yellow-50 border-yellow-200
 *  text-lime-600 border-lime-600 bg-lime-600 bg-lime-50 border-lime-200
 *  text-green-600 border-green-600 bg-green-600 bg-green-50 border-green-200
 *  text-emerald-600 border-emerald-600 bg-emerald-600 bg-emerald-50 border-emerald-200
 *  text-teal-600 border-teal-600 bg-teal-600 bg-teal-50 border-teal-200
 *  text-cyan-600 border-cyan-600 bg-cyan-600 bg-cyan-50 border-cyan-200
 *  text-sky-600 border-sky-600 bg-sky-600 bg-sky-50 border-sky-200
 *  text-blue-600 border-blue-600 bg-blue-600 bg-blue-50 border-blue-200
 *  text-indigo-600 border-indigo-600 bg-indigo-600 bg-indigo-50 border-indigo-200
 *  text-violet-600 border-violet-600 bg-violet-600 bg-violet-50 border-violet-200
 *  text-purple-600 border-purple-600 bg-purple-600 bg-purple-50 border-purple-200
 *  text-fuchsia-600 border-fuchsia-600 bg-fuchsia-600 bg-fuchsia-50 border-fuchsia-200
 *  text-pink-600 border-pink-600 bg-pink-600 bg-pink-50 border-pink-200
 *  text-rose-600 border-rose-600 bg-rose-600 bg-rose-50 border-rose-200
 */
final class TailwindColorUtility
{
    /** @var string[] */
    public const COLORS = [
        'slate', 'gray', 'zinc', 'neutral', 'stone',
        'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan',
        'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'
    ];

    private const ACCENT_600 = ['amber', 'yellow', 'lime', 'green', 'cyan'];

    public static function getToastBackgroundClasses(string $color = 'blue'): string
    {
        return "bg-$color-50 border-$color-200";
    }

    public static function getToastTextClasses(string $color = 'blue'): string
    {
        return "text-$color-800";
    }

    public static function getToastIconClasses(string $color = 'blue'): string
    {
        return "text-$color-600";
    }

    public static function getToastProgressClasses(string $color = 'blue'): string
    {
        return "bg-$color-600";
    }

    public static function getToastDefaultIcon(string $color = 'blue'): string
    {
        return match ($color) {
            'green' => 'check-circle',
            'red' => 'x-circle',
            'yellow', 'amber', 'orange' => 'exclamation-triangle',
            default => 'information-circle',
        };
    }

    public static function getTabActiveClasses(string $color = 'indigo', string $variant = 'underline'): string
    {
        return match ($variant) {
            'pills' => "bg-$color-600 text-white",
            'bordered' => "bg-$color-50 text-$color-600 border border-$color-200",
            default => "text-$color-600 border-$color-600",
        };
    }

    public static function getFocusRingClasses(string $color = 'indigo'): string
    {
        return "border-$color-300";
    }

    public static function getCheckboxRadioColorClasses(string $color = 'slate'): string
    {
        $shade = in_array($color, self::ACCENT_600, true) ? '600' : '500';
        return "accent-$color-$shade";
    }

    public static function getToggleActiveClasses(string $color): string
    {
        return "checked:bg-$color-400";
    }

    public static function getToggleBorderClasses(string $color): string
    {
        return "peer-checked:border-$color-400";
    }

    public static function getEmptyStateIconClasses(string $color): string
    {
        return "bg-$color-100";
    }

    public static function getEmptyStateIconColorClasses(string $color): string
    {
        return "text-$color-600";
    }

    public static function getFocusClasses(string $color, bool $hasError = false): string
    {
        if ($hasError) {
            return 'focus:border-red-400 focus:ring-red-400';
        }

        return "focus:border-$color-400 focus:ring-$color-400";
    }

    public static function getActiveBorderColor(string $color = 'slate', bool $hasError = false): string
    {
        if ($hasError) {
            return 'border-red-400 ring-1 ring-red-400';
        }

        return "border-$color-400 ring-1 ring-$color-400";
    }

    public static function getBorderClasses(string $color = 'slate', bool $hasError = false): string
    {
        if ($hasError) {
            return 'border-red-300';
        }

        return "border-$color-300";
    }

    public static function getBadgeColor(string $color = 'slate'): string
    {
        return "bg-$color-100 text-$color-800 border-$color-200";
    }

    public static function getBadgeOutlineClasses(string $color = 'slate'): string
    {
        return "border border-$color-300 text-$color-700 bg-transparent";
    }

    public static function getBadgeSoftClasses(string $color = 'slate'): string
    {
        return "bg-$color-50 text-$color-700 border border-$color-200";
    }

    public static function getBadgeSolidClasses(string $color = 'slate'): string
    {
        return "bg-$color-600 text-white border border-$color-600";
    }

    public static function getDotClasses(string $color = 'slate'): string
    {
        return "bg-$color-500";
    }

    public static function getAlertIconClasses(string $color = 'blue'): string
    {
        return "fill-$color-400";
    }

    public static function getAlertFilledClasses(string $color = 'blue'): string
    {
        return "bg-$color-50 text-$color-700 border border-$color-200";
    }

    public static function getAlertOutlineClasses(string $color = 'blue'): string
    {
        return "bg-white text-$color-600 border border-$color-200";
    }

    public static function getAlertSolidClasses(string $color = 'blue'): string
    {
        return "bg-$color-500 text-white";
    }

    public static function getButtonClasses(string $color, string $variant = 'filled'): string
    {
        return match ($variant) {
            'solid' => "bg-$color-500 text-white hover:bg-$color-600 border border-transparent",
            'soft' => "bg-$color-50 text-$color-700 hover:bg-$color-100 border border-$color-200",
            'outline' => "bg-transparent text-$color-600 hover:bg-$color-50 hover:text-white border border-$color-300",
            'link' => "bg-transparent text-$color-600 hover:underline hover:underline-offset-2",
            'ghost' => "bg-transparent text-$color-600 hover:bg-$color-50 hover:text-$color-700 border border-transparent",
            default => "bg-$color-50 text-$color-600 hover:bg-$color-100 border border-transparent",
        };
    }

    public static function getAllColors(): array
    {
        return self::COLORS;
    }

    public static function getStateClasses(string $state): string
    {
        return match ($state) {
            'disabled' => 'opacity-50 cursor-not-allowed bg-slate-50',
            'readonly' => 'bg-slate-50 cursor-default',
            'loading' => 'opacity-75 cursor-wait',
            default => '',
        };
    }

    public static function getSizeClasses(string $size, string $component = 'input'): string
    {
        return match ([$component, $size]) {
            ['input', 'small'] => 'text-xs px-2 py-1',
            ['input', 'large'] => 'text-lg px-4 py-3',
            ['button', 'small'] => 'text-xs px-3 py-1',
            ['button', 'large'] => 'text-lg px-6 py-3',
            ['button', 'normal'] => 'text-sm px-4 py-2',
            default => 'text-sm px-3 py-2',
        };
    }
}

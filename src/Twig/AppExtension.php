<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('gender_text', [$this, 'genderText']),
        ];
    }

    public function genderText($gender)
    {
        $genders = [
            0 => 'Male',
            1 => 'Female',
            2 => 'Prefer not to say',
        ];

        return $genders[$gender] ?? 'Unknown';
    }
}

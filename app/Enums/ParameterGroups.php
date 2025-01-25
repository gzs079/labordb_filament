<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ParameterGroups: string implements HasLabel
{
    case Indicator = 'Indikátor';
    case Chemical = 'Kémia';
    case Microbiological = 'Mikrobiológia';
    case MicroscopicBiological = 'Mikroszkópos biológia';
    case Pesticides = 'Peszticidek';
    case Radiological = 'Radiológia';
    case OrganicMicropollutants = 'Szerves mikroszennyezők';
    public function getLabel(): ?string
    {
        return $this->value;
    }

}

 
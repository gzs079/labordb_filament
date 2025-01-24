<?php

namespace App\Enums;

enum ParameterGroups: string
{
    case Indicator = 'Indikátor';
    case Chemical = 'Kémia';
    case Microbiological = 'Mikrobiológia';
    case MicroscopicBiological = 'Mikroszkópos biológia';
    case Pesticides = 'Peszticidek';
    case Radiological = 'Radiológia';
    case OrganicMicropollutants = 'Szerves mikroszennyezők';
}
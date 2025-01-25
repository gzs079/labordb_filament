<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SampleStatuses: string implements HasLabel
{
    case Recorded = "rögzítve";
    case Validated  = "validálva";

    public function getLabel(): ?string
    {
        return $this->value;
    }
}


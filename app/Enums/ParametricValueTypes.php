<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ParametricValueTypes: string implements HasLabel
{
    case LimitValue = "határérték";
    case ParametricValue = "parametrikus érték";

    public function getLabel(): ?string
    {
        return $this->value;
    }
}


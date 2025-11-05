<?php

namespace App\Enum;

enum AdoptionStatus: string
{
    case EN_SOIN = "En soin";
    case RESERVE = "Réservé";
    case A_ADOPTER = "A adopté";
    case ADOPTE = "Adopté";
    case RETIRE = "Retiré";
}

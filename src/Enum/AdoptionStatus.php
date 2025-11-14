<?php

namespace App\Enum;

enum AdoptionStatus: string
{
    case EN_SOIN = "En soin";
    case RESERVE = "Réservé";
    case A_ADOPTER = "A adopter";
    case ADOPTE = "Adopté";
}

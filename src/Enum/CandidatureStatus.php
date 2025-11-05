<?php

namespace App\Enum;

enum CandidatureStatus: string
{
    case EN_ATTENTE = "En attente";
    case ACCEPTEE = "Acceptée";
    case REFUSEE = "Refusée";
}

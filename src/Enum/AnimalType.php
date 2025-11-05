<?php

namespace App\Enum;

enum AnimalType: string
{
    case CHAT = "Chat";
    case CHIEN = "Chien";
    case OISEAU = "Oiseau";
    case AUTRE = "Autre";
}

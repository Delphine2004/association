<?php

namespace App\Enum;

enum AnimalCategory: string
{
    case CHAT = "Chat";
    case CHIEN = "Chien";
    case OISEAU = "Oiseau";
    case AUTRE = "Autre";
}

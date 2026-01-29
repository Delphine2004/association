<?php

namespace App\Enum;

enum AnimalRace: string
{
    // Chats
    case CHAT_EUROPEEN = "Européen";
    case CHAT_SIAMOIS = "Siamois";
    case CHAT_MAINE_COON = "Maine Coon";
    case CHAT_PERSAN = "Persan";
    case CHAT_BENGAL = "Bengal";

        // Chiens
    case CHIEN_LABRADOR = "Labrador";
    case CHIEN_HUSKY = "Husky";
    case CHIEN_ = "Bouledogue Français";
    case CHIEN_CROISE = "Croisé";
    case CHIEN_BEAGLE = "Beagle";

        // Oiseaux
    case OISEAU_PERROQUET = "Perroquet";
    case OISEAU_CANARI = "Canari";
    case OISEAU_PERRUCHE = "Perruche";
    case OISEAU_COLOMBIER = "Colombier";
    case OISEAU_TOURTERELLE = "Tourterelle";

        // Autres
    case AUTRE_LAPIN = "Lapin";
    case AUTRE_HAMSTER = "Hamster";
    case AUTRE_COCHON_DINDE = "Cochon d’Inde";
    case AUTRE_TORTUE = "Tortue";
    case AUTRE_FURET = "Furet";
}

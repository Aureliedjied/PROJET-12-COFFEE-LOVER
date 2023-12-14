<?php

namespace App\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class CustomNamerSoundstrack implements NamerInterface
{
    private $customOption;
    private const MAX_TITLE_LENGTH = 10;

    public function __construct(string $customOption)
    {
        $this->customOption = $customOption;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        // On récupere le titre de la musique
        $title = $object->getTitle();

        // On limite la longueur du titre si besoin :
        $limitedTitle = mb_substr($title, 0, self::MAX_TITLE_LENGTH);

        // Nettoyez le titre avec algo 
        $cleanedTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $limitedTitle);

        // On ajoute au titre sa date + son format ( ici on choisit mp3 )
        return $cleanedTitle . '_' . time() . '_' . uniqid() . '.mp3';
    }
}

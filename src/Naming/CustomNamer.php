<?php

namespace App\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class CustomNamer implements NamerInterface
{
    private $customOption;
    private const MAX_TITLE_LENGTH = 10;

    public function __construct(string $customOption)
    {
        $this->customOption = $customOption;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        // We're taking back the title of the award
        $title = $object->getTitle();

        // Limit the length of the title if necessary :
        $limitedTitle = mb_substr($title, 0, self::MAX_TITLE_LENGTH);

        // Clear the title with algoritm 
        $cleanedTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $limitedTitle);

        // add his date + and his format ( here, we choose png )
        return $cleanedTitle . '.png';
    }
}

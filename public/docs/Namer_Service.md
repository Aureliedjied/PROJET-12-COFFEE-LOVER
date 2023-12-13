# Service Namer pour les Entités Symfony

Ce service Namer est conçu pour générer des noms de fichiers uniques pour les images téléchargées à l'aide de Vich Uploader dans un projet Symfony. Il est utilisé pour éviter les conflits de noms de fichiers lors du téléchargement de plusieurs fichiers. 

DOC : https://github.com/dustin10/VichUploaderBundle/blob/master/docs/file_namer/howto/create_a_custom_file_namer.md

## Installation

1. Copier la classe `CustomNamer` dans le répertoire `src/Naming`, implémenter le NamerInterface :

```php
<?php

namespace App\Naming;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class CustomNamer implements NamerInterface
{
    private $customOption;

    public function __construct(string $customOption)
    {
        $this->customOption = $customOption;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        // Ici, l'algo pour renommer le titre, l'image, modifier son format, limiter sa longueur ...
        // Exemple :
        $cleanedTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $limitedTitle);

        return $cleanedTitle . '_' . time() . '_' . uniqid() ;
    }
}
```

2. Modifier le fichier `services.yaml` dans le répertoire `config` pour inclure la configuration du service ( ici le service doit être public ):

```yaml
App\Naming\CustomNamer:
    public: true
    arguments:
        $customOption: 'rename_picture'
```

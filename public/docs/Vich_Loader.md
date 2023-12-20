# VICH_LOADER

Le bundle VichUploaderBundle offre une intégration simple et flexible avec Symfony pour gérer les téléchargements de fichiers, notamment l'upload et la gestion des images associées à des entités

DOC : https://github.com/dustin10/VichUploaderBundle


## Installation

1. **Installer le bundle via Composer :**

   ```bash
   composer require vich/uploader-bundle

2. **Configurer le bundle si pas fait automatiquement :**
   
    => `config/bundles.php`

    ```bash
   Vich\UploaderBundle\VichUploaderBundle::class => ['all' => true]

3. **Paramétrer le bundle dans `config/packages/vich_uploader.yaml`  :**
   
    ```bash
    vich_uploader:
        mappings:
            reward_images:  # Le nom du mapping, correspond à la propriété dans l'entité Reward
                uri_prefix: /uploads/rewards # Préfixe d'URI pour les images uploadées
                upload_destination: '%kernel.project_dir%/public/uploads/rewards' # Chemin après public/ où seront stockées les images
            # Ajouter d'autres mappings si necessaire
    ```

4. ** Importer L'annotation dans l'entité qui nécéssite l'upload d'image:**  
   
    ```php
    use Doctrine\ORM\Mapping as ORM;
    use Vich\UploaderBundle\Mapping\Annotation as Vich;

    /**
     * @ORM\Entity
     * @Vich\Uploadable
     */
    class Reward
    {
        // ...

        /**
         * @Vich\UploadableField(mapping="reward_images", fileNameProperty="picture") // Relié à la propriété picture
         * @var File|null
         *
         * @Assert\File(
         *     maxSize = "30M",
         *     maxSizeMessage = "Le fichier est trop volumineux. La taille maximale autorisée est {{ limit }}",
         * )
         */
        private $pictureFile;

        //Les setters et getters :

        /**
         * Get the value of pictureFile
         *
         * @return File|null
         */
        public function getPictureFile(): ?File
        {
            return $this->pictureFile;
        }

        /**
         * Set the value of pictureFile
         *
         * @param File|null $pictureFile
         * @return self
         */
        public function setPictureFile(?File $pictureFile): self
        {
            $this->pictureFile = $pictureFile;

            return $this;
        }
    }
    ```

5. ** Importer le namespace dans le formType de l'entité :**  

    ```php

    // Ici on importe la class du bundle 
    use Vich\UploaderBundle\Form\Type\VichImageType;
    
    ->add('pictureFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'image_uri' => true,
        ])
    ```

6. ** Si besoin de boucler, la syntaxe "img src" dans twig/html :** 

    Par exemple, pour l'entité reward, on va boucler sur la propriété PictureFile vu plus haut :
    ```php
    {% for reward in rewards %}
        <img src="{{ vich_uploader_asset(reward, 'PictureFile') }}" alt="Reward Image">
    {% endif %}
    ```
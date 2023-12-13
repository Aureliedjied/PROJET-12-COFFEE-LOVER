
DOC : https://github.com/dustin10/VichUploaderBundle

# Installation et utilisation de VichUploaderBundle pour les téléchargements d'images dans Symfony

## Installation

1. **Installer le bundle via Composer :**

   ```bash
   composer require vich/uploader-bundle

2. **Configurer le bundle si pas fait automatiquement :**
   
    ```bash
   Vich\UploaderBundle\VichUploaderBundle::class => ['all' => true]

3. **Paramétrer le bundle dans `config/packages/vich_uploader.yaml`  :**
   
   ```bash
   vich_uploader:
    mappings:
        reward_image:
            uri_prefix: /uploads/rewards 
            upload_destination: '%kernel.project_dir%/public/uploads/rewards'( chemin aprés public/ ou serotn stockées les images)

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
         * @Vich\UploadableField(mapping="reward_images", fileNameProperty="picture")
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
    use Vich\UploaderBundle\Form\Type\VichImageType;

    <!-- Ici on importe la class du bundle -->
    
    ->add('pictureFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'image_uri' => true,
        ])
    ```

6. ** Si besoin de boucler, la syntaxe "img src" dans twig/html :** 

    Par exemple, pour l'entité reward :
    ```php
    {% if reward.imageName %}
        <img src="{{ vich_uploader_asset(reward, 'PictureFile') }}" alt="Reward Image">
    {% else %}
        <p>Aucune image disponible</p>
    {% endif %}
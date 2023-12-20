# Service Namer pour les Entités Symfony

Le bundle knp_paginator offre une fonctionnalité de pagination puissante dans Symfony, permettant de diviser une liste de résultats en pages pour une navigation plus facile. Voici comment utiliser ce service dans vos templates.

DOC : https://github.com/KnpLabs/KnpPaginatorBundle

1. **Installer le bundle via Composer :**

Pour installer le bundle `KnpPaginatorBundle` lancer cette commande :

```bash
composer require knplabs/knp-paginator-bundle
```

2. **Vérifier qu'il est activé :**

 => `config/bundles.php`

```php
<?php
return [
    // ...
    Knp\Bundle\PaginatorBundle\KnpPaginatorBundle::class => ['all' => true],
];
```

3. **Configurer si necessaire :**

 => `packages/knp_paginator.yaml`

 nombre de pages, template prédéfini, ..

 ```yaml
 knp_paginator:
    page_range: 5
    default_options:
        page_name: page
        sort_field_name: sort
        sort_direction_name: direction
        distinct: true
    template:
        pagination: 'pagination.html.twig' # Chemin vers votre modèle personnalisé ( cf 6. en bas de cette doc )
 ```


4. **Dans le Controller :**

```php
<?php

use Knp\Component\Pager\PaginatorInterface;


    // ...
    $pagination = $paginator->paginate(
        $query, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de la page à afficher
        10 // Nombre d'éléments par page
    );
    // ...
    
    //Passez la pagination à la vue via render :
    'pagination' => $pagination,
```

5. **Dans le template twig :**


```twig
{# Votre code Twig ici, par exemple une boucle : #}

{{ variable }}
{% for item in pagination %}
{{ item }}
{% endfor %}

{# Pagination en bas de page : #}

    <div class="pagination">
		{{ knp_pagination_render(pagination) }}
	</div>
```


6. **Personnaliser l'affichage de la pagination :**

Il est possible de choisir la maniere dont la pagination se fait dans un template. 

 => `vendor/knplabs/knp-paginator-bundle/templates`

 Selectionner le template choisir et le configurer dans `packages/knp_paginator.yaml`

```yaml
 knp_paginator:
    template:
        pagination: 'pagination.html.twig'
```
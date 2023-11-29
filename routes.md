# **ROUTES - COFFEELOVER**

# ACCUEIL


| Route| Description |
|--|--|
| / | page d’accueil avec une liste d’ articles “ le saviez vous ? “ + 2 articles aléatoires. | - |
| /a-propos |  page de présentation avec liens de contact et les mentions légales. | - |
| /categorie | page affichant un aperçu de tous les articles de la catégorie.  | - |
| /categorie/:titre-article | page affichant l’article demandé avec un lien vers le quiz de la catégorie. | - |
| /categorie/:titre-article/:titre-quiz | quiz accessible pour chaque article séléctionné | - |

# AUTHENTIFICATION

| Route| Description |
|--|--|
| /connexion | page de connexion avec mail et mot de passe puis redirection vers la page d’accueil en statut “connecté”. | - |
| /inscription |  inscription avec nom, prénom, email et mot de passe puis redirection vers la page d’accueil en statut “connecté”. | - |

# UTILISATEUR CONNECTE

| Route| Description |
|--|--|
| /mon-profil|  page affichant le nom de l’utilisateur et la liste des vignettes récompenses qui s’affichent lorsqu’on la sélectionne. | - |
| /mon-profil/:titre-recompense |  page affichant la récompense sélectionnée en grand format. | - |

# QUIZS

| Route| Description |
|--|--|
| /quiz|  page affichant les quiz de toutes les catégories. | - |
| /categorie/:titre-quiz  |  quiz sur la catégorie générée aléatoirement. | - |


# BACKOFFICE : MANAGER

| Route| Description |
|--|--|
| /back-office|  page d’accueil du backoffice affichant la liste des articles, quizzs et méthodes | - |
| /back-office/articles |  page affichant la liste des articles avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/article/ajouter |   page permettant d’ajouter un article | - |
| /back-office/article/id/modifier |   page permettant de modifier un article | - |
| /back-office/quiz |  page affichant la liste des articles avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/quiz/ajouter |   page permettant d’ajouter un quiz | - |
| /back-office/quiz/id/modifier |   page permettant de modifier un quiz | - |
| /back-office/methodes |  page affichant la liste des méthodes avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/methode/ajouter |   page permettant d’ajouter une fiche méthode | - |
| /back-office/methode/id/modifier |   page permettant de modifier une fiche méthode | - |
| /back-office/gif-musiques |  page affichant la liste des GIFs et musiques avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/gif-musique/ajouter |   page permettant d’ajouter un un GIF et/ou une musique | - |
| /back-office/gif-musique/id/modifier |   page permettant de modifier un GIF et/ou une musique | - |



# BACKOFFICE : ADMIN

| Route| Description |
|--|--|
| /back-office|  page d’accueil du backoffice affichant la liste des entités. | - |
| /back-office/utilisateurs |  page affichant la liste des utilisateurs avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/utilisateur/ajouter |  page permettant d’ajouter un utilisateur. | - |
| /back-office/utilisateur/id/modifier |  page permettant de modifier un utilisateur. | - |

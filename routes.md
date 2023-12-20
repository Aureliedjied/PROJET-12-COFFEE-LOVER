# **ROUTES - COFFEELOVER**

# ACCUEIL


| Route| Description |
|--|--|
| / | page d’accueil avec une liste d’articles “ le saviez vous ? “ + 2 articles aléatoires. | - |
| /qui-sommes-nous |  page de présentation avec liens de contact et les mentions légales. | - |
| /mention-legal |  page de présentation avec liens de contact et les mentions légales. | - |
| /articles/{categorySlug} | page affichant un aperçu de tous les articles de la catégorie.  | - |
| /articles/{categorySlug}/{articleSlug} | page affichant l’article demandé avec un lien vers le quiz de la catégorie. | - |


# AUTHENTIFICATION

| Route| Description |
|--|--|
| /connexion | page de connexion avec mail et mot de passe puis redirection vers la page d’accueil en statut “connecté”. | - |
| /inscription |  inscription avec nom, prénom, email et mot de passe puis redirection vers la page d’accueil en statut “connecté”. | - |

# UTILISATEUR CONNECTE

| Route| Description |
|--|--|
| /mon-profil|  page affichant le nom de l’utilisateur et la liste des vignettes récompenses qui s’affichent lorsqu’on la sélectionne. | - |
| /mon-profil/recompenses/{id} |  page affichant la récompense sélectionnée en grand format. | - |

# QUIZ

| Route| Description |
|--|--|
| /les-quiz|  page affichant les quiz de toutes les catégories. | - |
| /les-quiz/{title}/{id}  |  quiz sur la catégorie générée aléatoirement. | - |
| /les-quiz-resultat/{id}  |  résultat du quiz. | - |


# BACKOFFICE : MANAGER

| Route| Description |
|--|--|
| /back-office|  page d’accueil du backoffice affichant la liste des utilisateurs, articles, quiz, récompenses et GIF/musique | - |
| /back-office/articles |  page affichant la liste des articles avec lien d’ajout, de modification et bouton suppression. | - |
| /back-office/articles/ajouter |   page permettant d’ajouter un article | - |
| /back-office/articles/{id}/modifier |   page permettant de modifier un article | - |
| /back-office/quiz |  page affichant la liste des catégories des quiz. | - |
| /back-office/quiz/question/{title}/{id} |  page affichant la liste des questions par rapport à la catégorie du quiz avec lien d’ajout, de modification et bouton suppression.. | - |
| /back-office/quiz/ajouter |   page permettant d’ajouter une question et ses réponses à un quiz | - |
| /back-office/quiz/modifier/{id} |   page permettant de modifier les questions et réponses d'un quiz | - |
| /back-office/recompenses |  page affichant la liste des recompenses avec lien d’ajout et bouton suppression. | - |
| /back-office/recompenses/ajouter |   page permettant d’ajouter une fiche méthode | - |
| /back-office/gif-musiques |  page affichant la liste des GIFs et musiques avec lien d’ajout et bouton suppression. | - |
| /back-office/gif-musiques/ajouter |   page permettant d’ajouter un GIF et/ou une musique | - |


# BACKOFFICE : ADMIN

| Route| Description |
|--|--|
| /back-office/utilisateurs |  page affichant la liste des utilisateurs avec lien de modification et bouton suppression. | - |
| /back-office/utilisateur/modifier/{id} |  page permettant de modifier le role d'un utilisateur. | - |

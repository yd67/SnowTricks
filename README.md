
# SnowTriks - Projet Symfony OpenClassrooms

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/29a59771543e458c9aa25bb23cda1ddd)](https://www.codacy.com/gh/yd67/SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=yd67/SnowTricks&amp;utm_campaign=Badge_Grade)


![Logo](https://user.oc-static.com/upload/2016/11/17/14793747168201_snowboard_neige_figure_saut_shutterstock_3516624621.jpg)


## Description du projet 

Projet n°6 de la formation [Développeur d'application - PHP / Symfony](https://openclassrooms.com/fr/paths/500-developpeur-dapplication-php-symfony#path-tabs).
## Contexte


Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.
## Description du besoin 

les fonctionnalités suivantes devront etre implémenté : 

- un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes.
- la gestion des figures (création, modification, consultation).
- un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

- la page d’accueil où figurera la liste des figures.
- la page de création d'une nouvelle figure.
- la page de modification d'une figure.
- la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).

## Installation du projet

  **Etape 1 : Cloner le Repository sur votre serveur.**

  **Etape 2 : Créer Une base de données et importer le fichier "01snowtriks.sql" qui se trouve a la racine du projet .**

  **Etape 3 : Changer les informations de  connexion a la base de données .** 
 
  ```http 
 fichier:  .env    (a la racine du projet )

   DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
  ```
  

   **Etape 4 : Changer les informations de configuration pour l'envoie de mail .** 
 
  ```http 
  MAILER_DSN=smtp://localhost:1025 
  ```

 😄 c'est terminer .

 
 


## Auteur

- [Darius Yvens ](https://github.com/yd67)

[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://www.darius-yvens.com/)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://fr.linkedin.com/in/yvens-darius)

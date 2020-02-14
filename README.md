# Installation
- Cloner le projet
- Installer les dépendances:
    ```bash
    $ composer install
    $ yarn install
    ```
- Créer une copie locale de .env et compléter les informations nécessaires:
    - nom BDD, utilisateur et mot de passe BDD
- Si la base de données n'est pas déjà créée, le faire:
    ```bash
    $ php bin/console doctrine:database:create
    ```
- Créer les entités en base de données:
    ```bash
    $ php bin/console doctrine:migration:migrate
    ```
## Sélection d'un theme
- Se positionner sur la branche correspondant au theme souhaité
- Installer les dépendances JS et compiler les assets:
    ```
    $ yarn install
    $ yarn dev

## Démarrer un nouveau projet
- Depuis la banche du theme sélectionné:
    - Créer une nouvelle branche
    - Merger les potentielles évolutions du CMS depuis Master




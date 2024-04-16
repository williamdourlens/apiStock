# API Stock

API permettant la liaison entre l'application de stock et sa base de données.

## Composants

Créé avec Symfony, cette api utilise Doctrine en tant qu'ORM

## Installation

Pour installer le projet, il faut exécuter des commandes :
- `composer install`

Il faut ensuite exécuter ces commandes après avoir lancé un serveur local (XAMPP/WAMPP..) pour créer la BDD :
- `php bin/console doctrine:database:drop --force --if-exists`
- `php bin/console doctrine:database:create`
- `php bin/console make:migration`
- `php bin/console doctrine:migrations:migrate`

## Lancement

Pour lancer l'api, il faut lancer son serveur local et exécuter la commande `symfony server:start`. Rendez-vous maintenant sur le lien donné dans la console.

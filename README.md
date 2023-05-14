# moness

## Commande pour lancer le serveur:

### Lancer le serveur symfony:
    symfony server

### commande pour build assets:
    yarn run dev --watch

## Commande pour créer les entitées:

### créer une entité ou la mettre a jour:
    symfony console make:entity

## Commande pour créer les datafixtures

### création du dossier appfixture
    composer require --dev orm-fixtures

### commande du faker factory
     composer require fakerphp/faker

### ajouter les datafixture en bdd
    php bin/console doctrine:fixtures:load --no-interaction

### commande pour retourner sur une branche qui a etait push et que l on souhaite abondonner les modif
    git revert HEAD

### commande pour generer les data fitures 
composer requier fakerphp/faker

### pour les envoyer en bd

symfony console doctrine:fixtures:load


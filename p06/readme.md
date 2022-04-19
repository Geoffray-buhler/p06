# Bienvenu sur le p06 

Version de PHP : 7.2.5

pour installer le projet faire un clone du repo github avec cette commande : `**git clone https://github.com/Geoffray-buhler/p06.git**`

puis ensuite : `**composer install**`

et enfin pour lancer le serveur : `**symfony server:start**`

Si vous voulez mettre en place la base de données veuillez mettre les informations de connexion dans le fichier **.env** puis faire cette suite de commande :

> - **php bin/console create:database**
> - **php bin/console make:migration**
> - **php bin/console doctrine:migrations:migrate**
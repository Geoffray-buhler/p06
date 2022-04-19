# Bienvenu sur le p06 

Version de PHP : 7.2.5

Badge codacy : [![Codacy Badge](https://app.codacy.com/project/badge/Grade/6841b402cab644fdaae036da6ce5bbf1)](https://www.codacy.com/gh/Geoffray-buhler/p06/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Geoffray-buhler/p06&amp;utm_campaign=Badge_Grade)

pour installer le projet faire un clone du repo github avec cette commande : `git clone https://github.com/Geoffray-buhler/p06.git`

puis ensuite : `composer install`

et enfin pour lancer le serveur : `symfony server:start`

Si vous voulez mettre en place la base de données veuillez mettre les informations de connexion dans le fichier **.env** puis faire cette suite de commande :

> - **`php bin/console create:database`**
> - **`php bin/console make:migration`**
> - **`php bin/console doctrine:migrations:migrate`**
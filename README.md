# P5-Blog
Blog pour le projet 5 de la formation OCR, par Julien Robic

Gestion des utilisateurs : Créer votre compte, modifiez le, supprimez le.
Gestion des billets de blog : Si vous êtes administrateurs, écrivez votre billet de blog, éditez le, ou supprimez le.
Gestion des commentaires : Créez un commentaire, et celi ci sera soumis à validation aux administrateurs. Ils seront ensuite affiché sous les billets !

## Comment installer ?
1. Cloner le projet ou télécharger l'archive.
2. Lancer les containers en tapant `docker-compose up -d --build`
3. A la racine du projet, taper `docker run --rm -it -v $PWD:/app -u $(id -u):$(id -g) composer install`
5. Structurer la bdd en éxecutant le fichier `docker-compose exec backend php mysql-import.php`
6. Utilisateur créé par défaut avec les droits admin : admin//azerty

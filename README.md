# P5-Blog
Blog pour le projet 5 de la formation OCR, par Julien Robic

Gestion des utilisateurs : Créer votre compte, modifiez le, supprimez le.
Gestion des billets de blog : Si vous êtes administrateurs, écrivez votre billet de blog, éditez le, ou supprimez le.
Gestion des commentaires : Créez un commentaire, et celi ci sera soumis à validation aux administrateurs. Ils seront ensuite affiché sous les billets !

## Comment installer ?
1. Cloner le projet ou télécharger l'archive.
2. A la racine, taper "composer update"
3. En cas d'utilisation de nginx, configurer l'url rewriting et le serveur dans le répertoire public.
4. Configurer vos accès à votre base de données avec le fichier "config.template".
5. Structurer la bdd en éxécutant le fichier "docker-compose exec backend php mysql-import.php"
6. Utilisateur créé par défaut avec les droits admin : Nayte//admin

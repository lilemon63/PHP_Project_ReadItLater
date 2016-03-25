Mise en route :
	lancer le serveur mysql : (nécessite surement le package php7.0-mysql)
	./runSql.sh

	lancer le serveur php : (nécessite php7.0)
	./runServer.sh

	Une fois lancé, aller sur le navigateur : http://localhost:8080/
	Exécuter les scripts mysql : 00_database.sql et 01_tables.sql situés dans le répertoire sqlScripts
	OU : http://localhost:8080/system/createDB 
	fonctionnera s'il existe un user 'root' avec le mot de passe 'admin'
	ET http://localhost:8080/system/createTables
	fonctionnera à partir du moment où la base est créée


Pour commencer : Les choses faites
	Nous avons utilisé le micro-Framework Silex comme vous nous l'avez conseillé.
	Afin d'avoir une structure plus élaborée et une gestion de BDD correcte, nous avons suivi
	ce tutoriel jusqu'à l'itération 7 : 
		https://openclassrooms.com/courses/evoluez-vers-une-architecture-php-professionnelle
	A la différence que nous n'utilisons pas le serveur apache mais le serveur buildin php7.0
	
	Le modèle : 
	Utilisation pdo_MySQL dans le but d'avoir une base de données relativement cohérente et assez utilisée.
	L'accès aux données se fait grâce aux classes situés dans le dossier src/DAO.
	Les classes métier sont représentées dans le dossier src/Domain
	
	Les tests unitaires :
	Nous avons essayé d'utiliser Behat. Pour exécuter nos tests : "php behat.phar" dans le dossier racine.
	Nous avons choisi Behat car il était conseillé dans le sujet. Cependant, on aurait pu aussi effectuer 
	les tests avec Silex directement, bien que le rendu final est moins classe.
	
	Présentation : bootstrap.
	Prise de content sur les url : cUrl

Les choses pas faites :
	Le worker : nous avons essayé de regarder vers Symfony/Console mais nous n'avons pas réussi à élaborer
	une commande de type "cron" et appelant une route silex en ayant simplement le bundle "Symfony/Console".
	
	Gestion d'utilisateurs : le fait que ce soit optionnel nous a permi de gagner du temps (bien qu'il n'y 
	aurait eu qu'à suivre l'iteration 8 de notre tutoriel).

En espérant que notre application vous plaira,
Maxime Mikotajewski et Damien Morel.

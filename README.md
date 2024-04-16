# SandrineCoupartDietetique-
ECF dietetique sandrineCoupart


PREREQUIS
Gitbash, un serveur Web (Apache, Nginx, etc.) PHP 8.0 ou supérieur MySQL 8.0 ou supérieur

INITIALISATION::
Dans un terminal Git Bash
taper la commande: git clone https://github.com/stringnameQG/SandrineCoupartDietetique-
aller dans le dossier :cd/SandrineCoupartDietetique- et installer les dépendances avec la commande: composer install

CONFIGURATION::
Cree un fichier à la racine du projet avec la commande: touch 'env.local'

CONNEXION A LA BDD
Ouvrir le fichier env.local dans votre éditeur de code et copier la commande suivante en remplaçant id par votre root ver votre dossier et mdp par votre mot de passe:
DATABASE_URL="mysql://id:mdp@127.0.0.1:8889/stephaniecarondiatetique?serverVersion=8.0.32&charset=utf8mb4"

Cree les tables de votre base de donnée en tapant dans votre terminal: php bin/console doctrine:migrations:migrate
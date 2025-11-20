Contexte et objectifs:
Dans le contexte du Projet Power-4 Web notre mision était de créer et faire tourner un serveur , dans lequel il devra être possible d'utiliser une interface GUI qui permettra a 2 joueurs de s'affronter au jeu du Puissance 4.
Nos objectifs étaient ainsi de créer un jeu fonctionel incluant une Ia, un système d'utilisateur et une interface claire et colorée, cohérente avec notre thème, le football.

Pour lancer le jeu, il faut effectuer les commandes suivantes: 
cd .\power4-web\
go run main.go


Fonctions Clés:
Le main.go est le fichier le plus important car sans lui le site ne peux pas se lancer, en effet il ouvre le navigateur et permet également d'ouvrir la base de données phpmyadmin.power4.html est également une fonction indispensable car elle gere le systeme de jeu(Victoire, Match nul, Ia) et le js (L'interface en général).

Décisions architécture:
Notre achitécture repose sur un serveur html avec du go en back end. Egalement, notre architecture utilise php.myadmin

Compromis Techniques:
A la base le projet était de séparer les fichier front end qui aurait comporté le visuel global du site et un back end qui aurait comporté la logique du jeu. Finalement nous avons opté pour une fusion, ce qui s'est averré être une bonne solution

Qualité et tests:
Le jeu est fonctionnel, le seul problème lors de nos test venant du mode anti gravité qui causait des problèmes a l'ia du jeu et ainsi on a bloqué le mode Anti-gravité lors d'un match contre l'ia et Inversement.

Limites Connues et pistes d'amélioration:
Le site reste local et non acessible en ligne, également certains designs pourraient être améliorés ou revus a l'avenir.

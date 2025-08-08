## A propos de E-events

E-events est une plateforme destinée à la gestion de l'organisation des évènements:

- Ajout des évènements avec leurs tickets.
- Affichage des évènements au public.
- Participation des utilisateurs en choisissant un ticket et payer le montant en ligne.
- Réception d'un billet en PDF attestant le paiement par e-mail. En cas de perte, possibilité
    de télécharger le billet depuis la plateforme en tout moment
- Chaque billet possède un QR Code pour attester son originalité et est utilisable une seule fois.
- Possibilté à l'organisateur de voir la liste des participants et les montants déjà collectés.
- ...

Ce projet est ouvert à tout le monde, vous pouvez l'utiliser comme vous le souhaitez.

## Comment l'installer ?

* Récuperer le projet depuis git en faisant git clone;
* Ouvrir le projet avec votre éditeur et copier le fichier .env.example et le rénommer en .env;
* Ouvrir le terminal et taper composer install pour initialiser le backend. Ensuite taper npm install pour la partie frontend;
* Compiler le front en tapant npm run build;
* Autoriser la lecture des fichiers comme images des évènements ajoutés en tapant php artisan storage:link;
* Taper php artisan serve pour démarrer le serveur et visiter [Le lien ici](http://127.0.0.1:8000)
    pour avoir un visuel;

## Merci pour votre visite

Le développeur, **[Gautier Seth Djossou](https://dgworks.alwaysdata.net)**.

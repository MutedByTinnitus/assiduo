# Assiduo

Application web de gestion des absences et retards scolaires, développée pour NOVASCOL
(cahier des charges NVS-2026-014) dans le cadre d'un développement ouvert : ce dépôt est
public et le code est publié sous licence MIT (voir [LICENSE](LICENSE)).

## Pile technique

Pile imposée par l'annexe technique NVS-2026-014 ; versions retenues et justifiées dans
[docs/dossier-architecture.md](docs/dossier-architecture.md).

- PHP 8.4 + [Symfony](https://symfony.com/) 7.4 (LTS) + [Twig](https://twig.symfony.com/)
- [FrankenPHP](https://frankenphp.dev/) comme serveur d'application
- MySQL 8.4 (LTS) via Doctrine ORM
- Docker Compose, à l'identique en développement et en recette

## État du projet

Phase de cadrage : périmètre confirmé, modèle de données validé (voir
[docs/modele-de-donnees.md](docs/modele-de-donnees.md) et
[docs/dossier-architecture.md](docs/dossier-architecture.md)), mise en place du dépôt en cours.

## Démarrage

```bash
cp .env.example .env.local   # puis renseigner de vraies valeurs dans .env.local
docker compose up -d --build
php bin/console doctrine:migrations:migrate
```

L'application est servie en HTTPS par FrankenPHP/Caddy. Pour le développement au jour le jour
sans conteneuriser le PHP à chaque changement, la base peut aussi tourner seule via
`docker compose up -d database` pendant que `symfony server:start` sert l'application en local.

## Contribution

- Branche `main` réservée à ce qui fonctionne — aucun développement direct dessus.
- Une branche par tâche : `feature/<nom-issue>` ou `fix/<nom-issue>`, fusionnée sur `main`
  une fois la fonctionnalité opérationnelle.
- Toute reprise de code externe est citée dans le message de commit et ci-dessous.

## Contributions

_À compléter au fil du projet (voir §8 du cahier des charges — README finalisé au point 12)._

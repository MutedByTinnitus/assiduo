# Assiduo

Application web de gestion des absences et retards scolaires, développée pour NOVASCOL
dans le cadre d'un développement ouvert : ce dépôt est
public et le code est publié sous licence MIT 

## Pile technique
- PHP 8.4 + [Symfony](https://symfony.com/) 7.4 (LTS) + [Twig](https://twig.symfony.com/)
- [FrankenPHP](https://frankenphp.dev/) serveur d'application
- MariaDB 11.4 (LTS) via Doctrine ORM
- Docker Compose



## Démarrage

```bash
cp .env.example .env.local   # puis renseigner de vraies valeurs dans .env.local
export COMPOSE_ENV_FILES=.env.local   # docker compose ne lit pas .env.local tout seul
docker compose up -d --build
docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction
```

L'application est servie sur le port 80 de la machine. Sous Windows (PowerShell), remplacer
l'`export` par `$env:COMPOSE_ENV_FILES = ".env.local"`.

## Contribution

- Branche `main` réservée à ce qui fonctionne, aucun développement direct dessus.
- Une branche par tâche : `feature/<nom-issue>` ou `fix/<nom-issue>`, fusionnée sur `main`
  une fois la fonctionnalité opérationnelle.
- Toute reprise de code externe est citée dans le message de commit et ci-dessous.


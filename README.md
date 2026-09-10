# Assiduo

Application web de gestion des absences et retards scolaires, développée pour NOVASCOL
(cahier des charges NVS-2026-014) dans le cadre d'un développement ouvert : ce dépôt est
public et le code est publié sous licence MIT (voir [LICENSE](LICENSE)).

## Pile technique

- [Symfony](https://symfony.com/) (PHP) + [Twig](https://twig.symfony.com/)
- Doctrine ORM, base PostgreSQL
- Docker / docker compose pour le développement et la recette

## État du projet

Phase de cadrage : périmètre confirmé, modèle de données validé (voir
[docs/modele-de-donnees.md](docs/modele-de-donnees.md)), mise en place du dépôt en cours.

## Démarrage

```bash
composer install
docker compose up -d
php bin/console doctrine:migrations:migrate
symfony server:start
```

## Contribution

- Branche `main` réservée à ce qui fonctionne — aucun développement direct dessus.
- Une branche par tâche : `feature/<nom-issue>` ou `fix/<nom-issue>`, fusionnée sur `main`
  une fois la fonctionnalité opérationnelle.
- Toute reprise de code externe est citée dans le message de commit et ci-dessous.

## Contributions

_À compléter au fil du projet (voir §8 du cahier des charges — README finalisé au point 12)._

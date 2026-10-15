# Dossier d'architecture : Assiduo v1

## Versions retenues

Conformément à l'annexe technique §2.2, les technologies sont imposées et les versions sont
choisies et justifiées par l'équipe selon quatre critères : support jusqu'à la fin du projet
et au-delà, compatibilité avec les autres composants, documentation et retours d'expérience
disponibles, disponibilité en image officielle épinglable.

Sources vérifiées : php.net/supported-versions.php, symfony.com/releases, frankenphp.dev,
debian.org/releases (le 2026-09-10) et endoflife.date/mariadb (le 2026-10-15).

| Composant | Version retenue | Justification |
|---|---|---|
| PHP | **8.4.25** | Support actif jusqu'à fin 2026 et sécurité jusqu'à fin 2028 : couvre les 12 points d'équipe avec marge, contrairement à PHP 8.2 et 8.3 dont le support actif est déjà terminé. Compatible avec Symfony 7.4 (exige PHP 8.2 minimum). |
| Symfony | **7.4 (LTS)** | Branche LTS maintenue en correctifs de sécurité jusqu'en 2029, alors que la branche courante (8.1) termine son support en janvier 2027, en plein milieu du projet. |
| FrankenPHP | **1.12.7** (image `1.12.7-php8.4-trixie`) | Dernière version stable, disponible en image officielle épinglable ; variante Debian (Trixie) retenue plutôt qu'Alpine, qui impose de recompiler plusieurs extensions PHP (annexe §2.3). |
| MariaDB | **11.4 LTS** (image `mariadb:11.4.13`) | Support communautaire jusqu'en mai 2029, soit plus longtemps que les LTS 11.8 (juin 2028) et 10.11 (février 2028), donc très au-delà du projet. Sortie en mai 2024, elle a du recul en production (contrairement à la 12.3, sortie en mai 2026) et existe en image officielle épinglable. Compatible avec le pilote `pdo_mysql` et avec Doctrine (`serverVersion=mariadb-11.4.13`). |
| Debian (machine de recette) | **13 « Trixie »** | Version stable actuelle depuis août 2025, support complet jusqu'en 2028 (LTS jusqu'en 2030) ; cohérente avec la variante Debian retenue pour l'image FrankenPHP. |

**Règle d'épinglage** : aucune image ne référence `latest`. `composer.lock` est versionné.

**Collation** : `utf8mb4_uca1400_ai_ci`, collation par défaut de MariaDB 11.4 pour `utf8mb4`.
Elle est insensible à la casse et aux accents (une recherche sur « Perez » trouve « Pérez »,
vérifié sur la base du `compose.yaml`). Elle est aussi appliquée explicitement au serveur
(`--collation-server`) pour que le serveur, la base et les tables créées par Doctrine soient
cohérents.

## Comptes de base de données

L'annexe §8 demande un compte applicatif limité à `SELECT, INSERT, UPDATE, DELETE` sur la base
`assiduo`, jamais `root`. Deux comptes existent :

- **`root`** : administration de la base, utilisé en dehors de l'application.
- **`app`** : compte utilisé par l'application (`DATABASE_URL`). Il est créé par l'image
  MariaDB avec les variables `MARIADB_USER` et `MARIADB_PASSWORD`.

**Écart à corriger avant la recette** : l'image accorde par défaut tous les droits sur
`assiduo.*` au compte `app`. La restriction à `SELECT, INSERT, UPDATE, DELETE` (et l'exécution
des migrations avec un compte distinct) n'est pas encore en place. Le contrôle attendu en
recette est `SHOW GRANTS FOR 'app'@'%';`.

## Validation du schéma

Validé localement le 2026-10-15 sur MariaDB 11.4.13 (image du `compose.yaml`) :

- `doctrine:migrations:migrate` crée le schéma ;
- `doctrine:schema:validate` confirme que la base est synchronisée avec les entités ;
- la contrainte `uniq_creneau_date (creneau_id, date)` est présente sur la table `appel`.

## Le modèle de données

Voir [modele-de-donnees.md](modele-de-donnees.md) pour le schéma et le détail des entités. Le
point structurant, la séparation entre le créneau récurrent et l'appel daté avec la contrainte
d'unicité `(creneau_id, date)`, est celui que l'annexe technique §3 identifie comme le plus
coûteux à corriger après coup. Il a été validé dès le cadrage.

## Calcul du taux d'absentéisme (F4)

Défini ici par écrit conformément à l'annexe §7, pour que le calcul soit reproductible et
comparable :

```
taux d'absentéisme (classe, période) =
    nombre de Presence de statut "absent" sur la période
    ÷ nombre total de Presence attendues sur la période (tous statuts confondus)
```

Le numérateur et le dénominateur sont calculés par agrégation SQL (`COUNT` et `GROUP BY`),
jamais en chargeant les présences en PHP pour les compter en boucle.

## Écarts assumés par rapport au schéma illustratif de l'annexe §3.1

- **Pas d'entité `Etablissement`** : le pilote ne concerne qu'un seul établissement (Cité
  scolaire Marcel-Pagnol). Ajouter une entité et une portée multi-établissement n'apporterait
  aucun comportement supplémentaire pour la v1 et compliquerait chaque requête sans raison.
- **Pas d'entité `Enseignant` distincte de `User`** : le brief (F1) demande la « gestion des
  comptes et des quatre rôles ». Un compte de connexion unique porte donc le rôle
  `ROLE_ENSEIGNANT`, `ROLE_VIE_SCOLAIRE`, `ROLE_DIRECTION` ou `ROLE_ADMIN`. `Creneau.enseignant`
  référence ce compte `User` ; dupliquer l'information dans une entité `Enseignant` séparée
  créerait deux sources de vérité pour la même personne sans bénéfice fonctionnel.

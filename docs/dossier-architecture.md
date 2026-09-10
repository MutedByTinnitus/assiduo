# Dossier d'architecture — Assiduo v1

## Versions retenues

Conformément à l'annexe technique §2.2 : les technologies sont imposées, les versions sont
choisies et justifiées par l'équipe selon quatre critères — support jusqu'à la fin du projet
et au-delà, compatibilité avec les autres composants, documentation/retour d'expérience
disponibles, disponibilité en image officielle épinglable. Sources vérifiées le 2026-09-10 :
php.net/supported-versions.php, symfony.com/releases, frankenphp.dev, endoflife.date/mysql,
debian.org/releases.

| Composant | Version retenue | Justification |
|---|---|---|
| PHP | **8.4.25** | Support actif jusqu'à fin 2026 et sécurité jusqu'à fin 2028 : couvre les 12 points d'équipe avec marge, contrairement à PHP 8.2/8.3 dont le support actif est déjà terminé. Compatible avec Symfony 7.4 (exige PHP ≥ 8.2). |
| Symfony | **7.4 (LTS)** | Branche LTS maintenue en correctifs de sécurité jusqu'en 2029, alors que la branche courante (8.1) termine son support en janvier 2027 — en plein milieu du projet. |
| FrankenPHP | **1.12.7** (image `1.12.7-php8.4-trixie`) | Dernière version stable, disponible en image officielle épinglable ; variante Debian (Trixie) retenue plutôt qu'Alpine, qui impose de recompiler plusieurs extensions PHP (cf. annexe §2.3). |
| MySQL | **8.4 LTS** (image `mysql:8.4.12`) | LTS avec support Premier jusqu'en 2029 (étendu jusqu'en 2032), donc largement au-delà du projet. La version Innovation 9.7 (sortie avril 2026) est écartée : trop récente pour avoir du recul en production (critère documentation/retour d'expérience). |
| Debian (machine de recette) | **13 « Trixie »** | Version stable actuelle depuis août 2025, support complet jusqu'en 2028 (LTS jusqu'en 2030) ; cohérente avec la variante Debian retenue pour l'image FrankenPHP. |

**Règle d'épinglage** : aucune image ne référence `latest`. `composer.lock` est versionné.

**Collation MySQL** : `utf8mb4_0900_ai_ci` — insensible à la casse et aux accents (une
recherche sur « Perez » doit trouver « Pérez »), disponible nativement depuis MySQL 8.0.

## Comptes MySQL — migrations vs exécution applicative

Deux comptes distincts, conformément à l'annexe §8 (« compte de base de données applicatif :
SELECT, INSERT, UPDATE, DELETE sur la base `assiduo`, jamais `root` ») :

- **Compte applicatif `app`** : `SELECT, INSERT, UPDATE, DELETE` uniquement sur `assiduo.*`.
  C'est la connexion utilisée par l'application en fonctionnement normal (`DATABASE_URL`).
  Vérifiable par `SHOW GRANTS FOR 'app'@'%';`.
- **Compte administrateur (root, ou un compte migration dédié)** : seul habilité à créer/modifier
  le schéma, utilisé uniquement pour exécuter `doctrine:migrations:migrate` — jamais par
  l'application en fonctionnement. Le brief l'exige : « aucun schéma modifié à la main » et le
  compte applicatif n'a explicitement pas les droits DDL nécessaires.

Validé localement le 2026-09-10 : `doctrine:migrations:diff` puis `doctrine:migrations:migrate`
exécutés avec succès contre une instance MySQL 8.4.x, création des 8 tables attendues et de la
contrainte `uniq_creneau_date (creneau_id, date)` confirmée par `SHOW CREATE TABLE appel`.

## Le modèle de données

Voir [modele-de-donnees.md](modele-de-donnees.md) pour le détail des entités. Le point
structurant — la séparation entre le créneau récurrent et l'appel daté, avec la contrainte
d'unicité `(creneau_id, date)` — est celui identifié par l'annexe technique §3 comme le plus
coûteux à corriger a posteriori ; il a été validé dès le cadrage.

## Calcul du taux d'absentéisme (F4)

Défini ici par écrit conformément à l'annexe §7, pour que le calcul soit reproductible et
comparable :

```
taux d'absentéisme (classe, période) =
    nombre de Presence de statut "absent" sur la période
    ÷ nombre total de Presence attendues sur la période (tous statuts confondus)
```

Le numérateur et le dénominateur sont calculés par agrégation SQL (`COUNT`/`GROUP BY`), jamais
en chargeant les présences en PHP pour les compter en boucle.

## Écarts assumés par rapport au schéma illustratif de l'annexe §3.1

- **Pas d'entité `Etablissement`** : le pilote ne concerne qu'un seul établissement (Cité
  scolaire Marcel-Pagnol). Ajouter une entité et une portée multi-établissement n'apporterait
  aucun comportement supplémentaire pour la v1 et compliquerait chaque requête sans raison.
- **Pas d'entité `Enseignant` distincte de `User`** : le brief (§F1) demande la « gestion des
  comptes et des quatre rôles » — un compte de connexion unique porte donc le rôle
  `ROLE_ENSEIGNANT`, `ROLE_VIE_SCOLAIRE`, `ROLE_DIRECTION` ou `ROLE_ADMIN`. `Creneau.enseignant`
  référence ce compte `User` ; dupliquer l'information dans une entité `Enseignant` séparée
  créerait deux sources de vérité pour la même personne sans bénéfice fonctionnel identifié.

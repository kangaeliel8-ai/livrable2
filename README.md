# Livrable 2 — « Avec les Femmes » (rôle super-admin)

Entités, énumérations, trait, fixtures, listes et architecture en couches
**Controller → Service → Repository → DTO**.

## Contenu

```
src/
├── Trait/DateTimeTrait.php
├── Enum/            StatutExercice, TypeCampagne, Periodicite, StatutPresence
├── Entity/          Groupement, Exercice, Campagne, Membre, Adhesion, Seance, Cotisation, Amende
├── Repository/      un repository par entité (+ requêtes DQL métier)
├── DataFixtures/    7 classes, ordre garanti par DependentFixtureInterface
├── Dto/             Groupement, Exercice, Campagne, Membre, SeanceTotaux, SeanceDetail, lignes
├── Service/         GroupementService, CampagneService, SeanceService
└── Controller/      Home, Groupement, Campagne, Seance
templates/           layout + groupement/ campagne/ seance/
```

## Installation dans votre projet Symfony 7

```bash
composer require symfony/orm-pack symfony/twig-bundle symfony/maker-bundle --dev
composer require --dev orm-fixtures
# copier src/ et templates/ dans votre projet, puis :
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:validate
php bin/console doctrine:fixtures:load
symfony local:server:start       # http://127.0.0.1:8000
```

## Répartition sur les branches (exigence du livrable)

| Branche | Fichiers | Commit suggéré |
|---|---|---|
| `livrable/2-entites` | `src/Trait`, `src/Enum`, `src/Entity`, `src/Repository` + migration | `feat(entites): entités, enums, trait et migration` |
| `livrable/2-fixtures` | `src/DataFixtures` | `feat(fixtures): jeux de données avec ordre de dépendance` |
| `livrable/2-listes` | `src/Dto`, `src/Service`, `src/Controller`, `templates` | `feat(listes): controller, service, repository, DTO et vues` |

Faites **plusieurs petits commits par branche** (un par entité, une fixture, un DTO…),
puis fusionnez chaque branche dans `develop`.

## Résultat attendu après `fixtures:load`

- 3 groupements, 4 exercices (dont 1 clôturé), 4 campagnes, 15 membres, 15 adhésions
- 9 séances, 45 cotisations, 3 amendes de 1 050 FCFA (3 jours × 350)
- Séance 1 de chaque groupement : collecté 22 000 FCFA (4 × 5 000 + 2 000), caisse sociale 700 FCFA (4 × 100 + 1 × 300), amendes 0
- Séance 2 : la membre n°4 (index 3) est absente non payée → amende de 1 050 FCFA

## Choix de conception à savoir justifier

- **Trait** et non classe mère : `createdAt/updatedAt` n'expriment pas un « est-un ».
- **Montants en `int`** : le FCFA n'a pas de centimes, pas d'erreurs d'arrondi.
- **Totaux calculés (SUM)**, jamais stockés : pas d'incohérence possible ; pas de classe `CaisseSociale`.
- **Sous-requêtes** pour les totaux : un double JOIN fausserait les SUM.
- **DTO** : dates formatées et « exercice en cours » résolus hors de la vue ; Twig ne voit jamais une entité.
- **Service** renvoie `null`, le **contrôleur** décide du 404 : le service ignore HTTP (SRP).
- **Fixtures** : `persist()` dans la boucle, un seul `flush()` après ; `addReference/getReference` au lieu de `findAll()`.

## Limites connues (à améliorer aux prochains livrables)

- Les règles de calcul de cotisation sont dans la fixture : à extraire dans un service dédié.
- `GroupementDto` lit la collection `exercices` ; avec le LEFT JOIN conditionnel elle ne contient
  que l'exercice en cours. Pour une page qui a besoin de TOUS les exercices, utiliser une autre requête.
- Pas d'authentification : le périmètre « super-admin » sera sécurisé avec Symfony Security.

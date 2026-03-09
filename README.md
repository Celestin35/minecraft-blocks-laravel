## Minecraft Blocks (Laravel)

Application Laravel pour lister des blocs Minecraft, les filtrer, et gerer des inventaires (decks) par utilisateur.

### Fonctionnalites
- Authentification (inscription, connexion, deconnexion)
- Liste des blocs et filtre (categorie, famille, recherche)
- Detail d'un bloc
- Gestion des inventaires par utilisateur (CRUD)
- Ajout / suppression de blocs dans un inventaire
- Gestion des quantites de blocs dans un inventaire

### Pile technique
- PHP 8.2+
- Laravel 12
- Blade + Vite
- Tests avec Pest (PHPUnit en dessous)

### Installation
1. Installer les dependances PHP
```bash
composer install
```

2. Creer la configuration
```bash
copy .env.example .env
php artisan key:generate
```

3. Configurer la base (dans `.env`) puis migrer + seed
```bash
php artisan migrate --seed
```

4. Installer les dependances front et compiler
```bash
npm install
npm run build
```

Lancer en dev:
```bash
php artisan serve
npm run dev
```

### Donnees
Les blocs sont charges depuis `database/data/blocks_extended.csv` via le seeder `BlockSeeder`.
Un utilisateur de test est cree dans `DatabaseSeeder`:
- email: `test@example.com`

### Routes principales
- `GET /block` : liste des blocs
- `GET /block/{block}` : detail d'un bloc
- `GET /inventories` : liste des inventaires (auth)
- `POST /inventories` : creer un inventaire (auth)
- `GET /inventories/{inventory}` : detail d'un inventaire (auth + proprietaire)
- `DELETE /inventories/{inventory}` : supprimer un inventaire (auth + proprietaire)
- `POST /inventories/{inventory}/blocks` : ajouter un bloc (auth + proprietaire)
- `PATCH /inventories/{inventory}/blocks/{block}` : mettre a jour la quantite (auth + proprietaire)
- `DELETE /inventories/{inventory}/blocks/{block}` : retirer un bloc (auth + proprietaire)

### Tests
Les tests sont ecrits avec Pest.
```bash
composer test
```

### Structure des donnees
- `blocks` : donnees des blocs Minecraft
- `inventories` : inventaires par utilisateur
- `block_inventory` : table pivot avec `quantity`

### Notes
- Les inventaires sont prives (chaque utilisateur ne voit que les siens).
- Les routes d'administration de blocs sont proteges par auth.

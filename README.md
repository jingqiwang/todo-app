# Todo App Test for Senior Web Developer
This project import **Laravel Breeze** as authentication.
Use Vue, tailwindcss for frontend development.
Use Vitejs for bundling frontend assets.

### Project Setup Steps

1. **Set up the environment file**:
   ```bash
   ln -s .env.development .env

2. **Build Docker**
    ```bash
    docker compose build

3. **Install Composer dependencies:**
    ```bash
    docker-compose run --rm php composer install

4. **Install Node.js dependencies**
    ```bash
    docker-compose run --rm php pnpm install

5. **Run pnpm build**
    ```bash
    docker-compose run --rm php pnpm build

6. **Start Docker containers**
    ```bash
    docker compose up -d

7. **Database Setup**
    ```bash
    docker-compose exec php php artisan migrate

### Code Testing
```bash
docker compose exec php php artisan test

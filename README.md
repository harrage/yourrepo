# Qode test - backend
## Requirements
- Docker
- Docker compose
## Installation

To install the project, all you need to do is to run these commands:

1. Build the containers
```sh
docker compose up -d --build
```
2. Install dependencies (one-time only):
```sh
docker compose run --rm composer install
```

3. Run migrations and seed initial data (one-time only):
```sh
docker compose run --rm artisan migrate --seed
```

4. Run the queue:
```sh
docker compose run --rm artisan queue:work
```

4. Run the scheduled tasks (Necessary to periodically fetch news):
```sh
docker compose run --rm artisan schedule:work
```

The API will be available via [http://localhost](http://localhost)
# Project Name

A Dockerized Laravel API with PostgreSQL and Apache.

## Quick Start

### Prerequisites

- Docker and Docker Compose
- Node.js (for frontend)

```sh
# Clone the repository
git clone https://github.com/jdu211171/Timetable-Scheduler.git
cd Timetable-Scheduler

# Backend Setup
cp .env.example .env  # Update DB credentials if needed
```

## Docker Commands

```sh
# Start containers
docker-compose up --build -d

# Run migrations
docker-compose exec jdu_web php artisan migrate

# Stop containers
docker-compose down
```

## Development Workflow

### Backend

- Access container shell:
    ```sh
    docker-compose exec jdu_web bash
    ```
- API URL: `http://localhost:8040`

### Frontend

```sh
cd cpm-client
npm run dev  # Development server
```

## Before Contributing

1. Always pull latest changes:
    ```sh
    git pull --rebase
    ```
2. Run lint/fix scripts if available:
    ```sh
    npm run fix  # Frontend
    php artisan lint:fix  # Backend
    ```
3. Push your changes:
    ```sh
    git push
    ```

## Project Structure

```
├── backend
│   └── EduWaveLaravel   # you are here
└── frontend
    ├── app
    └── public
```

> **Note**  
> Commit messages must be descriptive and reference related issues.

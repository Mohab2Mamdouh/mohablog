# Mohablog - Personal Portfolio

A modern Laravel-based portfolio website with an admin dashboard for managing personal information, skills, projects, and work experience.

## Features

- 🎨 Modern, responsive UI with smooth animations
- 📱 Mobile-friendly design
- 🔐 Admin dashboard for content management
- 📄 PDF CV generation
- 🌐 Multi-language support
- 🐳 Docker containerized setup

## Tech Stack

- **Backend:** Laravel 9, PHP 8.1
- **Frontend:** Bootstrap 5, Custom CSS
- **Database:** MySQL 8.0
- **Containerization:** Docker & Docker Compose

## Quick Start

### Prerequisites

- Docker & Docker Compose
- Make (optional, for using Makefile commands)

### Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd mohablog
```

2. Run setup:
```bash
make setup
```

This will:
- Create `.env` file
- Build Docker containers
- Install dependencies
- Generate application key
- Run migrations
- Seed database
- Create storage link

The application will automatically find available ports (starting from 8000).

### Manual Setup

If you prefer manual setup:

```bash
# Copy environment file
cp .env.example .env

# Update .env with your database settings
# DB_HOST=<your-mysql-container>
# DB_DATABASE=mohablog

# Build and start containers
docker-compose up -d --build

# Install dependencies
docker exec -it mohablog-app composer install

# Generate key
docker exec -it mohablog-app php artisan key:generate

# Run migrations
docker exec -it mohablog-app php artisan migrate

# Import database (optional)
docker exec -i <mysql-container> mysql -uroot -p<password> mohablog < mohablog.sql

# Fix permissions
docker exec -it mohablog-app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker exec -it mohablog-app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

## Makefile Commands

```bash
make help              # Show all available commands
make setup             # Initial environment setup
make build             # Build Docker containers
make up                # Start services
make down              # Stop services
make restart           # Restart services
make shell             # Access app container shell
make logs              # View Laravel logs
```

## Project Structure

```
mohablog/
├── app/
│   ├── Console/Commands/     # Custom artisan commands
│   ├── Http/Controllers/     # Application controllers
│   └── Models/               # Eloquent models
├── resources/
│   └── views/
│       ├── Admin/            # Admin dashboard views
│       ├── layouts/          # Layout templates
│       └── index.blade.php   # Portfolio homepage
├── public/
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── docker-compose.yml        # Docker services configuration
├── Dockerfile                # PHP-FPM container
└── Makefile                  # Development commands
```

## Features Overview

### Portfolio (Public)
- Hero section with social links
- About me section
- Skills showcase with categories
- Project portfolio
- Work experience timeline
- Language proficiency
- Downloadable CV

### Admin Dashboard
- Personal information management
- Skills CRUD operations
- Projects management
- Work experience tracking
- Speaking languages management

## Configuration

### Database
The project is configured to use a shared MySQL container. Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=<mysql-container-name>
DB_PORT=3306
DB_DATABASE=mohablog
DB_USERNAME=root
DB_PASSWORD=root
```

### Ports
- Web: Auto-detected (8000-8100)
- Database: Shared container on 3306

## Custom Commands

```bash
# Generate seed data
php artisan generate:seed

# Create new seeder
php artisan make:seeder <name>
```

## Development

Access the application:
- **Portfolio:** http://localhost:<port>
- **Admin Dashboard:** http://localhost:<port>/login

Default admin credentials are set during seeding.

## License

MIT License - see LICENSE file for details.

## Author

Mohab Mamdouh Abd El-Twab
- GitHub: [@MohabsMamdouh](https://github.com/MohabsMamdouh)
- LinkedIn: [mohab-mamdouh](https://linkedin.com/in/mohab-mamdouh-9307a57b/)
- Email: mohabmamdouh22@gmail.com

# Mercury-API.

Mercury API é uma REST API moderna construída com Laravel, projetada para gerenciar produtos e serviços de forma completa e escalável. Inclui autenticação com Laravel Sanctum, versionamento de endpoints, testes automatizados com PHPUnit e documentação estruturada com Swagger/Laravel API Resources.

APP_NAME=Mercury
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

# ----------------------------------------

# DATABASE (MySQL via Docker)

# ----------------------------------------

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mercury
DB_USERNAME=root
DB_PASSWORD=mercury

# ----------------------------------------

# SANCTUM / API

# ----------------------------------------

SANCTUM_STATEFUL_DOMAINS=localhost:3000
SESSION_DOMAIN=localhost

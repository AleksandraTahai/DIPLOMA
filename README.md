# DIPLOMA
The final project of the course!

# **Habit Tracker App**

## **Технологии**

* **Backend** : Laravel 10, PHP 8.2
* **Frontend** : Vue.js 3, Pinia, Vite
* **База данных** : SQLite
* **Сервер** : Nginx
* **Контейнеризация** : Docker


## **Запуск проекта**

### **1. Локальный запуск (без Docker)**

#### **Требования**

- PHP 8.2, Composer
- Node.js 18+, npm
- SQLite

#### **Инструкция**

**1. Настройка бэкенда (Laravel)**

```bash
cd BACKEND/
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate
php artisan serve
```
Бэкенд будет доступен по адресу: [http://localhost:8000](http://localhost:8000)

**2. Настройка фронтенда (Vue.js)**

```bash
cd FRONTED/
npm install
npm run dev
```
Фронтенд будет доступен по адресу: [http://localhost:5173](http://localhost:5173)

### **2. Развертывание приложения с помощью Docker**

#### **Требования**

- Установленный Docker Desktop (или Docker Engine + Docker Compose)
- Git (для клонирования репозитория)

#### **Инструкция**

**1. Клонируйте репозиторий**

```bash
git clone https://github.com/AleksandraTahai/DIPLOMA.git
cd DIPLOMA
```

**2. Настройте окружение**

```bash
copy BACKEND\.env.example BACKEND\.env
```

**3. Создайте файл базы данных**

```bash
mkdir BACKEND/database
type nul > BACKEND/database/database.sqlite
```

**4. Запуск и сборка контейнеров**

```bash
docker-compose up -d --build
```

**5. Установка зависимостей**

```bash
docker-compose exec habit-backend composer install
docker-compose exec habit-frontend npm install
```

**6. Генерация ключа приложения и миграции**

```bash
docker-compose exec habit-backend php artisan key:generate
docker-compose exec habit-backend php artisan migrate
```

**7. Перезапуск контейнеров (при необходимости)**

```bash
docker-compose down
docker-compose up -d
```

## **Доступ к приложению**

- **Бэкенд (API)**: [http://localhost:8000](http://localhost:8000)
- **Фронтенд**: [http://localhost:5173](http://localhost:5173)


## **Команды управления**

🔹 Запуск контейнеров:

```bash
docker-compose up -d
```

🔹 Остановка контейнеров:

```bash
docker-compose down
```

🔹 Просмотр логов:

```bash
docker-compose logs -f
```

🔹 Проверка контейнеров:

```bash
docker-compose ps
```

🔹 Пересборка контейнеров:

```bash
docker-compose up -d --build
```

🔹 Перезапуск контейнера:

```bash
docker-compose restart [имя_контейнера]
```
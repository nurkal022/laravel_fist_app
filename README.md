# 📚 Журнал посещаемости для центра образования

[![Laravel](https://img.shields.io/badge/Laravel-10.49.1-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![SQLite](https://img.shields.io/badge/Database-SQLite-green.svg)](https://sqlite.org)

Веб-приложение для учета посещаемости студентов в образовательных центрах. Разработано на **Laravel 11** с использованием **SQLite** базы данных.

## ✨ Возможности

### 👥 Управление студентами
- ✅ Добавление новых студентов с контактными данными
- ✅ Редактирование информации о студентах
- ✅ Просмотр детальной информации
- ✅ Мягкое удаление (деактивация)

### 📊 Отметка посещаемости
- ✅ Отметка посещаемости на текущий день
- ✅ Выбор любой даты для отметки
- ✅ 4 статуса посещаемости:
  - **Присутствовал** (present)
  - **Отсутствовал** (absent)
  - **Опоздал** (late)
  - **Освобожден** (excused)

### 📈 Отчеты и аналитика
- ✅ Отчеты по посещаемости за период
- ✅ Процент посещаемости для каждого студента
- ✅ Детальная история посещаемости
- ✅ Цветовая индикация (зеленый/желтый/красный)

## 🛠️ Технологии

- **Laravel 11.46.2** - PHP фреймворк
- **PHP 8.2+** - Серверный язык
- **SQLite** - База данных
- **Bootstrap 5** - CSS фреймворк
- **Blade** - Шаблонизатор

## 🚀 Быстрый старт

### Локальная установка

```bash
# Клонирование репозитория
git clone https://github.com/nurkal022/laravel_fist_app.git
cd laravel_fist_app

# Установка зависимостей
composer install

# Настройка окружения
cp .env.example .env
php artisan key:generate

# Создание базы данных
touch database/database.sqlite

# Запуск миграций
php artisan migrate

# Запуск сервера разработки
php artisan serve
```

Приложение будет доступно по адресу: `http://localhost:8000`

## 🌐 Развертывание на Plesk

Проект оптимизирован для развертывания на **Plesk** с **PHP 8.3.28**:

### Автоматическое развертывание через Git

1. **Добавьте репозиторий в Plesk Git:**
   - URL: `https://github.com/nurkal022/laravel_fist_app.git`
   - Branch: `main`

2. **Настройте Additional Deployment Actions:**
```bash
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
chmod 664 database/database.sqlite
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Ручное развертывание

```bash
# Загрузите файлы на сервер
# В корне сайта выполните:
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan storage:link
```

## 📁 Структура базы данных

### Таблица `students`
```sql
- id: INTEGER PRIMARY KEY
- name: VARCHAR (имя студента)
- phone: VARCHAR (телефон)
- email: VARCHAR (email)
- birth_date: DATE (дата рождения)
- notes: TEXT (заметки)
- active: BOOLEAN (активный/неактивный)
- timestamps: created_at, updated_at
```

### Таблица `attendances`
```sql
- id: INTEGER PRIMARY KEY
- student_id: INTEGER FOREIGN KEY
- date: DATE (дата посещаемости)
- status: ENUM ('present', 'absent', 'late', 'excused')
- notes: TEXT (заметки)
- timestamps: created_at, updated_at
```

## 🎨 Интерфейс

- **Responsive дизайн** с Bootstrap 5
- **Русскоязычный интерфейс**
- **Intuitive навигация**
- **Модальные окна** для подтверждений
- **Цветовая индикация** статусов

## 🔧 Настройка

### Переменные окружения (.env)

```env
APP_NAME="Журнал посещаемости"
APP_ENV=production
APP_KEY=your_app_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

LOG_CHANNEL=stack
CACHE_STORE=file
SESSION_DRIVER=file
```

## 📊 Использование

1. **Главная страница** → Список студентов
2. **Добавить студента** → Форма создания
3. **Отметить посещаемость** → Выбор даты и статусов
4. **Отчеты** → Аналитика посещаемости

## 🤝 Вклад в проект

1. Fork проект
2. Создайте feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit изменения (`git commit -m 'Add some AmazingFeature'`)
4. Push в branch (`git push origin feature/AmazingFeature`)
5. Откройте Pull Request

## 📝 Лицензия

Этот проект распространяется под лицензией MIT. Подробности в файле `LICENSE`.

## 👨‍💻 Автор

**nurkal022** - [GitHub](https://github.com/nurkal022)

## 🙏 Благодарности

- Laravel Framework
- Bootstrap
- SQLite
- Весь Open Source community

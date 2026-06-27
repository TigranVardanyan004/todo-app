```markdown
# Laravel To-Do Application 📝

A clean, responsive, and easy-to-use To-Do application built with Laravel and Tailwind CSS. This project serves as a practical demonstration of CRUD operations, database management, and professional documentation practices.

## 🚀 Tech Stack
- **Framework:** [Laravel 11](https://laravel.com/)
- **Styling:** [Tailwind CSS](https://tailwindcss.com/)
- **Database:** [SQLite](https://www.sqlite.org/)
- **Server:** PHP Built-in Server

## ✨ Key Features
- **Task Management:** Create and list your tasks effortlessly.
- **Status Toggle:** Mark tasks as complete/incomplete with visual feedback (strikethrough effect).
- **Responsive UI:** Clean design, functional on both desktop and mobile.
- **Zero Configuration:** Simple setup using SQLite.


## 🛠 Prerequisites
Ensure you have the following installed on your machine:
- PHP (v8.1+)
- Composer

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <https://github.com/TigranVardanyan004/todo-app>
   cd todo-app

```

2. **Install Dependencies:**
```bash
composer install

```


3. **Environment Setup:**
```bash
cp .env.example .env
php artisan key:generate

```


4. **Database Configuration:**
* Ensure `DB_CONNECTION=sqlite` is set in your `.env` file.
* Run the migration to set up the tasks table:


```bash
touch database/database.sqlite
php artisan migrate

```


5. **Start the Development Server:**
```bash
php artisan serve

```

6. **Access the App:**
Navigate to [http://localhost:8000](https://www.google.com/search?q=http://localhost:8000) in your browser.

```
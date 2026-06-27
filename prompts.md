```markdown
# AI-Assisted Workflow Documentation

This document records the step-by-step AI-assisted workflow used to build the Laravel To-Do application.

---

## 1. Project Creation

**Prompt:**
> I am starting a technical internship task to build a simple To-Do web application. I need to use Laravel. How do I create a new Laravel project named 'todo-app' using Composer on my Mac terminal?

**AI Response (Summarized):**
To create a new Laravel project named `todo-app` using Composer, run the following commands:
```bash
cd ~/Desktop
composer create-project laravel/laravel todo-app
cd todo-app
php artisan serve
```

**Result/Adjustments:**
Worked on the first try. The Laravel project was successfully created and the development server started locally on port 8000.

---

## 2. Database and Model Setup

**Prompt:**
> The Laravel project is ready. Now, I want to use SQLite for my database. How do I configure it? After that, how do I create a Model and a Migration file for a 'Task'? A task should have a 'title' (string) and a 'completed' status (boolean, default false).

**AI Response:**
1. Update `.env` to use SQLite:
```env
DB_CONNECTION=sqlite
```
2. Create the database file:
```bash
touch database/database.sqlite
```
3. Create the Model and Migration:
```bash
php artisan make:model Task -m
```
4. Update the Migration file (`..._create_tasks_table.php`):
```php
public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->boolean('completed')->default(false);
        $table->timestamps();
    });
}
```
5. Run the Migration:
```bash
php artisan migrate
```

**Result/Adjustments:**
At first, I couldn't find the `_create_tasks_table.php` file. The AI clarified that migration files are prefixed with a timestamp (e.g., `2026_06_27_...`). Once identified, the migration worked perfectly.

---

## 3. Controller and Routes

**Prompt:**
> The database is ready. Now I need a Controller to manage the tasks and the routes to access them. Please give me the Artisan command to create a TaskController. Then, generate the code for this controller to handle displaying all tasks, storing a new task, and toggling a task's 'completed' status. Also, provide the exact code I need to add to my routes/web.php file.

**AI Response:**
1. Create Controller:
```bash
php artisan make:controller TaskController
```
2. `app/Http/Controllers/TaskController.php`:
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('tasks', compact('tasks'));
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required|string|max:255']);
        $task = new Task();
        $task->title = $request->title;
        $task->save();
        return back();
    }

    public function toggle(Task $task) {
        $task->completed = !$task->completed;
        $task->save();
        return back();
    }
}
```
3. `routes/web.php`:
```php
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
```

**Result/Adjustments:**
Code implemented successfully, but led to an error in the next steps (documented in the Debugging section).

---

## 4. User Interface (Blade & Tailwind)

**Prompt:**
> The controller and routes are set up. Now, please generate the code for the Blade view file (resources/views/tasks.blade.php) to display the UI. It must include a form to add a new task, a list displaying all existing tasks, and a form/button to mark any item as completed. Please use Tailwind CSS via CDN for basic styling, and ensure that completed tasks have a visual distinction (like a strikethrough on the text).

**AI Response:**
Create `resources/views/tasks.blade.php`:
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel To-Do App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800">
    <div class="container mx-auto mt-10 max-w-md">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6 text-center">My Tasks</h1>

            <form action="{{ route('tasks.store') }}" method="POST" class="mb-6 flex">
                @csrf
                <input type="text" name="title" placeholder="Add a new task..." required
                       class="flex-grow border border-gray-300 rounded-l-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-md">Add</button>
            </form>

            <ul>
                @forelse($tasks as $task)
                    <li class="flex items-center justify-between p-3 mb-2 bg-gray-50 rounded-md border border-gray-200">
                        <span class="{{ $task->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                            {{ $task->title }}
                        </span>
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm px-3 py-1 rounded-md transition-colors 
                                {{ $task->completed ? 'bg-gray-300 text-gray-700 hover:bg-gray-400' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                {{ $task->completed ? 'Undo' : 'Complete' }}
                            </button>
                        </form>
                    </li>
                @empty
                    <p class="text-center text-gray-500 py-4">No tasks yet. Add one!</p>
                @endforelse
            </ul>
        </div>
    </div>
</body>
</html>
```

**Result/Adjustments:**
Worked as expected. The UI was fully styled and responsive.

---

## 5. Debugging (500 Internal Server Error)

**Prompt:**
> I tried to run the application, but I got a 500 error. The exception trace points to my TaskController.php at line 13: "$tasks = Task::orderBy('created_at', 'desc')->get();". What are the most likely causes for this error and how can I fix it?

**AI Response:**
A 500 Error here usually means Laravel cannot find the `Task` model. 
* **The Fix:** Open `app/Http/Controllers/TaskController.php` and make sure you have imported the model at the top of the file:
```php
use App\Models\Task;
```

**Result/Adjustments:**
Applying this fix resolved the issue immediately. The missing model import was the root cause.

---

## 6. Documentation Generation

**Prompt:**
> The To-Do application is now working perfectly. As the final deliverable for my internship task, I need to provide a README.md file. Please generate the Markdown content for this file. It should include clear, step-by-step instructions on how someone else can set up and run this Laravel project locally from scratch.

**AI Response:**
*The AI provided the professional README file template outlining setup instructions, configuration, and execution commands (See `README.md` file in the repository).*
```
```bash
git add prompts.md
git commit -m "Fix markdown formatting in prompts.md"
git push origin main
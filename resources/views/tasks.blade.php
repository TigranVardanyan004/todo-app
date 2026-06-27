<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-md">
                    Add
                </button>
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
                    <p class="text-center text-gray-500 py-4">No tasks yet. Add one above!</p>
                @endforelse
            </ul>
        </div>
    </div>
</body>
</html>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks List') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            {{-- Form to Add a Task --}}
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('todo.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" name="title" class="form-control" placeholder="Add new task..." required>
                                </div>

                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Add Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Filter Dropdown --}}
            <div class="row justify-content-center mb-4">
                <div class="col-md-6 col-lg-4">
                    <form method="GET" action="{{ route('todo.index') }}">
                        <div class="input-group">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Filter by Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Task List --}}
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Your Tasks</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            @forelse ($tasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $task->title }}</strong>
                                        <div class="text-muted small">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</div>
                                    </div>
                                    {{-- Status Dropdown --}}
                                        <form action="{{ route('todo.update', $task->id) }}" method="POST" class="d-flex align-items-center ms-3">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </form>
                                    {{-- Delete Button --}}
                                        <form action="{{ route('todo.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    {{-- Edit Button --}}
                                        <a href="{{ route('todo.edit', $task->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                </li>
                            @empty
                                <li class="list-group-item text-center text-muted">No tasks yet.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

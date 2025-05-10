@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Todos</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('todos.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Add Todo</button>
                    </form>

                    <hr>

                    <ul class="list-group mt-3">
                        @foreach($todos as $todo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $todo->title }}</h5>
                                <p>{{ $todo->description }}</p>
                                <small>Due: {{ $todo->due_date->format('Y-m-d H:i') }}</small>
                            </div>
                            <div>
                                <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
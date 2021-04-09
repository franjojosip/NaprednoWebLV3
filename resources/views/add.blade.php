@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form method="POST" action="{{ url('/projects/insert') }}">
                    {{csrf_field()}}
                    @if(count($errors) > 0)
                    <div class="modal-header">
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="modal-header">
                        <h4 class="modal-title">Add Project</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" value="{{ old('description') }}" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tasks done</label>
                            <textarea class="form-control" name="tasks_done" value="{{ old('tasks_done') }}" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Collaborators</label>
                            <select multiple class="form-control" name="users[]" required>
                                <option value="">
                                    No collaborators
                                </option>
                                @foreach ($users as $key => $value)
                                <option value="{{ $key }}">
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/projects') }}" type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">Back</a>

                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form method="post" action="{{ url('/projects/edit', array($project->id)) }}">
                    {{csrf_field()}}
                    @method('PUT')
                    @if(count($errors) > 0)
                    <div class="modal-header">
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                    @endif
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Project</h4>
                    </div>
                    <div class="modal-body">
                        @if ($project->isOwner)
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $project->name; ?>">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description"><?php echo $project->description; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tasks Done</label>
                            <textarea class="form-control" name="tasks_done" required><?php echo $project->tasks_done; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Collaborators</label>
                            <select multiple class="form-control" name="users[]">
                                <option value="">
                                    No collaborators
                                </option>
                                @foreach ($users as $key => $value)
                                <option value="{{ $key }}" {{ in_array($key, $selected_user_ids) == 1 ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?php echo $project->price; ?>">
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo date("Y-m-d", strtotime($project->start_date)); ?>">
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo date("Y-m-d", strtotime($project->end_date)); ?>">
                        </div>
                        @elseif($project->isCollaborator)
                        <div class="form-group">
                            <label>Tasks Done</label>
                            <textarea class="form-control" name="tasks_done" required><?php echo $project->tasks_done; ?></textarea>
                        </div>
                        @endif
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
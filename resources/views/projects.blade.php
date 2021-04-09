@extends('layouts.app')

@section('content')
@if(session('info'))
<div class="alert alert-success">
    {{session('info')}}
</div>
@endif
@if(session('danger'))
<div class="alert alert-danger">
    {{session('danger')}}
</div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span style="font-size:large">{{ __('Projects') }}</span>
                    <a class="btn btn-small btn-success" style="float:right;" href="{{ url('/projects/add') }}">Add</a>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td style="text-align:center">Project Name</td>
                            <td style="text-align:center">Role</td>
                            <td style="text-align:center">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($projects) > 0)
                        @foreach($projects as $project)
                        <tr>
                            <td style="text-align:center">{{$project->name}}</td>
                            <td style="text-align:center">
                                @if($project->isOwner)
                                    Owner
                                @else
                                    Member
                                @endif
                            </td>
                            <td style="text-align:center">
                                <a class="btn btn-small btn-info" href="{{ url('projects/update/' . $project->id) }}">Edit</a>
                                @if($project['isOwner'])
                                <a class="btn btn-small btn-danger" href="{{ url('projects/delete/' . $project->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td style="text-align:center"><b>No projects</b></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
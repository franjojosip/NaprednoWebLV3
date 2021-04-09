<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::all();
        foreach ($projects as $key => $project) {
            $index = 0;
            $collaborators = array();
            $users = User::all()->pluck('name', 'id');

            //Check if there is any project collaborator
            if (count($project->users()->get()) > 0) {
                //Filter users for preselect in dropdown
                foreach ($users as $user) {
                    $collaborator = $project->users->filter(function ($item) use ($user) {
                        return $user == $item->name;
                    })->first();

                    if ($collaborator != null) {
                        $collaborators[] = $collaborator->getAttributes()['name'];
                    }
                    $index++;
                }
            }
            $project['isOwner'] = $project->owner_id == Auth::id();
            $project['collaborators'] = implode(", ", $collaborators);

            //If user is not an owner or collaborator to that project remove it
            if (!$project['isOwner'] && !in_array(Auth::user()->name, $collaborators)) {
                unset($projects[$key]);
            }
        }

        return view('projects')->with('projects', $projects);
    }

    public function add()
    {
        $users = User::where('id', '!=', Auth::id())->get()->pluck('name', 'id');
        return view('add')->with('users', $users);
    }

    public function create(Request $request)
    {
        $project = new Project;
        $project->owner()->associate(Auth::user());
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->tasks_done = $request->input('tasks_done');
        $project->price = $request->input('price');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');
        $project->save();

        $users = User::whereIn('id', $request->input('users'))->get()->pluck('name', 'id');

        //Save users associated with a created project
        $project->users()->attach(array_keys($users->toArray()));
        $project->save();

        return redirect('/projects')->with('info', 'Project saved successfully!');
    }

    public function update($id)
    {
        $project = Project::find($id);
        if ($project == null) {
            return redirect('/');
        }

        $users = User::where('id', '!=', Auth::id())->get()->pluck('name', 'id');
        $project_users = $project->users()->get();
        if ($project_users != null) {
            $selected_user_ids = $project_users->pluck('id')->toArray();
        } else {
            $selected_user_ids = array();
        }
        //Owner can edit everything and collaborator can only update specific fields
        if ($project->owner_id == Auth::id()) {
            $project['isOwner'] = true;
        } else if (in_array(Auth::id(), $selected_user_ids)) {
            $project['isCollaborator'] = true;
        } else {
            //If unauthorized user tries to reach update project page redirect to main page
            return redirect('/');
        }
        return view('update', compact('project', 'users', 'selected_user_ids'));
    }

    public function edit(Request $request, $id)
    {
        $project = Project::find($id);

        //Owner can change all data
        if ($project->owner_id == Auth::id()) {

            $project->name = $request->input('name');
            $project->description = $request->input('description');
            $project->tasks_done = $request->input('tasks_done');
            $project->price = $request->input('price');
            $project->end_date = $request->input('start_date');
            $project->end_date = $request->input('end_date');
            $project->save();

            $users = User::whereIn('id', $request->input('users'))->get()->pluck('name', 'id');

            //Save collaborators
            if ($users != null) {
                $project->users()->sync(array_keys($users->toArray()));
            } else {
                $project->users()->sync(array());
            }
            $project->save();

        } else {
            //Collaborator can change only tasks_done
            $project->tasks_done = $request->input('tasks_done');
            $project->save();
        }
        return redirect('/projects')->with('info', 'Update successfully!');
    }

    public function delete($id)
    {
        $project = Project::find($id);
        //Delete if project exists
        if($project != null ){
            //Only owner can delete project
            if($project->owner_id == Auth::id()){
                Project::where('id', $id)->delete();
                return redirect('/projects')->with('info', 'Delete successfully');
            }
            else{
                return redirect('/projects')->with('danger', 'Only project owner can delete project');
            }
        }
        else return redirect('/projects');
    }
}

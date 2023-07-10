<?php

namespace App\Http\Controllers;

use App\Jobs\VideoJob;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Get the list of projects for the authenticated user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $projects = $user->projects()->get();

        return response()->json([
            'projects' => $projects
        ]);
    }

    /**
     * Store a new project for the authenticated user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:projects,name|min:5|max:100',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $request->user()->projects()->create($validator->validated());

        return response()->json([], 204);
    }

    /**
     * Save layers for a project.
     *
     * @param  Project  $project
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Project $project, Request $request)
    {
        $layers = $request->get('layers');

        $project->layers()->saveMany($layers);

        return response()->json(null, 204);
    }

    /**
     * Render the project.
     *
     * @param  Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Project $project)
    {
        VideoJob::dispatch($project);

        return response()->json(null, 204);
    }

    /**
     * Delete a project.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $project = Project::where('id', $id)->first();

        if ($project) {
            $project->delete();
            return response()->json([], 204);
        }
    }
}

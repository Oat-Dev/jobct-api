<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\Job as ResourcesJob;
use App\Http\Resources\JobCollection;
use App\Models\Company;
use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobs = Cache::tags(['job'])->remember($this->getCacheKey(), config('cache.lifetime', 1800), function () use ($request) {
            $query = Job::where([]);

            if ($request->input('search')) {
                $query = $query
                    ->where('name', 'ILIKE', '%' . $request->input('search') . '%');
            }
            if ($request->input('optional_work_from_home')) {
                $query = $query
                    ->where('optional_work_from_home', $request->input('optional_work_from_home'));
            }
            if ($request->input('salary')) {
                $query = $query
                    ->where('salary', '<=', $request->input('salary'));
            }

            return $query->paginate(6);
        });
        return new JobCollection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\StoreJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        try {
            $user_id = auth()->user()->id;
            $company_id = DB::table('companies')->select('id')->where('user_id', $user_id)->get();
            $validated = $request->validated();
            $validated['company_id'] = $company_id[0]->id;
            $job = Job::create($validated);
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }
        return redirect('jobs')->with(new ResourcesJob($job));
    }

    /**
     * Job Post
     * 
     * @urlParam id integer required Example: 1
     *
     * @apiResource App\Http\Resources\Job
     * @apiResourceModel App\Models\Job
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $job = Cache::tags(['job'])->remember($this->getCacheKey(), config('cache.lifetime', 1800), function () use ($id) {
            return Job::findOrFail($id);
        });

        return new ResourcesJob($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Http\Requests\UpdateJobRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobRequest $request, $id)
    {
        $validated = $request->validated();

        $job = Job::findOrFail($id);

        return new ResourcesJob(
            $job->update($validated)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
    }
}

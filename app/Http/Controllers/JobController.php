<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\Job as ResourcesJob;
use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\StoreJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        // $user_id = auth()->user()->id;
        // $company_id = DB::table('companies')->select('id')->where('user_id', $user_id)->get();
        // $validated = $request->validated();
        // $validated['company_id'] = $company_id[0]->id;
        try {
            $user_id = auth()->user()->id;
            $company_id = DB::table('companies')->select('id')->where('user_id', $user_id)->get();
            $validated = $request->validated();
            $validated['company_id'] = $company_id[0]->id;
            // return dd($validated);
            $job = Job::create($validated);
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }
        return redirect('jobs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ResourcesJob(
            Job::find($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $job = Cache::tags(['job'])->remember($this->getCacheKey(), config('cache.lifetime', 1800), function () use ($id) {
            try {
                $job = Job::find($id);
            } catch (Exception $e) {
                return response()->json([
                    'type' => 'error',
                    'title' => 'Failed',
                    'message' => $e->getMessage(),
                ], 400);
            }

            return $job;
        });

        return view('jobs.edit', compact(['job']));
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
        // $validated = $request->validated();

        // $job = Job::findOrFail($id);

        // return new ResourcesJob(
        //     $job->update($validated)
        // );

        try {
            $user_id = auth()->user()->id;
            $company_id = DB::table('companies')->select('id')->where('user_id', $user_id)->get();
            $validated = $request->validated();
            $validated['company_id'] = $company_id[0]->id;
            $job = Job::findOrFail($id);
            $job->update($validated);
            Cache::tags(['job'])->flush();
        } catch (Exception $e) {
            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Failed',
                    'message' => $e->getMessage(),
                ]
            ]);
        }
        return redirect('jobs')->with([
            'toastr' => [
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Updated an job successfully.',
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Job::findOrFail($id)->delete();
            Cache::tags(['job'])->flush();
        } catch (Exception $e) {
            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Failed',
                    'message' => $e->getMessage(),
                ]
            ]);
        }
        return redirect()->back()->with([
            'toastr' => [
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Delete an article successfully.',
            ]
        ]);
    }
}

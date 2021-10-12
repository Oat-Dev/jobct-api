<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Resources\Applicant as ResourceApplicant;
use App\Http\Resources\ApplicantCollection;
use App\Mail\NewApplicantByUser;
use App\Mail\NewApplicantForCompany;
use App\Models\Applicant;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\StoreApplicantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register_job(StoreApplicantRequest $request, $id)
    {
        try {
            $amount_job = Job::find($id)->amount;

            if ($amount_job <= 0) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'amount full',
                    'message' => 'job amount is full',
                ], 400);
            } else {
                $validated = $request->validated();
                $user = User::find(auth()->user()->id);
                $validated['created_at'] = Carbon::now();
                $validated['updated_at'] = Carbon::now();
                $user->jobs()->save(Job::findOrFail($id), $validated);
                $user->save();
                //update cv_path -> user
                if ($request->cv_path) {
                    $uploadFolder = 'resume/images';
                    $image = $request->file('cv_path');
                    $path =  Storage::disk('do_spaces')->put($uploadFolder, $image, 'public');
                } else {
                    $path = null;
                }
                $cv_path['cv_path'] = $path;
                $user_id = User::findOrFail(auth()->user()->id);
                // $user_id = User::findOrFail($user_id);

                $user_id->update($cv_path);
                //update amount job
                $subtract_amount_job = $amount_job - 1;
                $job = Job::find($id);
                $job->amount = $subtract_amount_job;
                $job->save();
                $job = Job::find($id);
                $company = Company::find($job->company_id);
                $user = User::find(auth()->user()->id);
                $applicant = Applicant::where('model_id', auth()->user()->id)->latest('updated_at')->get();
                Mail::to(auth()->user()->email)->send(new NewApplicantByUser($job, $user, $company));
                Mail::to($company->email)->send(new NewApplicantForCompany($job, $user, $company,$applicant));
            }
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'type' => 'Success',
            'title' => 'applicant apply job',
            'message' => 'applicant is apply jobs success',
        ], 201);
    }

    public function index()
    {
        $applicants = Applicant::where('model_id', auth()->user()->id)->get();

        return new ApplicantCollection($applicants);
    }

    /**
     * Applicant Post
     * 
     * @urlParam id integer required Example: 1
     *
     * @apiResource App\Http\Resources\Applicant
     * @apiResourceModel App\Models\Job
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $applicant = Cache::tags(['applicant'])->remember($this->getCacheKey(), config('cache.lifetime', 1800), function () use ($id) {
            return Applicant::find($id);
        });

        return new ResourceApplicant($applicant);
    }
}

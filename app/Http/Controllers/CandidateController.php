<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandidateController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('candidates.index');
    }

    public function edit($id)
    {
        return view('candidates.edit', [
            'applicant' => Applicant::find($id)
        ]);
    }

    public function interview($id)
    {
        return view('candidates.date-interview-setting', [
            'applicant' => Applicant::find($id)
        ]);
    }

    public function approve()
    {
        return view('candidates.candidates-approve-lists', [
            'applicants' => auth()->user()->company->applicants
        ]);
    }

    public function finish()
    {
        return view('candidates.candidates-finish-lists', [
            'applicants' => auth()->user()->company->applicants
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
            $user = User::find(auth()->user()->id);
            $user->jobs()->detach($id);
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
                'title' => 'Created',
                'message' => 'Create an article successfully.',
            ]
        ]);
    }
}

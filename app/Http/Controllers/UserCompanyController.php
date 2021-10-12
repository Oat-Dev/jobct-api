<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Resources\User as ResourcesUser;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserCompanyController extends Controller
{

    /**
     * Register Applicant user API
     * @param Request $request
     * @return Response
     */
    public function register(RegisterCompanyRequest $request)
    {
        try {
            $request['type'] = 'customer';
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $validated['type'] = $request['type'];
            if ($request->profile_photo_path) {
                $uploadFolder = 'companies/images';
                $image = $request->file('profile_photo_path');
                $path =  Storage::disk('do_spaces')->put($uploadFolder, $image, 'public');
            } else {
                $path = null;
            }
            $user = User::create($validated);
            $user->assignRole($request->input('type'));

            if ($validated['type'] == 'customer') {
                $user_company = new ResourcesUser($user);
                $validated['company']['user_id'] = $user_company->id;
                $validated['company']['name'] = $validated['name'];
                $validated['company']['email'] = $validated['email'];
                $validated['company']['tel'] = $validated['tel'];
                $validated['company']['profile_photo_path'] = $path;
                $validated['company']['address'] = $validated['address'];
                $validated['company']['area_province_id'] = $validated['area_province_id'];
                $validated['company']['area_district_id'] = $validated['area_district_id'];
                $validated['company']['area_sub_district_id'] = $validated['area_sub_district_id'];
                // return dd($validated['company']);
                $company = Company::create($validated['company']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with([
                'toastr' => [
                    'type' => 'error',
                    'title' => 'Failed',
                    'message' => $e->getMessage(),
                ]
            ]);
        }
        return redirect('login')->with([
            'toastr' => [
                'type' => 'success',
                'title' => 'Register',
                'message' => 'Register an company successfully.',
            ]
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        // auth::guard('api')->logout();

        return redirect('login')->with([
            'toastr' => [
                'type' => 'success',
                'title' => 'Logout',
                'message' => 'Logout is successfully.',
            ]
        ]);
    }

    /**
     * Delete user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // $user = User::find(Auth::user()->$id);
        // Auth::logout();

        // if ($user->delete()) {
        //     return Redirect::route('/')->with('global', 'Your account has been deleted!');
        // }
        User::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully User delete'
        ], 200);
    }
}

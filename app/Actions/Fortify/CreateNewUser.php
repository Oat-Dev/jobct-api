<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Company;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Http\Resources\User as ResourcesUser;
use App\Http\Resources\Company as ResourcesCompany;
use Exception;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     * @return \App\Models\Company
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            //company
            'tel' => 'string',
            'address' => 'string',
            'area_province_id' => 'numeric',
            'area_district_id' => 'numeric',
            'area_sub_district_id' => 'numeric',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();
        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'type' => 'customer',
            ]);

            $user->assignRole($user['type']);

            $company = Company::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'tel' => $input['tel'],
                'address' => $input['address'],
                'area_province_id' => $input['area_province_id'],
                'area_district_id' => $input['area_district_id'],
                'area_sub_district_id' => $input['area_sub_district_id'],
            ]);
            $company->user()->associate($user);
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'users' => new ResourcesUser($user),
            'company' => new ResourcesCompany($company),
        ]);
    }
}

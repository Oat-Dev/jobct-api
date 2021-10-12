<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\Company as ResourcesCompany;
use App\Http\Resources\CompanyCollection;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Cache::tags(['company'])->remember($this->getCacheKey(), config('cache.lifetime', 1800), function () use ($request) {
            $query = Company::where([]);

            // Search by text
            if ($request->input('search')) {
                $query = $query
                    ->where('name', 'ILIKE', '%' . $request->input('search') . '%');
            }

            return $query->paginate(6);
        });
        return new CompanyCollection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        // $validated = $request->validated();
        // $validated['user_id'] = auth()->user()->id;
        try {
            $validated = $request->validated();
            $validated['user_id'] = auth()->user()->id;
            $company = Company::create($validated);
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }

        return new ResourcesCompany($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ResourcesCompany(
            Company::find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Http\Requests\UpdateCompanyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $validated = $request->validated();

        $company = Company::findOrFail($id);

        return new ResourcesCompany(
            $company->update($validated)
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
        Company::findOrFail($id)->delete();
    }
}

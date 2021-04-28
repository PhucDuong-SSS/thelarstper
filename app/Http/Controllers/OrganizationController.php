<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\UpdateOrganizationResquest;
use App\Http\Services\OrganizationService;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizationController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
        $this->authorizeResource(Organization::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations =  $this->organizationService->getAll();
        return response()->json([
            'success' => true,
            'message' => 'Users get all successfully',
            'data' => $organizations
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrganizationRequest $request)
    {
        $organization = $this->organizationService->store($request);
        return response()->json([
            'success' => true,
            'message' => 'Organization was created successfully',
            'data' => $organization
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $id = $organization->id;
        $organization = $this->organizationService->find($id);
        return response()->json([
            'success' => true,
            'message' => 'Organization was found successfully',
            'data' => $organization
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationResquest $request, Organization $organization)
    {
        $id = $organization->id;
        $organization = $this->organizationService->update($request, $id);
        return response()->json([
            'success' => true,
            'message' => 'Organization was updated successfully',
            'data' => $organization
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $id = $organization->id;
        $organization = $this->organizationService->delete($id);
        return response()->json([
            'success' => true,
            'message' => 'Organization was deleted successfully',
            'data' => $organization
        ], 200);
    }
}

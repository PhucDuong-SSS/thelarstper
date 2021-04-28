<?php

namespace App\Http\Services;

use App\Models\Organization;

class OrganizationService
{
    protected $organizationModel;

    public function __construct(Organization $organizationModel)
    {
        $this->organizationModel = $organizationModel;
    }

    public function getAll()
    {
        $organizations = $this->organizationModel->all();
        return $organizations;
    }

    public function find($id)
    {
        $organization = Organization::findOrFail($id);
        return $organization;
    }

    public function delete($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return $organization;
    }
    public function store($request)
    {
        $organization = new Organization();
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->address = $request->address;
        $organization->phone = $request->phone;
        $organization->save();
        return $organization;
    }

    public function update($request, $id)
    {
        $organization = Organization::findOrFail($id);
        if ($request->has('name')) {
            $organization->name = $request->name;
        }
        if ($request->has('email')) {
            $organization->email = $request->email;
        }
        if ($request->has('address')) {
            $organization->address = $request->address;
        }
        if ($request->has('phone')) {
            $organization->phone = $request->phone;
        }
        $organization->save();
        return $organization;
    }
}

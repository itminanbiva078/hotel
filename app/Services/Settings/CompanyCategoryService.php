<?php

namespace App\Services\Settings;

use App\Repositories\Settings\CompanyCategoryRepositories;

class CompanyCategoryService
{

    /**
     * @var CompanyCategoryRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CompanyCategoryRepositories $vehicleRepositories
     */
    public function __construct(CompanyCategoryRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        return $this->systemRepositories->getList($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getNavigation()
    {
        return $this->systemRepositories->getNavigation();
    }
    
    /**
     * @param $request
     * @return array
     */
    public function storeValidation($request)
    {
        return [
            'name'               => 'required',
            'flug'              => 'required',
            'status'                 => 'nullable',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function updateValidation($request, $id)
    {
        return [
            'name'               => 'required',
            'flug'              => 'required',
            'status'                 => 'nullable',
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Currency
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Currency
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }


    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
    }




    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
}
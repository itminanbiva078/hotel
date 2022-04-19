<?php

namespace App\Services\Usermanage;

use App\Repositories\Usermanage\CompanyResourceRepositories;
use App\Rules\PhoneNumberValidationRules;
use Illuminate\Support\Facades\Validator;

class CompanyResourceRoleService
{


    /**
     * @var CompanyResourceRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param CompanyResourceRepositories $systemRepositories
     */
    public function __construct(CompanyResourceRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getCompanyCategory()
    {
        return $this->systemRepositories->getCompanyCategory();
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
    public function getFormProperty($company_id)
    {
        return $this->systemRepositories->getFormProperty($company_id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllRole()
    {
        return $this->systemRepositories->getAllRole();
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
     * @return array
     */
    public function storeValidation($request)
    {
        return [
            'company_category'           => 'required',
            'permission'                 => 'required|array|min:1',
            'permission.*'               => 'required|distinct|min:1',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function updateValidation($request, $id)
    {
        return [
            'company_category'                  => 'required',
            'permission'                 => 'required|array|min:1',
            'permission.*'               => 'required|distinct|min:1',
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Branch
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Branch
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
<?php
namespace App\Services\InventorySetup;
use App\Repositories\InventorySetup\FloorRepositories;
class FloorService
{
    /**
     * @var FloorRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param FloorRepositories $floorRepositories
     */
    public function __construct(FloorRepositories $systemRepositories)
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
     * 
     * @param $request
     * @return mixed
     */
    public function getActiveFloor()
    {
        return $this->systemRepositories->getActiveFloor();
    }
     
    /**
     * 
     * @param $request
     * @return mixed
     */
    public function implodeFloor($request)
    {
        return $this->systemRepositories->implodeFloor($request);
    }
    /**
     * 
     * @param $request
     * @return mixed
     */
    public function explodeFloor()
    {
        return $this->systemRepositories->explodeFloor();
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
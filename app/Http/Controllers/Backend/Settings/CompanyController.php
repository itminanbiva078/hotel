<?php

namespace App\Http\Controllers\Backend\Settings;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\CompanyService;
use App\Transformers\CompanyTransformer;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{

    /**
     * @var CompanyService
     */
    private $systemService;
    /**
     * @var CompanyTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param CompanyService $systemService
     * @param CompanyTransformer $systemTransformer
     */
    public function __construct(CompanyService $companyService, CompanyTransformer $companyTransformer)
    {
        $this->systemService = $companyService;
        $this->systemTransformer = $companyTransformer;
    }
    public function index(Request $request)
    {
        $title = 'Company List';
        $datatableRoute = 'settings.company.dataProcessingCompany';
        return view('backend.pages.settings.company.index', get_defined_vars());
    }

    public function dataProcessingCompany(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Add New Company';
        $formInput =  helper::getFormInputByRoute();
        return view('backend.pages.settings.company.create', get_defined_vars());
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo =   $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        $title = 'Update Company';
        return view('backend.pages.settings.company.edit', get_defined_vars());
    }

 /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

      try {
            $this->validate($request, helper::isErrorStore($request));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->store($request);
        session()->flash('success', 'Data successfully save!!');
        return redirect()->route('settings.company.index');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!is_numeric($id)) {
            session()->flash('error', 'Edit id must be numeric!!');
            return redirect()->back();
        }
        $editInfo = $this->systemService->details($id);
        if (!$editInfo) {
            session()->flash('error', 'Edit info is invalid!!');
            return redirect()->back();
        }
        try {
            $this->validate($request, $this->systemService->updateValidation($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('settings.company.index');
    }
}
<?php
namespace App\Http\Controllers\Backend\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\GeneralSettingService;
use App\Transformers\GeneralSettingTransformer;
use Illuminate\Validation\ValidationException;
use helper;

class GeneralSettingsController extends Controller
{


    /**
     * @var GeneralSettingService
     */
    private $systemService;

    /**
     * @var GeneralSettingTransformer
     */
    private $systemTransformer;

    /**
     * GeneralSettingsController constructor.
     * @param GeneralSettingService $systemService
     * @param GeneralSettingTransformer $systemTransformer
     */
    public function __construct( GeneralSettingService $generalSettingService, GeneralSettingTransformer $generalSettingTransformer)
    {
       
        $this->systemService = $generalSettingService;
        $this->systemTransformer = $generalSettingTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Add New General Setup';
        $datatableRoute = 'settings.generalSetup.dataProcessingSetup';
        return view('backend.pages.settings.general_setup.index', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function dataProcessingSetup(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }

/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function create()
    {

        
        $title = 'Add New General Setup';
        $formInput =  helper::getFormInputByRoute();

        $allCategory = array();
        $allCategory = array();
        foreach($formInput as $key => $eachInput): 
           if(!empty($eachInput->category))
            array_push($allCategory,$eachInput->category);
        endforeach;
     $allCategory = array_unique($allCategory);


        return view('backend.pages.settings.general_setup.create', get_defined_vars());
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
        return redirect()->route('settings.generalSetup.index');
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
        $title = 'Setup Edit';
        $formInput =  helper::getFormInputByRoute();


        //dd($formInput);

        $allCategory = array();
        $allCategory = array();
        foreach($formInput as $key => $eachInput): 
           if(!empty($eachInput->category))
            array_push($allCategory,$eachInput->category);
        endforeach;
     $allCategory = array_unique($allCategory);

        return view('backend.pages.settings.general_setup.edit', get_defined_vars());
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
            $this->validate($request, helper::isErrorUpdate($request, $id));
        } catch (ValidationException $e) {
            session()->flash('error', 'Validation error !!');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        $this->systemService->update($request, $id);
        session()->flash('success', 'Data successfully updated!!');
        return redirect()->route('settings.generalSetup.index');
    }
/**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statusUpdate($id, $status)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $statusInfo =  $this->systemService->statusUpdate($id, $status);
        if ($statusInfo) {
            return response()->json($this->systemTransformer->statusUpdate($statusInfo), 200);
        }
    }
    
    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json($this->systemTransformer->invalidId($id), 200);
        }
        $detailsInfo =   $this->systemService->details($id);
        if (!$detailsInfo) {
            return response()->json($this->systemTransformer->notFound($detailsInfo), 200);
        }
        $deleteInfo =  $this->systemService->destroy($id);
        if ($deleteInfo) {
            return response()->json($this->systemTransformer->delete($deleteInfo), 200);
        }
    }
}
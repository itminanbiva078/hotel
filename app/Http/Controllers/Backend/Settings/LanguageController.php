<?php

namespace App\Http\Controllers\Backend\Settings;
use helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Settings\LanguageService;
use App\Transformers\LanguageTransformer;
use Illuminate\Validation\ValidationException;


class LanguageController extends Controller
{

    /**
     * @var LanguageService
     */
    private $systemService;
    /**
     * @var LanguageTransformer
     */
    private $systemTransformer;

    /**
     * CategoryController constructor.
     * @param LanguageService $systemService
     * @param LanguageTransformer $systemTransformer
     */
    public function __construct(LanguageService $languageService, LanguageTransformer $languageTransformer)
    {
        $this->systemService = $languageService;
        $this->systemTransformer = $languageTransformer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = 'Settings | Language - List';
        $explodeRoute = "";
        $createRoute = "settings.language.create";
        $datatableRoute = 'settings.language.dataProcessingLanguage';
        $columns = helper::getTableProperty();
        return view('backend.layouts.common.datatable.datatable', get_defined_vars());

    }


    public function dataProcessingLanguage(Request $request)
    {
        $json_data = $this->systemService->getList($request);
        return json_encode($this->systemTransformer->dataTable($json_data));
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Settings | Add New - Language";
        $listRoute = "settings.language.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "settings.language.store";
        $formInput =  helper::getFormInputByRoute();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());
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
        return redirect()->route('settings.language.index');
    }
    /**
     * @param $slug
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
        $title = "Settings | Edit - Language";
        $listRoute = "settings.language.index";
        $explodeRoute = "";
        $implodeModal ="";
        $storeRoute = "settings.language.update";
        $formInput =  helper::getFormInputByRoute();
       return view('backend.layouts.common.addEdit.addEditPage', get_defined_vars());
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
        return redirect()->route('settings.language.index');
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
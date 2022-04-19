<?php

namespace App\Repositories\Settings;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Currency;

class CurrencyRepositories
{
    /**
     * @var user_id
     */
    private $user_id;
    /**
     * @var Currency
     */
    private $currency;
    /**
     * CourseRepository constructor.
     * @param currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
        
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $columns = Helper::getQueryProperty();
        array_push($columns,"id");
        $edit = Helper::roleAccess('settings.currency.edit') ? 1 : 0;
        $delete = Helper::roleAccess('settings.currency.destroy') ? 1 : 0;
        $ced = $edit + $delete;

        $totalData = $this->currency::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $currencys = $this->currency::select($columns)->company()->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->currency::count();
        } else {
            $search = $request->input('search.value');
            $currencys = $this->currency::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->currency::select($columns)->company()->where(function ($q) use ($columns,$search) {
                $q->where('id', 'like', "%{$search}%");
                foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
                }
            })->count();
        }


        $columns = Helper::getTableProperty();
        $data = array();
        if ($currencys) {
            foreach ($currencys as $key => $currency) {
                $nestedData['id'] = $key + 1;
                foreach($columns as $key => $value ):
                    if($value == 'status'):
                if ($currency->status == 'Approved') :
                    $status = '<input class="status_row" status_route="' . route('settings.currency.status', [$currency->id, 'Inactive']) . '"   id="toggle-demo" type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                else :
                    $status = '<input  class="status_row" status_route="' . route('settings.currency.status', [$currency->id, 'Approved']) . '"  id="toggle-demo" type="checkbox" name="my-checkbox"  data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                endif;
            else:
                $nestedData[$value] = $currency->$value;
            endif;
        endforeach;
                $nestedData['status'] = $status;
                if ($ced != 0) :
                    if ($edit != 0)
                        $edit_data = '<a href="' . route('settings.currency.edit', $currency->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    else
                        $edit_data = '';
                   
                    if ($delete != 0)
                        $delete_data = '<a delete_route="' . route('settings.currency.destroy', $currency->id) . '" delete_id="' . $currency->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $currency->id . '"><i class="fa fa-times"></i></a>';
                    else
                        $delete_data = '';
                    $nestedData['action'] = $edit_data . ' ' . $delete_data;
                else :
                    $nestedData['action'] = '';
                endif;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
    }
    /**
     * @param $request
     * @return mixed
     */
    public function getAllList()
    {
        $result = $this->currency::where('status', 'Approved')->get();
        return $result;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->currency::find($id);
        return $result;
    }

    public function store($request)
    {
        $currency = new $this->currency();
        $currency->name = $request->name;
        $currency->currency_symbol = $request->currency_symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = 'Approved';
        $currency->created_by = helper::userId();
        $currency->company_id = helper::companyId();
        $currency->save();
        return $currency;
    }

    public function update($request, $id)
    {
        $currency = $this->currency::findOrFail($id);
        $currency->name = $request->name;
        $currency->currency_symbol = $request->currency_symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = 'Approved';
        $currency->updated_by = helper::userId();
        $currency->company_id = helper::companyId();
        $currency->save();
        return $currency;
    }

    public function statusUpdate($id, $status)
    {
        $currency = $this->currency::find($id);
        $currency->status = $status;
        $currency->save();
        return $currency;
    }

    public function destroy($id)
    {
        $currency = $this->currency::find($id);
        $currency->delete();
        return true;
    }
}
<?php

namespace Lincms\Controllers;

use Illuminate\Http\Request;
use Lincms\Models\LinUser;
use Lincms\Models\Log;

class LogController extends LinUser
{


    public function index()
    {

        $model = Log::query()->orderByDesc('id')->simplePaginate();
        $data['items'] = $model->items();
        $data['total'] = $model->count();
        return $data;
    }

    public function users()
    {
        $items = LinUser::query()->pluck('username');
        return compact('items');
    }


    public function search(Request $request)
    {
        $param = $request->all();
        $model = Log::list($param)->simplePaginate();
        $data['items'] = $model->items();
        $data['total'] = $model->count();

        return $data;
    }


}

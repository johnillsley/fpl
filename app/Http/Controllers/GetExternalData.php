<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ExternalData;

class GetExternalData extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($type)
    {
        if (!empty($type)) {
            $data = ExternalData::get($type);
        } else {
            $data = ExternalData::getall();
        }
        $display = "<pre>" . print_r($data, true) . "</pre>";
        return $display;
    }
}

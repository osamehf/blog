<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // store request instance
    public $request;

    // store service instance
    public $service;

    /**
     * set response from service
     * @return mixed
     */
    public function response($response = null)
    {
        $response = $response ? $response : $this->service->response;
        $status = $response['status'] ?? 200;
        return response([
            'message'   =>  $response['message'] ?? null,
            'data'    =>  $response['data'] ?? null,
            'status'    =>  $status,
        ], $status);
    }
}

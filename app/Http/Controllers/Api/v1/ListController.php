<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Models\Api\v1\Customer;
use App\Repositories\Api\v1\ListRepository;
use Exception;
use Illuminate\Http\Response;

class ListController extends Controller
{
    /** @var  ListRepository */
    private $listRepository;


    /**
     * __construct
     *
     * @param  mixed $listRepository
     * @return void
     */
    public function __construct(ListRepository  $listRepository)
    {
        $this->listRepository = $listRepository;
    }
    
    /**
     * generate dynamic link based on user inputs
     * generate
     *
     * @param  mixed $request
     * @return void
     */
    public function generate(ListRequest $request)
    {
        try {
            $result = $this->listRepository->create($request->all());
            if ($result['status']) {
                return Response::success($result['message']);
            }
        } catch (Exception $e) {
            return Response::failed($e->getMessage());
        }
    }
}

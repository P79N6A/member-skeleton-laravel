<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\User\DB\UserDBRepository;
use App\Repositories\User\Filter\UserFilter;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, UserDBRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        echo "Haody MSA php skeleton";

    }

    /**
     * 获取数据ORM Demo
     * @method get
     * @return \App\Library\Resources\Json\ResourceCollection
     */
    public function getUsers()
    {
        $userFilter = new UserFilter($this->request);
        $paginator = $this->repository->getPaginator($userFilter);
        return UserResource::collection($paginator);
    }
}

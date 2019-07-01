<?php

namespace App\Http\Controllers;

use App\Http\Response\Json;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Json
     */
    protected $jsonResponse;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param Json $jsonResponse
     */
    function __construct(UserService $userService, Json $jsonResponse) {
        $this->userService = $userService;
        $this->jsonResponse = $jsonResponse;
    }


    /**
     * @return Json
     */
    public function index() {
        return $this->jsonResponse->successfulStatus($this->userService->all());
    }
}

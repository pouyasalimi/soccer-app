<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Response\Json;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    /**
     * @var TeamService
     */
    protected $teamService;

    /**
     * @var Json
     */
    protected $jsonResponse;


    /**
     * TeamController constructor.
     *
     * @param TeamService $teamService
     * @param Json $jsonResponse
     */
    function __construct(TeamService $teamService, Json $jsonResponse) {
        $this->teamService = $teamService;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @return Json
     */
    public function index() {
        return $this->jsonResponse->successfulStatus($this->teamService->all());
    }

    /**
     * @param $id
     *
     * @return Json
     */
    public function show($id) {
        return $this->jsonResponse->successfulStatus($this->teamService->show($id));
    }

    /**
     * @param TeamRequest $request
     *
     * @return Json
     */
    public function store(TeamRequest $request) {
        return $this->jsonResponse->successfulStatus($this->teamService->create($request));
    }

    /**
     * @param TeamRequest $request
     * @param $id
     *
     * @return Json
     */
    public function update(TeamRequest $request, $id) {
        $result = $this->teamService->update($request, $id);
        if($result) {
            return $this->jsonResponse->successfulStatus($this->teamService->update($request, $id));
        }
        return $this->jsonResponse->failureStatus([], 'can\'t update player', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param $id
     *
     * @return Json
     */
    public function delete($id) {
        return $this->jsonResponse->successfulStatus($this->teamService->destroy($id), 'deleted!');
    }
}

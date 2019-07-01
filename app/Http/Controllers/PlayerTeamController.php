<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerTeamRequest;
use App\Http\Response\Json;
use App\Services\PlayerTeamService;
use Illuminate\Http\Request;

class PlayerTeamController extends Controller
{

    /**
     * @var PlayerTeamService
     */
    protected $playerTeamService;

    /**'
     * @var Json
     */
    protected $jsonResponse;

    /**
     * PlayerTeamController constructor.
     *
     * @param PlayerTeamService $playerTeamService
     * @param Json $jsonResponse
     */
    function __construct(PlayerTeamService $playerTeamService, Json $jsonResponse) {
        $this->playerTeamService = $playerTeamService;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @return Json
     */
    public function index() {
        return $this->jsonResponse->successfulStatus($this->playerTeamService->all());
    }

    /**
     * @param PlayerTeamRequest $request
     *
     * @return Json
     */
    public function store(PlayerTeamRequest $request) {
        $response = $this->playerTeamService->create($request);
        if($response) {
            return $this->jsonResponse->successfulStatus($response, 'player added to team successfully');
        }
        return $this->jsonResponse->successfulStatus($response, 'error adding player to team');
    }

    /**
     * @param $id
     *
     * @return Json
     */
    public function delete($id) {
        return $this->jsonResponse->successfulStatus($this->playerTeamService->delete($id), 'deleted!');
    }
}

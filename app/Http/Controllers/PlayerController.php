<?php

namespace App\Http\Controllers;

use App\Http\Requests\PictureRequest;
use App\Http\Requests\PlayerRequest;
use App\Http\Response\Json;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayerController extends Controller
{

    /**
     * @var PlayerService
     */
    protected $playerService;

    /**
     * @var Json
     */
    protected $jsonResponse;

    /**
     * PlayerController constructor.
     *
     * @param PlayerService $playerService
     * @param Json $jsonResponse
     */
    function __construct(PlayerService $playerService, Json $jsonResponse) {
        $this->playerService = $playerService;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @return Json
     */
    public function index() {
        return $this->jsonResponse->successfulStatus($this->playerService->all());
    }

    /**
     * @param $id
     *
     * @return Json
     */
    public function show($id) {
        return $this->jsonResponse->successfulStatus($this->playerService->show($id));
    }

    /**
     * @param PlayerRequest $request
     *
     * @return Json
     */
    public function store(PlayerRequest $request) {
        return $this->jsonResponse->successfulStatus($this->playerService->create($request));
    }

    /**
     * @param PlayerRequest $request
     * @param $id
     *
     * @return Json
     */
    public function update(PlayerRequest $request, $id) {
        $result = $this->playerService->update($request, $id);
        if($result) {
            return $this->jsonResponse->successfulStatus($this->playerService->update($request, $id));
        }
        return $this->jsonResponse->failureStatus([], 'can not update player', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param $id
     *
     * @return Json
     */
    public function delete($id) {
        return $this->jsonResponse->successfulStatus($this->playerService->destroy($id), 'deleted!');
    }

    /**
     * @param PictureRequest $request
     *
     * @return Json
     */
    public function picture(PictureRequest $request) {
        if ( ! $request->ajax() ) {
            return $this->jsonResponse->failureStatus([], 'can not upload file!', Response::HTTP_BAD_REQUEST);
        }
        $fileName = $this->playerService->handlePicture($request->get( 'picture' ));
        return $this->jsonResponse->successfulStatus([
            'picture' => $fileName,
            'pictureUrl' => asset('storage/pictures/' . $fileName),
        ] , 'uploaded!');
    }
}

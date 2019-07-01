<?php

namespace App\Services;

use App\Http\Requests\PlayerTeamRequest;
use App\Repositories\PlayerTeamRepository;

class PlayerTeamService extends Service
{

    /**
     * @var PlayerTeamRepository
     */
    private $playerTeamRepository;

    /**
     * PlayerTeamService constructor.
     *
     * @param PlayerTeamRepository $playerTeamRepository
     */
    public function __construct(PlayerTeamRepository $playerTeamRepository)
    {
        parent::__construct();
        $this->playerTeamRepository = $playerTeamRepository;
    }

    /**
     * @param PlayerTeamRequest $request
     *
     * @return mixed
     */
    public function create(PlayerTeamRequest $request) {
        return $this->playerTeamRepository->create($request->all());
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->playerTeamRepository->all();
    }

    /**
     * used hard delete (destroy)
     * @param $id
     *
     * @return mixed
     */
    public function delete($id) {
        return $this->playerTeamRepository->destroy($id);
    }
}

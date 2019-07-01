<?php

namespace App\Services;

use App\Http\Requests\TeamRequest;
use App\Repositories\TeamRepository;

class TeamService extends Service
{

    private $teamRepository;

    /**
     * TeamService constructor.
     *
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        parent::__construct();
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param TeamRequest $request
     *
     * @return mixed
     */
    public function create(TeamRequest $request) {
        return $this->teamRepository->create($request->all());
    }

    /**
     * @return \App\Models\Team[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->teamRepository->all();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id) {
        return $this->teamRepository->findOrFail($id);
    }

    /**
     * @param TeamRequest $request
     * @param $id
     *
     * @return mixed
     */
    public function update(TeamRequest $request, $id) {
        return $this->teamRepository->update(
            $id,
            $request->only(['name'])
        );
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function destroy($id) {
        return $this->teamRepository->destroy($id);
    }
}

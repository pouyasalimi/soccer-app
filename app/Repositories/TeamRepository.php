<?php

namespace App\Repositories;


use App\Contracts\Repositories\TeamRepositoryInterface;
use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface {

    /**
     * @var Team
     */
    protected $team;

    function __construct(Team $team) {
        $this->team = $team;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create( array $data ) {
        return $this->team->create( $data );
    }

    /**
     * @return Team[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->team->latest('id')->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOrFail($id) {
        return $this->team->findOrFail($id);
    }

    /**
     * @param $id
     * @param array $teamData
     *
     * @return mixed
     */
    public function update( $id, array $teamData) {
        return $this->findOrFail($id)->update($teamData);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->team->find($id);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function destroy($id) {
        $team = $this->find($id);
        if($team) {
            return $team->delete($id);
        }
        return false;
    }

    /**
     * get model
     * @return Team
     */
    public function getModel() {
        return $this->team;
    }
}

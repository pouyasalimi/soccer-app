<?php

namespace App\Repositories;


use App\Contracts\Repositories\PlayerTeamRepositoryInterface;
use App\Models\PlayerTeam;

class PlayerTeamRepository implements PlayerTeamRepositoryInterface {

    /**
     * @var PlayerTeam
     */
    protected $playerTeam;

    /**
     * PlayerTeamRepository constructor.
     *
     * @param PlayerTeam $playerTeam
     */
    function __construct( PlayerTeam $playerTeam ) {
        $this->playerTeam = $playerTeam;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create( array $data ) {
        $response = $this->playerTeam->create( $data );
        $response->team;
        $response->player->user;

        return $response;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->playerTeam->latest('id')->get()->map( function ( $playerTeam ) {
            $playerTeam->team;
            $playerTeam->player->user;

            return $playerTeam;
        } );
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find( $id ) {
        return $this->playerTeam->find( $id );
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function destroy( $id ) {
        $playerTeam = $this->find( $id );
        if ( $playerTeam ) {
            return $playerTeam->destroy( $id );
        }

        return false;
    }

    /**
     * @return PlayerTeam
     */
    public function getModel() {
        return $this->playerTeam;
    }
}

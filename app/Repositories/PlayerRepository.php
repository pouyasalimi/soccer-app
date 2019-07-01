<?php

namespace App\Repositories;


use App\Contracts\Repositories\PlayerRepositoryInterface;
use App\Models\Player;
use App\Models\User;

class PlayerRepository implements PlayerRepositoryInterface {

    /**
     * @var Player
     */
    protected $player;

    /**
     * @var User
     */
    protected $user;

    /**
     * PlayerRepository constructor.
     *
     * @param User $user
     * @param Player $player
     */
    function __construct(User $user, Player $player) {
        $this->player = $player;
        $this->user = $user;
    }

    /**
     * @param array $data
     *
     * @return bool|mixed
     */
    public function create( array $data ) {
        if($user = $this->user->create( $data )) {
            return $user->player()->create($data);
        }
        return false;
    }

    /**
     * @return Player[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function all() {
        return $this->player->with('user')->latest('id')->get();
    }

    /**
     * @param $id
     *
     * @return Player|Player[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id) {
        return $this->player->with('user')->findOrFail($id);
    }

    /**
     * @param $id
     * @param array $playerData
     * @param array|null $userData
     *
     * @return mixed
     */
    public function update( $id, array $playerData, array $userData = null) {
        $player = $this->find($id);
        $updated = $player->update($playerData);
        if( $updated && !empty($userData) ) {
            return $player->user()->update($userData);
        }
        return $updated;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->player->find($id);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function destroy($id) {
        $player = $this->find($id);
        if($player) {
            return $player->delete($id);
        }
        return false;
    }

    /**
     * @return Player
     */
    public function getModel() {
        return $this->player;
    }
}

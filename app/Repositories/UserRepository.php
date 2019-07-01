<?php
/**
 * Created by PhpStorm.
 * User: Pouya
 * Date: 6/27/2019
 * Time: 4:56 PM
 */

namespace App\Repositories;


use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {

    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create( array $data ) {
        return $this->user->create( $data );
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->user->all();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findOrFail($id) {
        return $this->user->findOrFail($id);
    }

    /**
     * @return User
     */
    public function getModel() {
        return $this->user;
    }
}

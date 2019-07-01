<?php

namespace App\Services;


use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserService extends Service
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRequest $request
     *
     * @return mixed
     */
    public function create(UserRequest $request) {
        return $this->userRepository->create($request->all());
    }

    /**
     * @return UserRepository[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all() {
        return $this->userRepository->all();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function user($id) {
        return $this->userRepository->findOrFail($id);
    }
}

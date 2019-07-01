<?php

namespace App\Contracts\Repositories;


interface PlayerRepositoryInterface {

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @return mixed
     */
    public function all();
}

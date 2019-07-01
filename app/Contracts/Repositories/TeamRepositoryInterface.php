<?php

namespace App\Contracts\Repositories;


interface TeamRepositoryInterface {

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

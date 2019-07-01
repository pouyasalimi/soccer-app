<?php
/**
 * Created by PhpStorm.
 * User: Pouya
 * Date: 6/27/2019
 * Time: 4:53 PM
 */

namespace App\Contracts\Repositories;


interface UserRepositoryInterface {

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);
}

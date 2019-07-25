<?php

namespace App\Repositories\User;

use App\Repositories\User\Filter\UserFilter;

interface UserRepository
{
    public function getPaginator(UserFilter $tagFilter);

}
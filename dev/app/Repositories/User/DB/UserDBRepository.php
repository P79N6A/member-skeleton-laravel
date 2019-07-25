<?php

namespace App\Repositories\User\DB;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\Filter\UserFilter;

class UserDBRepository extends BaseRepository implements UserRepository
{
    public function getPaginator(UserFilter $filter)
    {
        // TODO: Implement getPaginator() method.
        $query = User::query();
        if($filter->getUserName()){
            $query->where('user_name',$filter->getUserName());
        }
        if($filter->getUserEmail()){
            $query->where('user_email',$filter->getUserEmail());
        }

        /**
         *  create_time 和 last_update_time 可以定义为begin_time 和 end_time
         */
        if($filter->getCreateTime()){
            $query->where('create_time','<',$filter->getCreateTime());
        }

        if($filter->getLastUpdateTime()){
            $query->where('last_updte_time','>=',$filter->getLastUpdateTime());
        }

        if($filter->getSort()){
            $sorts = $this->parseSortString($filter->getSort());
            if(!empty($sorts)){
                foreach ($sorts as $key => $value){
                    $query->orderBy($key, $value);
                }
            }
        }

        return $query->paginate($filter->getPerPage());
    }
}
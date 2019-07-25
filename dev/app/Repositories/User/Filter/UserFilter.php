<?php
namespace App\Repositories\User\Filter;

use Illuminate\Http\Request;

class UserFilter
{
    protected $user_name ;
    protected $user_email;
    protected $last_update_time;
    protected $create_time;
    protected $page;
    protected $per_page;
    protected $sort;   //+id,-name表示先根据id做asc再根据name做desc

    /**
     * UserFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
    	$this->user_name = $request->input('user_name');
        $this->user_email = $request->input('user_email');
        $this->create_time = $request->input('create_time');

    	$this->page = $request->input('page',1);
    	$this->per_page = $request->input('per_page',20);
    	$this->sort = $request->input('sort','+id');
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }


    /**
     * @return array|string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * @param array|string $user_email
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * @return array|string
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param array|string $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    /**
     * @return array|string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param array|string $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return array|string
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param array|string $per_page
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
    }

    /**
     * @return array|string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param array|string $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateTime()
    {
        return $this->last_update_time;
    }

    /**
     * @param mixed $last_update_time
     */
    public function setLastUpdateTime($last_update_time)
    {
        $this->last_update_time = $last_update_time;
    }

}

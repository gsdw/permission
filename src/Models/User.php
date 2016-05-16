<?php
namespace Gsdw\Permission\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Gsdw\Base\Helpers\General;
use Illuminate\Support\Facades\Input;

class User extends Authenticatable
{
    public $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * get all role to show grid in admin
     * 
     * @return model
     */
    public static function getAllItemGrid()
    {
        $pager = General::getPagerOption();
        $model = self::orderBy($pager['order'], $pager['dir']);
        $model = $model->select('user.id as id', 'user.name as name',
                'user.email as email', 'role.name as role_name')
            ->leftJoin('role', 'role.id', '=' , 'user.role_id');
        $filter = Input::get('filter');
        BaseModel::filterGrid($model);
        $model = $model->paginate($pager['limit']);
        return $model;
    }

    /**
     * get Rules of role
     * 
     * @return array
     */
    public function getRole()
    {
        return Role::find($this->role_id);
    }
}


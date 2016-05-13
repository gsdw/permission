<?php
namespace Gsdw\Permission\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
        $model = $model->select('role.id as id', 'role.name as name', 'role_group.name as group_name')
            ->join('role_group', 'role_group.id', '=' , 'role.role_group_id');
        $filter = Input::get('filter');
        self::filterGrid($model);
        $model = $model->paginate($pager['limit']);
        return $model;
    }
    
    /**
     * override update
     *  + save rule for role
     * 
     * @param array $attributes
     * @param array $rule
     * @param array $options
     */
    public function update(
            array $attributes = array(), 
            array $rules = array(),
            array $scope = array(),
            array $options = array()) {
        $result = null;
        DB::beginTransaction();
        try{
            $result = parent::update($attributes, $options);
            RoleRule::where('role_id', $this->id)
                ->delete();
            if (count($rules)) {
                $dataInsert = [];
                if(in_array(RoleScope::RULE_ALL, $rules)) {
                    $rules = ['all'];
                    $scope = [RoleScope::SCOPE_COMPANY];
                }
                foreach ($rules as $key => $rule) {
                    $dataInsert[] = [
                        'role_id' => $this->id,
                        'rule' => $rule,
                        'scope' => $scope[$key]
                    ];
                }
                RoleRule::insert($dataInsert);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return $result;
    }
    
    /**
     * override create function
     *  + save rule
     * @param array $attributes
     * @param array $rules
     */
    public static function create(
        array $attributes = array(), 
        $rules = array(),
        $scope = array()
    ) {
        $result = null;
        DB::beginTransaction();
        try{
            $result = parent::create($attributes);
            if (count($rules)) {
                $dataInsert = [];
                if(in_array(RoleScope::RULE_ALL, $rules)) {
                    $rules = ['all'];
                }
                foreach ($rules as $key => $rule) {
                    $dataInsert[] = [
                        'role_id' => $result->id,
                        'rule' => $rule,
                        'scope' => $scope[$key]
                    ];
                }
                RoleRule::insert($dataInsert);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
        return $result;
    }
    
    /**
     * override delete
     *  + delete role user, delete role rule
     * @return type
     */
    public function delete() 
    {
        $result = parent::delete();
//        RoleUser::where('role_id', $this->id)
//            ->delete();
//        RoleRule::where('role_id', $this->id)
//            ->delete();
        return $result;
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


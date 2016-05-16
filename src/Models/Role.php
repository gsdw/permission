<?php
namespace Gsdw\Permission\Models;

use Gsdw\Base\Helpers\General;
use Illuminate\Support\Facades\Input;
use DB;

class Role extends BaseModel
{
    protected $table = 'role';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'role_group_id'];
    
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
                    $scope = [RoleScope::SCOPE_COMPANY];
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
     * get Rules of role
     * 
     * @return array
     */
    public function getRules()
    {
        $rules = RoleRule::select('rule', 'scope')
            ->where('role_id', $this->id)
            ->get();
        $rulesKeyIsRule = [];
        foreach ($rules as $item) {    
            if($item->rule == RoleScope::RULE_ALL) {
                return [
                    RoleScope::RULE_ALL => RoleScope::RULE_ALL
                ];
            }
            $rulesKeyIsRule[$item->rule] = $item;
        }
        return $rulesKeyIsRule;
    }
    
    /**
     * get roule group model of role
     * 
     * @return model
     */
    public function getRoleGroup()
    {
        return RoleGroup::find($this->role_group_id);
    }
    
    /**
     * get option array of role
     * 
     * @return array
     */
    public static function toOption()
    {
        $collection = self::select('id', 'name')
            ->orderBy('name')->get();
        $result = [];
        if(count($collection)) {
            foreach ($collection as $item) {
                $result[] = [
                    'value' => $item->id,
                    'label' => $item->name
                ];
            }
        }
        return $result;
    }
}

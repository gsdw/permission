<?php
namespace Gsdw\Permission\Models;

class RoleRule extends BaseModel
{
    protected $table = 'role_rule';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'rule', 'scope'];
    
    /**
     * get rule and scope from roleid
     * 
     * @param type $roleId
     * @return array
     */
    public static function getRules($roleId)
    {
        return self::select('rule', 'scope')
            ->where('role_id', $roleId)
            ->orderBy('rule')
            ->get();
        
    }
}

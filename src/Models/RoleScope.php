<?php
namespace Gsdw\Permission\Models;

class RoleScope extends \Illuminate\Database\Eloquent\Model
{
    const SCOPE_SELF = 1;
    const SCOPE_TEAM = 2;
    const SCOPE_COMPANY = 3;
    const RULE_ALL = 'all';
    
    public static function getScopes()
    {
        return [
            ['self' => self::SCOPE_SELF],
            ['team' => self::SCOPE_TEAM],
            ['company' => self::SCOPE_COMPANY],
        ];
    }
    
    public static function toOption()
    {
        return [
            ['value' => self::SCOPE_SELF, 'label' => 'Self'],
            ['value' => self::SCOPE_TEAM, 'label' => 'Team'],
            ['value' => self::SCOPE_COMPANY, 'label' => 'Company'],
        ];
    }
}

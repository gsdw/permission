<?php
namespace Gsdw\Permission\Helpers;

use Auth as AuthCore;
use Illuminate\Support\Facades\Route;
use Gsdw\Permission\Models\RoleScope;
use Illuminate\Support\Facades\Session;

class Auth
{
    protected static $self;
    
    protected static $user;
    protected static $rules;
    
    public function __construct() {
        $this->initUser();
        $this->initRules();
    }

    /**
     * init User loggined
     * 
     * @return \Gsdw\Permission\Helpers\Auth
     */
    public function initUser()
    {   
        if(!Session::has('permission.user')) {
            Session::push('permission.user', AuthCore::user());
        }
        self::$user = Session::get('permission.user');
        self::$user = self::$user[0];
        return $this;
//        self::$user = AuthCore::user();
//        return $this;
    }
    
    /**
     * init Rules
     * 
     * @return \Gsdw\Permission\Helpers\Auth
     */
    public function initRules()
    {
        if(!Session::has('permission.rules')) {
            $role = self::$user->getRole();
            if (!$role) {
                $rules = [];
            } else {
                $rules = $role->getRules();
            }
            Session::push('permission.rules', $rules);
        }
        self::$rules = Session::get('permission.rules');
        self::$rules = self::$rules[0];
        return $this;
        
//        $role = self::$user->getRole();
//        if (!$role) {
//            self::$rules = [];
//        } else {
//            self::$rules = $role->getRules();
//        }
//        return $this;
    }
    
    /**
     * check is all rule
     * 
     * @return boolean
     */
    public function isRuleAll()
    {
        if(key_exists(RoleScope::RULE_ALL, self::$rules)) {
            return true;
        }
        return false;
    }

    /**
     * check user has rule
     * 
     * @param type $rule
     * @return boolean
     */
    public function hasRule($rule)
    {
        if ($this->isRuleAll()) {
            return true;
        }
        if(key_exists($rule, self::$rules)) {
            return true;
        }
        return false;
    }
    
    /**
     * check permission in route curent
     * 
     * @return boolean
     */
    public function hasRuleCurrent()
    {
        $routeCurrent = Route::getCurrentRoute()->getName();
        if($this->hasRule($routeCurrent)) {
            return true;
        }
        return false;
    }
    
    public function validateRule()
    {
        if($this->hasRuleCurrent()) {
            return true;
        }
        echo view('gsdw_permission::errors.permission');
        exit;
    }
    
    /**
     * get scope current
     * 
     * @return int
     */
    public function getScopeCurrent()
    {
        if($this->isRuleAll()) {
            return RoleScope::SCOPE_COMPANY;
        }
        $routeName = Route::getCurrentRoute()->getName();
        if(isset(self::$rules[$routeName])) {
            return self::$rules[$routeName]->scope;
        }
        return null;
    }
    
    /**
     * check is scope self
     * 
     * @return boolean
     */
    public function isScopeSelf()
    {
        if($this->getScopeCurrent() == RoleScope::SCOPE_SELF) {
            return true;
        }
        return false;
    }
    
    /**
     * check is scope team
     * 
     * @return boolean
     */
    public function isScopeTeam()
    {
        if($this->getScopeCurrent() == RoleScope::SCOPE_TEAM) {
            return true;
        }
        return false;
    }
    
    /**
     * check is scope company
     * 
     * @return boolean
     */
    public function isScopeCompany()
    {
        if($this->getScopeCurrent() == RoleScope::SCOPE_COMPANY) {
            return true;
        }
        return false;
    }
    
    public function flushPermission()
    {
        Session::flush('permission');
    }
    
    /**
     * Singleton instance
     * 
     * @return \Gsdw\Permission\Helpers\Auth
     */
    public static function getSelf()
    {
        if (!isset(self::$self)) {
            self::$self = new static;
        }
        return self::$self;
    }   
}

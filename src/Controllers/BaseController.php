<?php
namespace Gsdw\Permission\Controllers;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * prefix path route alias
     * @var type 
     */
    protected $prefixPathRoute;
    
    /**
     * constructor
     */
    public function __construct() {
        $this->prefixPathRoute = '';
        $this->_contruct();
    }
    
    /**
     * constructor call back
     * 
     * @return \Gsdw\Permission\Controllers\BaseController
     */
    protected function _contruct()
    {
        return $this;
    }
}


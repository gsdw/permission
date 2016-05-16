<?php
namespace Gsdw\Permission\Controllers;

use App\Http\Controllers\Controller;
use Gsdw\Permission\Helpers\Auth;

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
        Auth::getSelf()->validateRule();
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


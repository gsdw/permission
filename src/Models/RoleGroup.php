<?php
namespace Gsdw\Permission\Models;

use Gsdw\Base\Helpers\General;
use Illuminate\Support\Facades\Input;

class RoleGroup extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'role_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * get all role to show grid in admin
     * 
     * @return model
     */
    public static function getAllItemGrid()
    {
        $pager = General::getPagerOption();
        $model = self::orderBy($pager['order'], $pager['dir']);
        $model = $model->select('id', 'name');
        $filter = Input::get('filter');
        if ($filter && count($filter)) {
            foreach ($filter as $key => $value) {
                if (is_array($value)) {
                    if (isset($value['from']) && $value['from']) {
                        $model = $model->where($key, '>=', $value['from']);
                    }
                    if (isset($value['to']) && $value['to']) {
                        $model = $model->where($key, '<=', $value['to']);
                    }
                } else {
                    $model = $model->where($key, 'like', "%$value%");
                }
            }
        }
        $model = $model->paginate($pager['limit']);
        return $model;
    }
    
    /**
     * override delete
     *  + delete role user, delete role rule
     * @return type
     */
    public function delete() {
        $result = parent::delete();
//        Role::where('role_id', $this->id)
//            ->delete();
//        RoleRule::where('role_id', $this->id)
//            ->delete();
        return $result;
    }
    
    
    public static function toOption()
    {
        $collection = self::select('id', 'name')->orderBy('name')->get();
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


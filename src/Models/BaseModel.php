<?php
namespace Gsdw\Permission\Models;

use Illuminate\Support\Facades\Input;

class BaseModel extends \Illuminate\Database\Eloquent\Model
{    
    /**
     * filter grid collection
     * 
     * @return model
     */
    public static function filterGrid(&$model)
    {
        $filter = Input::get('filter');
        if ($filter && count($filter)) {
            foreach ($filter as $key => $value) {
                $key = str_replace(',', '.', $key);
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
        return $model;
    }
}


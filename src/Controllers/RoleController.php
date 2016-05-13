<?php
namespace Gsdw\Permission\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Gsdw\Permission\Models\Role;
use Gsdw\Base\Helpers\Form;

class RoleController extends BaseController
{
    protected function _contruct() {
        $this->prefixPathRoute = 'auth.role.';
    }

    /**
     * List roles
     *
     * @return void
     */
    public function index()
    {
        Form::setData('filter');
        return view('gsdw_permission::role.list',[
            'model' => Role::getAllItemGrid(),
            'title' => 'Role',
        ]);
    }
    
    /**
     * Create new Role
     *
     * @return void
     */
    public function create()
    {
        return view('gsdw_permission::role.edit',[
            'title' => 'Role create',
        ]);
    }
    
    /**
     * Save new role
     *
     * @return void
     */
    public function createPost(Request $request)
    {
        try{
            $input = $request->input('item');
            $validator = Validator::make($input, [
                'name' => 'required|unique:role|max:255',
            ]);
            if ($validator->fails()) {
                Form::setData($input);
                return redirect()->route($this->prefixPathRoute.'createForm')
                    ->withErrors($validator);
            }
            $model = Role::create(
                $input,
                (array)Input::get('rule'),
                (array)Input::get('scope')
            );
            $messages = array('success'=> [
                    'Create Role success!',
                ],);
            if($request->input('submit_continue')) {
                return redirect()->route($this->prefixPathRoute.'editForm', [
                    'id' => $model->id,
                ])->with('messages',$messages);
            }
            return redirect()->route($this->prefixPathRoute.'list')
                    ->with('messages',$messages);        
        } catch (Exception $ex) {
            Form::setData('item');
            return redirect()->route($this->prefixPathRoute.'createForm')
                    ->withErrors($ex);
        }
    }
    
    /**
     * Edit role
     *
     * @return void
     */
    public function edit($id)
    {
        $model = Role::find($id);
        if(!count($model)) {
            return redirect()->route($this->prefixPathRoute.'list')
                    ->withErrors('Not found role');
        }
        Form::setData($model);
        Form::setData(['rule' => $model->getRules()]);
        return view('gsdw_permission::role.edit',[
            'title' => 'Edit role: '.$model->name,
        ]);
    }
    
    /**
     * Save role
     *
     * @return void
     */
    public function editPost($id)
    {
        try{
            $model = Role::find($id);
            if (!count($model)) {
                return redirect()->route($this->prefixPathRoute.'list')
                        ->withErrors('Not found role');
            }
            $input = Input::get('item');
            $validator = Validator::make($input, [
                'name' => 'required|unique:role,name,'.$id.'|max:255',
            ]);
            if ($validator->fails()) {
                Form::setData($model);
                return redirect()->route($this->prefixPathRoute.'editForm', [
                        'id' => $id,
                    ])->withErrors($validator);
            }
            $model->update(
                $input, 
                (array)Input::get('rule'), 
                (array)Input::get('scope')
            );
            $messages = array('success'=> [
                'Save role success!',
            ],);
            if(Input::get('submit_continue')) {
                return redirect()->route($this->prefixPathRoute.'editForm', [
                        'id' => $id,
                    ])->with('messages',$messages);
            }
            return redirect()->route($this->prefixPathRoute.'list')
                ->with('messages',$messages);
        } catch (Exception $ex) {
            return redirect()->route($this->prefixPathRoute.'editForm', [
                    'id' => $id,
                ])
            ->withErrors($ex)->withInput();
        }
    }
    
    /**
     * Delete role
     * 
     * @param type $id
     * @param type $token
     * @return type
     */
    public function delete($id, $token)
    {
        if (csrf_token() != $token) {
            return redirect()->route($this->prefixPathRoute.'list')
                ->withErrors('Error token key!');
        }
        $model = Role::find($id);
        if(!count($model)) {
            return redirect()->route($this->prefixPathRoute.'list')
                    ->withErrors('Not found item');
        }
        try {
            $model->delete();
            $messages = array('success'=> [
                'Delete item success!',
            ]);
            return redirect()->route($this->prefixPathRoute.'list')
                    ->with('messages',$messages);
        } catch (Exception $ex) {
            return redirect()->route($this->prefixPathRoute.'list')
                    ->withErrors($ex);
        }
    }
}

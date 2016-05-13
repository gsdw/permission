<?php
namespace Gsdw\Permission\Controllers;

use Illuminate\Http\Request;
use Validator;
use Gsdw\Permission\Models\RoleGroup;
use Gsdw\Base\Helpers\Form;

class RoleGroupController extends BaseController
{
    protected function _contruct() {
        $this->prefixPathRoute = 'auth.role.group.';
    }

    /**
     * List roles
     *
     * @return void
     */
    public function index()
    {
        Form::setData('filter');
        return view('gsdw_permission::role.group.list',[
            'model' => RoleGroup::getAllItemGrid(),
            'title' => 'Role Group',
        ]);
    }
    
    /**
     * Create new Role
     *
     * @return void
     */
    public function create()
    {
        return view('gsdw_permission::role.group.edit',[
            'title' => 'Role Group Create',
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
                'name' => 'required|unique:role_group|max:255',
            ]);
            if ($validator->fails()) {
                Form::setData($input);
                return redirect()->route($this->prefixPathRoute.'createForm')
                    ->withErrors($validator);
            }
            $model = RoleGroup::create($input);
            $messages = array('success'=> [
                    'Create Role Group success!',
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
        $model = RoleGroup::find($id);
        if(!count($model)) {
            return redirect()->route($this->prefixPathRoute.'list')
                    ->withErrors('Not found role group');
        }
        Form::setData($model);
        return view('gsdw_permission::role.group.edit',[
            'title' => 'Edit role group: '.$model->name,
        ]);
    }
    
    /**
     * Save role
     *
     * @return void
     */
    public function editPost(Request $request, $id)
    {
        try{
            $model = RoleGroup::find($id);
            if (!count($model)) {
                return redirect()->route($this->prefixPathRoute.'list')
                        ->withErrors('Not found role group');
            }
            $input = $request->input('item');
            $validator = Validator::make($input, [
                'name' => 'required|unique:role_group,name,'.$id.'|max:255',
            ]);
            if ($validator->fails()) {
                Form::setData($model);
                return redirect()->route($this->prefixPathRoute.'editForm', [
                        'id' => $id,
                    ])->withErrors($validator);
            }
            $model->update($input);
            $messages = array('success'=> [
                'Save role group success!',
            ],);
            if($request->input('submit_continue')) {
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
        $model = RoleGroup::find($id);
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
            return redirect()->route($this->prefixPathRoute.'list   ')
                    ->withErrors($ex);
        }
    }
}

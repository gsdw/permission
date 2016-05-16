<?php
namespace Gsdw\Permission\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;
use Gsdw\Permission\Models\User;
use Gsdw\Base\Helpers\Form;

class UserController extends BaseController
{
    protected function _contruct() {
        $this->prefixPathRoute = 'auth.user.';
    }

    /**
     * List roles
     *
     * @return void
     */
    public function index()
    {
        Form::setData('filter');
        return view('gsdw_permission::user.list',[
            'model' => User::getAllItemGrid(),
            'title' => 'User Manager',
        ]);
    }
    
    /**
     * Create new Role
     *
     * @return void
     */
    public function create()
    {
        return view('gsdw_permission::user.edit',[
            'title' => 'User create',
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
                'name' => 'required|max:255',
                'email' => 'required|unique:user|max:255',
                'password' => 'required|max:255',
                'repassword' => 'required|same:password|max:255',
            ]);
            if ($validator->fails()) {
                Form::setData($input);
                return redirect()->route($this->prefixPathRoute.'createForm')
                    ->withErrors($validator);
            }
            $input['password'] = bcrypt($input['password']);
            unset($input['repassword']);
            $model = User::create($input);
            $messages = array('success'=> [
                    'Create User success!',
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
        $model = User::find($id);
        if(!count($model)) {
            return redirect()->route($this->prefixPathRoute.'list')
                    ->withErrors('Not found user');
        }
        Form::setData($model);
        return view('gsdw_permission::user.edit',[
            'title' => 'Edit user: '.$model->name,
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
            $model = User::find($id);
            if (!count($model)) {
                return redirect()->route($this->prefixPathRoute.'list')
                        ->withErrors('Not found role');
            }
            $input = Input::get('item');
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'email' => 'required|unique:user,id,'.$id.'|max:255',
                'password' => 'max:255',
                'repassword' => 'same:password|max:255',
            ]);
            if ($validator->fails()) {
                return redirect()->route($this->prefixPathRoute.'editForm', [
                        'id' => $id,
                    ])->withErrors($validator);
            }
            if($input['password']) {
                if(!$input['repassword']) {
                    return redirect()->route($this->prefixPathRoute.'editForm', [
                        'id' => $id,
                    ])->withErrors('Please input Re-password');
                }
                $input['password'] = bcrypt($input['password']);
            }
            unset($input['repassword']);
            $model->update($input);
            $messages = array('success'=> [
                'Save User success!',
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
        $model = User::find($id);
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
    
    /**
     * mass action
     * 
     * @param Request $request
     * @return type
     */
    public function massAction(Request $request)
    {
        if (!count($request->input('item')) || !$request->input('item')) {
            return redirect()->route($this->prefixPathRoute.'list')
                ->withErrors('Please choose item');
        }
        if ($request->input('action') == 'delete') {
            return $this->massDelete($request);
        }
        return redirect()->route($this->prefixPathRoute.'list');
    }
    
    /**
     * mass action delete
     * 
     * @param Request $request
     * @return type
     */
    protected function massDelete(Request $request)
    {
        $i = 0;
        DB::beginTransaction();
        try{
            foreach ($request->input('item') as $item) {
                $model = User::find($item);
                if(count($model)) {
                    $model->delete();
                    $i++;
                }
            }
            $messages = array('success'=> [
                'Mass delete ' . $i . ' item success!',
            ],);
            DB::commit();
            return redirect()->route($this->prefixPathRoute.'list')
                    ->with('messages',$messages);
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->route($this->prefixPathRoute.$this->suffixPathRoute)->withErrors($ex);
        }   
    }
}

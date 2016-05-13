<?php
namespace Gsdw\Permission\Database;

use Illuminate\Database\Seeder as BaseSeeder;
use App\Models\User;
use App\Models\Role;

class Seeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    }
    
    /**
     * create role default
     *  user, manager, admin
     * @return \DatabaseSeeder
     */
    protected function roleSeeder()
    {
        $roles = ['admin', 'manager', 'user'];
        foreach ($roles as $role) {
            $user = DB::table('role')->where('name', $role)->get();
            if (!count($user)) {
                if ($role == 'admin') {
                    $rules = ['all'];
                } else {
                    $rules = [];
                }
                Role::create([
                    'name' => $role,
                ], $rules);
            }
        }
        return $this;
    }
    
    /**
     * create user default
     * 
     * @return \DatabaseSeeder
     */
    protected function userSeeder()
    {
        $users = [
            0 => [
                'email' => 'admin@gmail.com',
                'name' => 'admin',
                'role' => 'admin',
            ],
            1 => [
                'email' => 'manager@gmail.com',
                'name' => 'manager',
                'role' => 'manager',
            ],
            2 => [
                'email' => 'user@gmail.com',
                'name' => 'user',
                'role' => 'user',
            ],
        ];
        foreach ($users as $user) {
            $userCreate = DB::table('users')
                ->where('email', $user['email'])
                ->get();
            if (!count($userCreate)) {
                $roleId = Role::where('name',$user['role'])
                    ->first();
                if (count($roleId)) {
                    $roleId = [$roleId->id];
                } else {
                    $roleId = array();
                }
                User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt('123456'),
                ], $roleId);
            }
        }
        return $this;
    }
}


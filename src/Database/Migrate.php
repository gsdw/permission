<?php
namespace Gsdw\Permission\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Schema;

class Migrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('role_group')) {
            Schema::create('role_group', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
//                $table->string('code')->unique();
                $table->timestamps();
            });
        }
        
        if(!Schema::hasTable('role')) {
            Schema::create('role', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
//                $table->string('code')->unique();
                $table->integer('role_group_id')->unsigned();
                $table->timestamps();
//                $table->foreign('role_group_id')
//                    ->references('id')
//                    ->on('role_group');
            });
        }
        
        if(!Schema::hasTable('role_rule')) {
            Schema::create('role_rule', function (Blueprint $table) {
                $table->integer('role_id')->unsigned();
                $table->string('rule');
                $table->enum('scope', [
                    \Gsdw\Permission\Models\RoleScope::SCOPE_SELF,
                    \Gsdw\Permission\Models\RoleScope::SCOPE_TEAM,
                    \Gsdw\Permission\Models\RoleScope::SCOPE_COMPANY
                ])->default(\Gsdw\Permission\Models\RoleScope::SCOPE_SELF);
                $table->unique(['role_id', 'rule']);
//                $table->foreign('role_id')
//                    ->references('id')
//                    ->on('role');
                
            });
        }
        
        if(!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->integer('role_id')->unsigned();
                $table->rememberToken();
                $table->timestamps();
//                $table->foreign('role_id')->references('id')->on('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

# Laravel Gsdw Premission

## Introduction

### Install
add code to composer.json
    
    "require": {
        "gsdw/permission": "0.1.*"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/gsdw/permission"
        }
    ],

### Setup

#### Add providers
add providers in config/app.php

    Gsdw\Permission\Providers\PermissionServiceProvider::class,

#### Change User model
Change User model called to `Gsdw\Permission\Models\User`
- in file `config/auth.php`:

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Gsdw\Permission\Models\User::class
        ],
    ]

- in file `app\Http\Controllers\Auth\AuthController.php`

#### Create table
Use this code in migration:

    $migrate = new \Gsdw\Permission\Database\Migrate();
    $migrate->up();

#### Router collection name
Create file `config/routeas.php`, add date for route alias:

    return [
        'route.alias.name' => 'route custom name',
    ]

#### view
- Layout default: layouts.default
- add `@yield('scriptCode')` at before body end tag
- copy all file in public to root_folder/public

#### Code

* route has name prefix is `auth.` to check validate permission

* use `class Gsdw\Permission\Helpers\Auth`
- validate Authorize: Auth::getSelf()->validateRule();
- get Scope current for route: Auth::getSelf()->getScopeCurrent();
- checking is scope self: Auth::getSelf()->isScopeSelf();
- checking is scope team: Auth::getSelf()->isScopeTeam();
- checking is scope company: Auth::getSelf()->isScopeCompany();

##### Logout function
Flush session when logout \Gsdw\Permission\Helpers\Auth::getSelf()->flushPermission();

    public function logout() {
        Auth::guard($this->getGuard())->logout();
        \Gsdw\Permission\Helpers\Auth::getSelf()->flushPermission();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

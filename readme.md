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
# erpnet-backpack

[Site do GitHub](https://github.com/lucianobapo/erpnet-backpack)

[![Latest Stable Version](https://poser.pugx.org/ilhanet/erpnet-backpack/v/stable)](https://packagist.org/packages/ilhanet/erpnet-backpack) 
[![Total Downloads](https://poser.pugx.org/ilhanet/erpnet-backpack/downloads)](https://packagist.org/packages/ilhanet/erpnet-backpack) 
[![Latest Unstable Version](https://poser.pugx.org/ilhanet/erpnet-backpack/v/unstable)](https://packagist.org/packages/ilhanet/erpnet-backpack) 
[![License](https://poser.pugx.org/ilhanet/erpnet-backpack/license)](https://packagist.org/packages/ilhanet/erpnet-backpack)


## Install
1) Prepare Your Laravel instalation:

Make sure your .env files point to right database connections

2) In your terminal run these commands:

``` bash
composer require ilhanet/erpnet-backpack
php artisan erpnet:backpack:install
```

3) Use the following traits on your User model:
```php
<?php namespace App;

use Backpack\CRUD\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one
use Illuminate\Foundation\Auth\User as Authenticatable; 

class User extends Authenticatable
{
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this

    /**
     * Your User Model content
     */
```

4) Change your ```config/auth.php``` to use ```Backpack\Base\app\Models\BackpackUser::class```:

```diff
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
-            'model' => App\User::class,
+            'model' => Backpack\Base\app\Models\BackpackUser::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```
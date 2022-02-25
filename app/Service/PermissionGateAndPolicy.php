<?php

namespace App\Service;

use Illuminate\Support\Facades\Gate;

class PermissionGateAndPolicy
{
    public function Category()
    {
        Gate::define('list_category', 'App\Policies\CategoryPolicy@viewAny');
        Gate::define('show_category', 'App\Policies\CategoryPolicy@view');
        Gate::define('add_category', 'App\Policies\CategoryPolicy@create');
        Gate::define('edit_category', 'App\Policies\CategoryPolicy@update');
        Gate::define('delete_category', 'App\Policies\CategoryPolicy@delete');
    }

    public function Dashbroad()
    {
        Gate::define('dashbroad_index', 'App\Policies\DashbroadPolicy@index');
    }

    public function FileManager()
    {
        Gate::define('filemanager_index', 'App\Policies\FileManagerPolicy@index');
    }

    public function Log()
    {
        Gate::define('log_index', 'App\Policies\LogPolicy@index');
    }

    public function User()
    {
        Gate::define('list_user', 'App\Policies\UserPolicy@viewAny');
        Gate::define('add_user', 'App\Policies\UserPolicy@create');
        Gate::define('edit_user', 'App\Policies\UserPolicy@update');
        Gate::define('delete_user', 'App\Policies\UserPolicy@delete');
    }

    public function Role()
    {
        Gate::define('list_role', 'App\Policies\RolePolicy@viewAny');
        Gate::define('add_role', 'App\Policies\RolePolicy@create');
        Gate::define('edit_role', 'App\Policies\RolePolicy@update');
        Gate::define('delete_role', 'App\Policies\RolePolicy@delete');
    }

    public function Permission()
    {
        Gate::define('list_permission', 'App\Policies\PermissionPolicy@viewAny');
        Gate::define('add_permission', 'App\Policies\PermissionPolicy@create');
        Gate::define('edit_permission', 'App\Policies\PermissionPolicy@update');
        Gate::define('delete_permission', 'App\Policies\PermissionPolicy@delete');
    }

    public function Question()
    {
        Gate::define('list_question', 'App\Policies\QuestionPolicy@viewAny');
        Gate::define('show_question', 'App\Policies\QuestionPolicy@view');
        Gate::define('add_question', 'App\Policies\QuestionPolicy@create');
        Gate::define('edit_question', 'App\Policies\QuestionPolicy@update');
        Gate::define('delete_question', 'App\Policies\QuestionPolicy@delete');
    }

    public function Tag()
    {
        Gate::define('list_tag', 'App\Policies\TagPolicy@viewAny');
        Gate::define('show_tag', 'App\Policies\TagPolicy@view');
        Gate::define('add_tag', 'App\Policies\TagPolicy@create');
        Gate::define('edit_tag', 'App\Policies\TagPolicy@update');
        Gate::define('delete_tag', 'App\Policies\TagPolicy@delete');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

abstract class BaseAdminController extends Controller
{
    protected string $layout = 'layouts.admin';

    protected string $viewNamespace = 'admin';

    protected string $pageTitle = 'Bank Waway Admin CMS';

    protected function view(string $view, array $data = [])
    {
        return view($this->viewNamespace . '.' . $view, array_merge([
            'layout' => $this->layout,
            'pageTitle' => $this->pageTitle,
        ], $data));
    }
}
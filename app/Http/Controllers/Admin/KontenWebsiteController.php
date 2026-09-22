<?php

namespace App\Http\Controllers\Admin;

class KontenWebsiteController extends BaseAdminController
{
    public function index()
    {
        return $this->view('konten-website');
    }
}
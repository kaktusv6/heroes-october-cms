<?php namespace Nkf\Heroes\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Index Back-end Controller
 */
class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Nkf.Heroes', 'heroes');
    }

    public function index()
    {
        $this->pageTitle = trans('nkf.heroes::lang.plugin.name');
        return $this->makePartial('index');
    }
}

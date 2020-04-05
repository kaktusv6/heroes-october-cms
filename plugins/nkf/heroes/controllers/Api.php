<?php namespace Nkf\Heroes\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Api Back-end Controller
 */
class Api extends Controller
{
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Nkf.Heroes', 'api');
    }

    public function index()
    {
        $this->pageTitle = trans('nkf.heroes::lang.plugin.api');
        return $this->makePartial('index');
    }
}

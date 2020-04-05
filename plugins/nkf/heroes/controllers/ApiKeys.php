<?php namespace Nkf\Heroes\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ApiKeys extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Nkf.Heroes', 'api', 'api-keys');
    }
}

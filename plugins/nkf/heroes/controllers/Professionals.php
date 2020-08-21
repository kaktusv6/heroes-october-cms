<?php namespace Nkf\Heroes\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Professionals Back-end Controller
 */
class Professionals extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Nkf.Heroes', 'heroes', 'professionals');
    }
}

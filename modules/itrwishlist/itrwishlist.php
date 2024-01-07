<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

use classes\ItrPetsSpecies;
use \PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Itrwishlist extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'itrwishlist';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Mathieu VDB';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('IT-Room Wishlist', [], 'Modules.Itrwishlist.Admin');
        $this->description = $this->trans('Description of my module.', [], 'Modules.Itrwishlist.Admin');

        $this->confirmUninstall = $this->trans(
            'Are you sure you want to uninstall?',
            [],
            'Modules.Itrwishlist.Admin'
        );
    }

    public function install()
    {
        include dirname(__FILE__) . '/database/install.php';

        return parent::install();
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        $route = $this->get('router')->generate('itrwishlist_form_simple');
        Tools::redirectAdmin($route);
    }

    public function renderWidget($hookName, array $configuration)
    {
        // TODO: Implement renderWidget() method.
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        // TODO: Implement getWidgetVariables() method.
    }
}
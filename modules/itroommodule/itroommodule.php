<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once dirname(__FILE__) . '/traits/ItrModuleFunctionalitiesTrait.php';

if (!defined('_PS_VERSION_')) {
    exit;
}

class Itroommodule extends Module
{
    use ItrModuleFunctionalitiesTrait;

    public function __construct()
    {
        $this->name = 'itroommodule';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Mathieu VDB';
        $this->need_instance = 0;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('IT-Room module');
        $this->description = $this->l('Module créé dans le cadre du test technique IT-Room.');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include dirname(__FILE__) . '/database/install.php';

        return parent::install() &&
            $this->_installTab() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayFooterProduct') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        include dirname(__FILE__) . '/database/uninstall.php';

        return parent::uninstall() && $this->_uninstallTab();
    }

    public function getContent()
    {
        return $this->getContentFunctionalities();
    }

    public function _installTab(): bool
    {
        $subTab = [
            [
                'class_name' => 'AdminProductsErrors',
                'id_parent' => (int) Tab::getIdFromClassName('DEFAULT'),
                'module' => $this->name,
                'name' => 'Products errors',
            ],
            [
                'class_name' => 'AdminAvatars',
                'id_parent' => (int) Tab::getIdFromClassName('DEFAULT'),
                'module' => $this->name,
                'name' => 'Avatars',
            ],
        ];
        $languages = Language::getLanguages();
        foreach ($subTab as $tab) {
            $newTab = new Tab();
            $newTab->class_name = $tab['class_name'];
            $newTab->id_parent = $tab['id_parent'];
            $newTab->module = $tab['module'];
            foreach ($languages as $l) {
                $newTab->name[$l['id_lang']] = $this->trans($tab['name'], [], 'Modules.Itroommodule.Admin');
            }
            $newTab->save();
        }

        return true;
    }

    public function _uninstallTab(): bool
    {
        $idTab = [
            (int) Tab::getIdFromClassName('AdminProductsErrors'),
        ];
        foreach ($idTab as $subTab) {
            if ($subTab) {
                $tab = new Tab($subTab);
                try {
                    $tab->delete();
                } catch (Exception $e) {
                    echo $e->getMessage();

                    return false;
                }
            }
        }

        return true;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayHome()
    {
        $lang_id = (int)Configuration::get('PS_LANG_DEFAULT');

        $bIsLogged = false;
        if ($this->context->customer->isLogged()) {
            $bIsLogged = true;
        }

        // Récupère le nombre total de produits
        $totalProducts = Db::getInstance()->getValue('SELECT COUNT(*) FROM ' . _DB_PREFIX_ . 'product');

        // Récupère le coût moyen du panier
        $averageCartQuery = Db::getInstance()->getValue('SELECT AVG(total_paid) FROM ' . _DB_PREFIX_ . 'orders');
        $averageCart = number_format($averageCartQuery);

        // Récupère le produit le plus vendu
        $most_ordered_product_id = Db::getInstance()->execute(
            'SELECT product_id, SUM(product_quantity) AS total_ordered 
                FROM ' . _DB_PREFIX_ . 'order_detail 
                GROUP BY product_id 
                ORDER BY total_ordered DESC LIMIT 1');
        $most_ordered_product = new Product($most_ordered_product_id, false, $lang_id);
        $link = new Link();
        $lang_iso_code = Language::getIsoById($this->context->language->id);
        $product_url = $link->getProductLink($most_ordered_product, null, $lang_iso_code);

        $aMostOrderedProduct = [
            'name' => $most_ordered_product->getProductName($this->context->language->id),
            'url' => $product_url
        ];

        $this->context->smarty->assign([
            'totalProducts' => $totalProducts,
            'averageCart' => $averageCart,
            'mostOrderedProduct' => $aMostOrderedProduct,
            'isLogged' => $bIsLogged,
        ]);

        return $this->display(__FILE__, 'views/templates/hook/displayHome.tpl');
    }

    public function hookDisplayFooterProduct($params)
    {
        $id_product = $params['product']['id_product'];

        $this->context->smarty->assign([
            'id_product' => $id_product,
            'itroommoduleproductserrors' => Context::getContext()->link->getModuleLink(
                'itroommodule', 'ProductsErrors'
            ),
        ]);
        return $this->display(__FILE__, 'views/templates/hook/displayFooterProduct.tpl');
    }
}

<?php

require_once dirname(__FILE__) . '/../../classes/ItrProductsErrors.php';
class itroommoduleProductsErrorsModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        if (!Tools::isSubmit('submitError')) {
            exit();
        }

        $productId = Tools::getValue('productId');
        $productName = ItrProductsErrors::getProductNameById($productId);
        $error = Tools::getValue('error');

        $oProductComment = new ItrProductsErrors();
        $oProductComment->id_product = $productId;
        $oProductComment->product_name = $productName;
        $oProductComment->error = $error;
        $oProductComment->save();
    }
}
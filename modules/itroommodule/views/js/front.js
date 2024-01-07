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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
$(document).ready(()=>{
    $('.submitComment').click( (e) => {
        let controller = $('input[name=itroommoduleproductserrors]').val();
        let productId = $('input[name=id_product]').val();
        let error = $('textarea[name=error]').val();
        console.log(controller);
        $.ajax({
            url: controller,
            method : "POST",
            data: {submitError : 1, productId : productId, error : error},
            success : (response) => {
                $('#exampleModal').modal('hide');
                $('.btn-danger').replaceWith("<p class='success-submit-error'>Demande bien envoyée</p>");
            }
        });
    });
})
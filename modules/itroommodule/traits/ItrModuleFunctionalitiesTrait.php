<?php

trait ItrModuleFunctionalitiesTrait
{
    public function getConfigFormFunctionalities()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'ITROOMMODULE_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            ]
                        ],
                    ],
                    [
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'ITROOMMODULE_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ],
                    [
                        'type' => 'password',
                        'name' => 'ITROOMMODULE_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    public function getConfigFormValuesFonctionalities()
    {
        return [
            'ITROOMMODULE_LIVE_MODE' => Configuration::get('ITROOMMODULE_LIVE_MODE', true),
            'ITROOMMODULE_ACCOUNT_EMAIL' => Configuration::get('ITROOMMODULE_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'ITROOMMODULE_ACCOUNT_PASSWORD' => Configuration::get('ITROOMMODULE_ACCOUNT_PASSWORD', null),
        ];
    }

    public function renderFormFunctionalities()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitItroommoduleModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValuesFonctionalities(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$this->getConfigFormFunctionalities()]);
    }

    public function postProcessFunctionalities()
    {
        $form_values = $this->getConfigFormValuesFonctionalities();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    public function getContentFunctionalities()
    {
        if (((bool)Tools::isSubmit('submitItroommoduleModule')) == true) {
            $this->postProcessFunctionalities();
        }

        return $this->renderFormFunctionalities();
    }
}
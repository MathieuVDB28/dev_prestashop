<?php

require_once dirname(__FILE__) . '/../../classes/ItrAvatars.php';
require_once dirname(__FILE__) . '/../../classes/ImageUpload.php';

class AdminAvatarsController extends AdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = ItrAvatars::$definition['table'];
        $this->identifier = ItrAvatars::$definition['primary'];
        $this->className = ItrAvatars::class;

        parent::__construct();

        $this->fields_list = [ //TODO filtres
            'id_avatar' => [
                'title' => 'ID',
                'align' => 'center',
                'type' => 'int',
            ],
            'image' => [
                'title' => 'Image',
                'image' => 'avatars',
            ],
        ];

        $this->addRowAction('delete');
    }

    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_btn['new'] = [
            'href' => self::$currentIndex . '&add' . $this->table . '&token=' . $this->token,
            'desc' => $this->trans('Add a new avatar', [], 'Modules.Itroommodule.Admin'),
            'icon' => 'process-icon-new',
        ];

        parent::initPageHeaderToolbar();
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->trans('Avatars', [], 'Modules.Itroommodule.Admin'),
                'icon' => 'icon-cogs',
            ],
            'input' => [
                [
                    'type' => 'file',
                    'label' => $this->trans('Image', [], 'Admin.Global'),
                    'name' => 'image',
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
        ];

        return parent::renderForm();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAdd' . $this->table)) {
            $imageUploader = new ImageUpload();
            $imageUploader->setBasePath(_PS_IMG_DIR_ . 'avatars/');

            $imageUploader->upload($_FILES['image']);

            if (!$imageUploader->success()) {
                $this->errors[] = $this->trans('Error uploading image.', [], 'Admin.Notifications.Error');
            }
        }

        parent::postProcess();
    }
}
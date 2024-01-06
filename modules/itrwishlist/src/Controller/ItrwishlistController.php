<?php
declare(strict_types=1);

namespace PrestaShop\Module\Itrwishlist\Controller;

require_once dirname(__FILE__) . '/../../classes/ItrPetsSpecies.php';
require_once dirname(__FILE__) . '/../../classes/ItrPetsSpeciesLang.php';
use classes\ItrPetsSpecies;
use classes\ItrPetsSpeciesLang;
use Context;
use PrestaShop\Module\Itrwishlist\Form\ItrwishlistFormType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItrwishlistController extends FrameworkBundleAdminController
{
    public function index(Request $request): Response
    {
        $form = $this->createForm(ItrwishlistFormType::class);

        $aSpecies = ItrPetsSpecies::findAll();
        $label = '';
        if (isset($aSpecies)) {
            foreach ($aSpecies as $species) {
                $label = ItrPetsSpeciesLang::getLabelBySpeciesId($species['id_species']);
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
            $data = $form->getData();

            $oSpecies = new ItrPetsSpecies();

            $oSpecies->active = $data['is_active'];
            $oSpecies->save();
            $oSpeciesId = $oSpecies->id;
            $oSpecies->picto = $oSpeciesId . '.jpeg';
            $oSpecies->update();
            $this->handleUploadedFile($data['spiece_picto'], $oSpeciesId);

            $oSpeciesLang = new ItrPetsSpeciesLang();
            $oSpeciesLang->id_species = $oSpeciesId;
            $oSpeciesLang->id_lang = Context::getContext()->language->id;
            $oSpeciesLang->label = $data['specie_name'];
            $oSpeciesLang->save();

            $this->addFlash(
                'success',
                $this->trans('Species information saved successfully.', 'Modules.Itrwishlist.Admin')
            );

            return $this->redirectToRoute('itrwishlist_form_simple');
        }

        return $this->render('@Modules/itrwishlist/views/templates/admin/form.html.twig', [
            'itrwishlistForm' => $form->createView(),
            'aSpecies' => $aSpecies,
            'label' => $label,
        ]);
    }

    private function handleUploadedFile(UploadedFile $file, $oSpeciesId)
    {
        // Implémentez la logique pour gérer l'upload du fichier et renvoyer le chemin vers le fichier enregistré
        // Vous pouvez utiliser la classe FileUploader ou une autre logique d'upload de fichier
        // N'oubliez pas de configurer les paramètres nécessaires, comme le répertoire de destination, etc.

        // Exemple simple :
        $destination = _PS_MODULE_DIR_ . 'itrwishlist/uploads/';
        $fileName = $oSpeciesId . '.jpeg';
        $file->move($destination, $fileName);

        return $fileName;
    }
}
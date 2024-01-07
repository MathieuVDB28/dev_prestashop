<?php
declare(strict_types=1);

namespace PrestaShop\Module\Itrwishlist\Form;

use Context;
use Language;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ItrwishlistFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specie_name', TextType::class, [
                'label' => $this->trans("Specie's name", 'Modules.Itrwishlist.Admin'),
                'help' => $this->trans("Enter the specie's name", 'Modules.Itrwishlist.Admin'),
            ])
            ->add('is_active', ChoiceType::class, [
                'label' => $this->trans('Is Active', 'Modules.Itrwishlist.Admin'),
                'choices' => [
                    $this->trans('Active', 'Modules.Itrwishlist.Admin') => true,
                    $this->trans('Inactive', 'Modules.Itrwishlist.Admin') => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('spiece_picto', FileType::class, [
                'label' => $this->trans('Picto', 'Modules.Itrwishlist.Admin'),
                'help' => $this->trans('Upload the picto', 'Modules.Itrwishlist.Admin'),
                'required' => true,
            ]);
    }
}
<?php

declare(strict_types=1);

namespace Marduk\Module\ProductCreationEdit\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductCreationEditFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cloning_override', CheckboxType::class, [
                'label' => $this->trans('Override creation stamp while cloning', 'Modules.DemoSymfonyFormSimple.Admin'),
                'help' => $this->trans('When turned on the creation stamp will be refreshed during cloning products', 'Modules.DemoSymfonyFormSimple.Admin'),
                'required' => false,
                'attr' => [
                  'material_design' => true,
                ],
            ]);
    }
}
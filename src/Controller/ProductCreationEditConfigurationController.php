<?php

declare(strict_types=1);

namespace Marduk\Module\ProductCreationEdit\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrestaShop\PrestaShop\Core\Form\Handler;

class ProductCreationEditConfigurationController extends FrameworkBundleAdminController
{

  public function index(Request $request): Response
  {
    $dataHandler = $this->getConfigurationFormHandler();

    $textForm = $dataHandler->getForm();
    $textForm->handleRequest($request);

    if ($textForm->isSubmitted() && $textForm->isValid()) {
      /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
      $errors = $dataHandler->save($textForm->getData());

      if (empty($errors)) {
        $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

        return $this->redirectToRoute('productcreationedit_configuration_route');
      }

      $this->flashErrors($errors);
    }

    return $this->render('@Modules/productcreationedit/views/templates/admin/form.html.twig', [
      'productCreationEditForm' => $textForm->createView()
    ]);
  }

  protected function getConfigurationFormHandler(): Handler
  {
    $handler = $this->get('marduk.module.product_creation_edit.form.configuration_handler');
    return $handler;
  }
}


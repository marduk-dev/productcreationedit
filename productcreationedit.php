<?php
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

use PrestaShop\PrestaShop\Core\Domain\Shop\ValueObject\ShopConstraint;
use Marduk\Module\ProductCreationEdit\Form\ProductCreationEditDataConfiguration;

class ProductCreationEdit extends Module
{
  public function __construct()
  {
      $this->name = 'productcreationedit';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Marduk';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = [
          'min' => '1.8.1.0',
          'max' => '8.99.99',
      ];
      $this->bootstrap = true;

      parent::__construct();

      $this->displayName = $this->trans('Marduk CreationEdit', [], 'Modules.ProductCreationEdit.Admin');
      $this->description = $this->trans('Allows to edit product creation date.', [], 'Modules.ProductCreationEdit.Admin');

      $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.ProductCreationEdit.Admin');
  }

  public function install()
  {
    if (Shop::isFeatureActive()) {
      Shop::setContext(Shop::CONTEXT_ALL);
    }

    return (
      parent::install() 
        && Configuration::updateValue(ProductCreationEditDataConfiguration::OVERRIDE_CLONE_TIMESTAMP_SETTING, true)
        && $this->registerHook('actionAdminDuplicateAfter')
    ); 
  }

  public function uninstall()
  {
    return (
      parent::uninstall() 
        && Configuration::deleteByName(ProductCreationEditDataConfiguration::OVERRIDE_CLONE_TIMESTAMP_SETTING)
    );
  }

  public function getContent()
  {
    $route = $this->get('router')->generate('productcreationedit_configuration_route');
    Tools::redirectAdmin($route);
  }

  public function hookActionAdminDuplicateAfter($params) {
    $this->get('marduk.module.product_creation_edit.controller.cloning_updater')->onClone($params['id_product_new']);
  }
}
<?php

declare(strict_types=1);

namespace Marduk\Module\ProductCreationEdit\Controller;

use PrestaShop\PrestaShop\Core\Domain\Product\ValueObject\ProductId;
use PrestaShop\PrestaShop\Adapter\Product\Repository\ProductRepository;
use Marduk\Module\ProductCreationEdit\Form\ProductCreationEditDataConfiguration;
use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Domain\Shop\ValueObject\ShopConstraint;
use PrestaShop\PrestaShop\Core\Domain\Product\Exception\CannotUpdateProductException;

class CloningUpdater
{
  private ProductRepository $productRepository;
  private ProductCreationEditDataConfiguration $productCreationEditDataConfiguration;

  public function __construct(ProductRepository $productRepository, DataConfigurationInterface $productCreationEditDataConfiguration) {
    $this->productRepository = $productRepository;
    $this->productCreationEditDataConfiguration = $productCreationEditDataConfiguration;
  }

  public function onClone(int $productIdValue): void {
    if ($this->productCreationEditDataConfiguration->isCloneTimeStampOverriden()) {
      $productId = new ProductId($productIdValue);

      $productDefaultShopId = $this->productRepository->getProductDefaultShopId($productId);
      $shopProduct = $this->productRepository->get($productId, $productDefaultShopId);
      $shopProduct->date_add = date('Y-m-d H:i:s');

      $this->productRepository->update(
        $shopProduct,
        ShopConstraint::shop($productDefaultShopId->getValue()),
        CannotUpdateProductException::FAILED_UPDATE_PRODUCT
      );
    }
  }
}


<?php

declare(strict_types=1);

namespace Marduk\Module\ProductCreationEdit\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use Psr\Log\LoggerInterface;

/**
 * Provider is responsible for providing form data, in this case, it is returned from the configuration component.
 *
 * Class ProductCreationEditDataProvider
 */
class ProductCreationEditDataProvider implements FormDataProviderInterface
{
    /**
     * @var DataConfigurationInterface
     */
    private $productCreationEditDataConfiguration;

    public function __construct(DataConfigurationInterface $productCreationEditDataConfiguration)
    {
        $this->productCreationEditDataConfiguration = $productCreationEditDataConfiguration;
    }

    public function getData(): array
    {
        return $this->productCreationEditDataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->productCreationEditDataConfiguration->updateConfiguration($data);
    }
}


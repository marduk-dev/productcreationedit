<?php
declare(strict_types=1);

namespace Marduk\Module\ProductCreationEdit\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;
use Exception;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class ProductCreationEditDataConfiguration implements DataConfigurationInterface
{
    public const OVERRIDE_CLONE_TIMESTAMP_SETTING = 'PRODUCTCREATIONEDIT_OVERRIDE_CLONE_TIMESTAMP';
    public const OVERRIDE_CLONE_TIMESTAMP_KEY = 'cloning_override';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        $return = [];

        $return[static::OVERRIDE_CLONE_TIMESTAMP_KEY] = $this->isCloneTimeStampOverriden();

        return $return;
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            if (is_bool($configuration[static::OVERRIDE_CLONE_TIMESTAMP_KEY])) {
              $this->configuration->set(static::OVERRIDE_CLONE_TIMESTAMP_SETTING, $configuration[static::OVERRIDE_CLONE_TIMESTAMP_KEY]);
            } else {
                $errors[] = static::OVERRIDE_CLONE_TIMESTAMP_KEY . ' value is is not boolean';
            }
        }

        /* Errors are returned here. */
        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration[static::OVERRIDE_CLONE_TIMESTAMP_KEY]);
    }

    public function isCloneTimeStampOverriden(): bool {
      $val = $this->configuration->get(static::OVERRIDE_CLONE_TIMESTAMP_SETTING);
      if (!is_bool($val)) {
        $val = (bool)$val;
      }
      return $val;
  }
}

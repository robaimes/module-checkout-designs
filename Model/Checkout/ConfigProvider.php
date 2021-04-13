<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model\Checkout;

use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Aimes\CheckoutDesigns\Scope\Config;
use Magento\Checkout\Model\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var Config  */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        $config = [];
        $design = $this->config->getDesign();

        if ($design) {
            foreach ($design->getConfigProviders() as $configProvider) {
                if ($configProvider instanceof ConfigProviderInterface) {
                    $config = array_merge_recursive($config, $configProvider->getConfig());
                }
            }
        }

        return $config;
    }
}

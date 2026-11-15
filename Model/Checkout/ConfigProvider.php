<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model\Checkout;

use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Aimes\CheckoutDesigns\Scope\Customer;
use Magento\Checkout\Model\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var Customer */
    private $customer;

    /**
     * @param Customer $customer
     */
    public function __construct(
        Customer $customer
    ) {
        $this->customer = $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        $config = [];
        $design = $this->customer->getActiveDesign();

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

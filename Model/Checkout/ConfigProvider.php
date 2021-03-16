<?php

namespace Aimes\CheckoutLayout\Model\Checkout;

use Aimes\CheckoutLayout\Model\Config\Source\CheckoutLayout as LayoutOptions;
use Aimes\CheckoutLayout\Scope\Config;
use Magento\Checkout\Model\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    private Config $config;
    private LayoutOptions $layoutOptions;

    public function __construct(
        Config $config,
        LayoutOptions $layoutOptions
    ) {
        $this->config = $config;
        $this->layoutOptions = $layoutOptions;
    }

    public function getConfig(): array
    {
        $config = [];
        $design = $this->config->getDesign();

        if ($design) {
            $options = $this->layoutOptions->toOptionArray();

            if (isset($options[$design])) {
                $config = $options[$design]['config_provider']->getConfig();
            }
        }

        return $config;
    }
}

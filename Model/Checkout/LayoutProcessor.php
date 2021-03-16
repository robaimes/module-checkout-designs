<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aimes\CheckoutLayout\Model\Checkout;

use Aimes\CheckoutLayout\Scope\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Aimes\CheckoutLayout\Model\Config\Source\CheckoutLayout as LayoutOptions;

class LayoutProcessor implements LayoutProcessorInterface
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

    /**
     * {@inheritdoc}
     */
    public function process($jsLayout)
    {
        $design = $this->config->getDesign();

        if ($design) {
            $options = $this->layoutOptions->toOptionArray();
            
            if (isset($options[$design])) {
                $options[$design]['layout_processor']->process($jsLayout);
            }
        }

        return $jsLayout;
    }
}

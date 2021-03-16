<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aimes\CheckoutLayout\Model\Checkout\Layout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class Processor3Step implements LayoutProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function process($jsLayout)
    {
        return $jsLayout;
    }
}

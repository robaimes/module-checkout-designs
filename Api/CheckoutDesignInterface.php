<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Api;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\ConfigProviderInterface;

interface CheckoutDesignInterface
{
    const KEY_DESIGN_CODE = 'code';
    const KEY_DESIGN_NAME = 'name';
    const KEY_DESIGN_LAYOUT_HANDLE = 'layoutHandle';
    const KEY_DESIGN_LAYOUT_PROCESSORS = 'layoutProcessors';
    const KEY_DESIGN_CONFIG_PROVIDERS = 'configProviders';

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLayoutHandle();

    /**
     * @return LayoutProcessorInterface[]
     */
    public function getLayoutProcessors();

    /**
     * @return ConfigProviderInterface[]
     */
    public function getConfigProviders();
}

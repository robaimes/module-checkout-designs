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
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLayoutHandle(): string;

    /**
     * @return LayoutProcessorInterface[]
     */
    public function getLayoutProcessors(): array;

    /**
     * @return ConfigProviderInterface[]
     */
    public function getConfigProviders(): array;
}

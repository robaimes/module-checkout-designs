<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\ConfigProviderInterface;

class CheckoutDesign implements CheckoutDesignInterface
{
    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /** @var string */
    private $layoutHandle;

    /** @var LayoutProcessorInterface[] */
    private $layoutProcessors;

    /** @var ConfigProviderInterface[] */
    private $configProviders;

    /**
     * @param string $code
     * @param string $name
     * @param string $layoutHandle
     * @param LayoutProcessorInterface[] $layoutProcessors
     * @param ConfigProviderInterface[] $configProviders
     */
    public function __construct(
        string $code = '',
        string $name = '',
        string $layoutHandle = '',
        array $layoutProcessors = [],
        array $configProviders = []
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->layoutHandle = $layoutHandle;
        $this->layoutProcessors = $layoutProcessors;
        $this->configProviders = $configProviders;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLayoutHandle(): string
    {
        return $this->layoutHandle;
    }

    /**
     * @return LayoutProcessorInterface[]
     */
    public function getLayoutProcessors(): array
    {
        return $this->layoutProcessors;
    }

    /**
     * @return ConfigProviderInterface[]
     */
    public function getConfigProviders(): array
    {
        return $this->configProviders;
    }
}

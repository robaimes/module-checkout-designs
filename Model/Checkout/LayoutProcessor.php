<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model\Checkout;

use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Aimes\CheckoutDesigns\Scope\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
{
    /** @var Config */
    private $config;

    /** @var CheckoutDesigns */
    private $checkoutDesigns;

    /**
     * @param Config $config
     * @param CheckoutDesigns $checkoutDesigns
     */
    public function __construct(
        Config $config,
        CheckoutDesigns $checkoutDesigns
    ) {
        $this->config = $config;
        $this->checkoutDesigns = $checkoutDesigns;
    }

    /**
     * {@inheritdoc}
     */
    public function process($jsLayout): array
    {
        $design = $this->config->getDesign();

        if ($design) {
            foreach ($design->getLayoutProcessors() as $layoutProcessor) {
                if ($layoutProcessor instanceof LayoutProcessorInterface) {
                    $jsLayout = $layoutProcessor->process($jsLayout);
                }
            }
        }

        return $jsLayout;
    }
}

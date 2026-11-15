<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model\Checkout;

use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Aimes\CheckoutDesigns\Scope\Customer;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
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
    // phpcs:ignore Magento2.Annotation.MethodArguments.InheritDoc
    public function process($jsLayout): array
    {
        $design = $this->customer->getActiveDesign();

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

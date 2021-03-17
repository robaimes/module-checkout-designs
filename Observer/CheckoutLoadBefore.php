<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Observer;

use Aimes\CheckoutDesigns\Scope\Config;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutLoadBefore implements ObserverInterface
{
    /** @var Config */
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
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $route = $observer->getEvent()->getFullActionName();

        if ($route === 'checkout_index_index') {
            if ($design = $this->config->getDesign()) {
                $observer->getEvent()
                    ->getLayout()
                    ->getUpdate()
                    ->addHandle($design->getLayoutHandle());
            }
        }
    }
}

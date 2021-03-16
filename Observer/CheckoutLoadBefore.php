<?php

namespace Aimes\CheckoutLayout\Observer;

use Aimes\CheckoutLayout\Scope\Config;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutLoadBefore implements ObserverInterface
{
    private Config $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function execute(Observer $observer)
    {
        $route = $observer->getEvent()->getFullActionName();

        if ($route === 'checkout_index_index') {
            if ($design = $this->config->getDesign()) {
                $observer->getEvent()->getLayout()->getUpdate()->addHandle($design);
            }
        }

        return $this;
    }
}

<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Observer;

use Aimes\CheckoutDesigns\Scope\Config;
use Aimes\CheckoutDesigns\Scope\Customer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class CheckoutLoadBefore implements ObserverInterface
{
    /** @var Config */
    private $config;

    /** @var Customer */
    private $customer;

    /**
     * @param Config $config
     * @param Customer $customer
     */
    public function __construct(
        Config $config,
        Customer $customer
    ) {
        $this->config = $config;
        $this->customer = $customer;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer): void
    {
        $route = $observer->getEvent()->getFullActionName();

        if ($route === 'checkout_index_index') {
            if ($design = $this->customer->getActiveDesign()) {
                $observer->getEvent()
                    ->getLayout()
                    ->getUpdate()
                    ->addHandle($design->getLayoutHandle());
            }
        }
    }
}

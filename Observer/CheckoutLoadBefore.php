<?php

/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Observer;

use Aimes\CheckoutDesigns\Scope\Customer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class CheckoutLoadBefore implements ObserverInterface
{
    /** @var Customer */
    private Customer $customer;

    /**
     * @param Customer $customer
     */
    public function __construct(
        Customer $customer
    ) {
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

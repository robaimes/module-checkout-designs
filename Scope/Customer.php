<?php

/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Scope;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Throwable;

class Customer
{
    /** @var Config */
    private Config $config;

    /** @var CustomerSession */
    private CustomerSession $customerSession;

    /**
     * @param Config $config
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Config $config,
        CustomerSession $customerSession
    ) {
        $this->config = $config;
        $this->customerSession = $customerSession;
    }

    /**
     * @return CheckoutDesignInterface|null
     */
    public function getActiveDesign(): ?CheckoutDesignInterface
    {
        $groupMapping = $this->config->getCustomerGroupMapping();

        try {
            if ($groupMapping !== null) {
                $currentCustomerGroup = $this->customerSession->getCustomerGroupId();

                if (isset($groupMapping[$currentCustomerGroup])) {
                    return $this->config->getDesign($groupMapping[$currentCustomerGroup]);
                }
            }
        } catch (Throwable) {
            return $this->config->getDesign();
        }

        return $this->config->getDesign();
    }
}

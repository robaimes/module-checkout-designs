<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Scope;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Magento\Customer\Model\Session as CustomerSession;

class Customer
{
    /** @var Config */
    private $config;

    /** @var CustomerSession */
    private $customerSession;

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
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getActiveDesign(): ?CheckoutDesignInterface
    {
        $groupMapping = $this->config->getCustomerGroupMapping();

        if ($groupMapping !== null) {
            $currentCustomerGroup = $this->customerSession->getCustomerGroupId();

            if (isset($groupMapping[$currentCustomerGroup])) {
                return $this->config->getDesign($groupMapping[$currentCustomerGroup]);
            }
        }

        return $this->config->getDesign();
    }
}

<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Observer;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Aimes\CheckoutDesigns\Scope\Config;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CheckoutLoadBefore implements ObserverInterface
{
    /** @var Config */
    private $config;

    /** @var CustomerSession */
    private $customerSession;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config,
        CustomerSession $customerSession
    ) {
        $this->config = $config;
        $this->customerSession = $customerSession;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $route = $observer->getEvent()->getFullActionName();

        if ($route === 'checkout_index_index') {
            if ($design = $this->getDesign()) {
                $observer->getEvent()
                    ->getLayout()
                    ->getUpdate()
                    ->addHandle($design->getLayoutHandle());
            }
        }
    }

    /**
     * @return CheckoutDesignInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getDesign(): ?CheckoutDesignInterface
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

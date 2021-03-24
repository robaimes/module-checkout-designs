<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Scope;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_PATH_CHECKOUT_DESIGN = 'checkout/design/design';
    const XML_PATH_CUSTOMER_GROUP_DESIGN_MAPPING_ENABLED = 'checkout/design/enable_customer_groups';
    const XML_PATH_CUSTOMER_GROUP_DESIGN_MAPPING = 'checkout/design/customer_group_mapping';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var CheckoutDesigns */
    private $checkoutDesigns;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckoutDesigns $checkoutDesigns
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckoutDesigns $checkoutDesigns,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutDesigns = $checkoutDesigns;
        $this->serializer = $serializer;
    }

    /**
     * @return CheckoutDesignInterface|null
     */
    public function getDesign(?string $code = null): ?CheckoutDesignInterface
    {
        if ($code === null) {
            $code = $this->scopeConfig->getValue(
                self::XML_PATH_CHECKOUT_DESIGN,
                ScopeInterface::SCOPE_STORE
            );
        }

        return $this->checkoutDesigns->getDesignByCode($code);
    }

    /**
     * @return bool
     */
    public function isCustomerGroupMappingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CUSTOMER_GROUP_DESIGN_MAPPING_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    private function getSerializedCustomerGroupMapping(): ?string
    {
        if (!$this->isCustomerGroupMappingEnabled()) {
            return null;
        }

        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_GROUP_DESIGN_MAPPING,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array|null
     */
    public function getCustomerGroupMapping(): ?array
    {
        if (!$serializedMapping = $this->getSerializedCustomerGroupMapping()) {
            return null;
        }

        $groupMapping = [];
        $mapping = $this->serializer->unserialize($serializedMapping);

        foreach ($mapping as $item) {
            $groupMapping[$item['customer_group']] = $item['design'];
        }

        return $groupMapping;
    }
}

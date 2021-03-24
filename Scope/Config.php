<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Scope;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_PATH_CHECKOUT_DESIGN = 'checkout/design/design';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var CheckoutDesigns
     */
    private $checkoutDesigns;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckoutDesigns $checkoutDesigns
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckoutDesigns $checkoutDesigns
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutDesigns = $checkoutDesigns;
    }

    /**
     * @return CheckoutDesignInterface|null
     */
    public function getDesign(): ?CheckoutDesignInterface
    {
        $code = $this->scopeConfig->getValue(
            self::XML_PATH_CHECKOUT_DESIGN,
            ScopeInterface::SCOPE_STORE
        );

        return $this->checkoutDesigns->getDesignByCode($code);
    }
}

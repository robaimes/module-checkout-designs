<?php

namespace Aimes\CheckoutLayout\Scope;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_PATH_CHECKOUT_DESIGN = 'checkout/design/design';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getDesign()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CHECKOUT_DESIGN,
            ScopeInterface::SCOPE_STORE
        );
    }
}

<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Block\Adminhtml\Form\Field;

use Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class Designs extends Select
{
    /** @var CheckoutDesigns */
    private $checkoutDesigns;

    /**
     * @param Context $context
     * @param CheckoutDesigns $checkoutDesigns
     * @param array $data
     */
    public function __construct(
        Context $context,
        CheckoutDesigns $checkoutDesigns,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutDesigns = $checkoutDesigns;
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->checkoutDesigns->toOptionArray());
        }

        return parent::_toHtml();
    }

    /**
     * @param string $value
     * @return Designs
     */
    public function setInputName(string $value): Designs
    {
        return $this->setName($value);
    }

    /**
     * @param string $value
     * @return Designs
     */
    public function setInputId(string $value): Designs
    {
        return $this->setId($value);
    }
}

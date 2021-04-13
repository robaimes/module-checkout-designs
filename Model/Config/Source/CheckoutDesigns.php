<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Model\Config\Source;

use Aimes\CheckoutDesigns\Api\CheckoutDesignInterface;
use Magento\Framework\Data\OptionSourceInterface;

class CheckoutDesigns implements OptionSourceInterface
{
    /** @var CheckoutDesignInterface[] */
    public $designs;

    /**
     * @param array $designs
     */
    public function __construct(
        array $designs = []
    ) {
        $this->designs = $designs;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [[
            'label' => 'Default',
            'value' => 'default',
        ]];

        foreach ($this->designs as $design) {
            if ($design instanceof CheckoutDesignInterface) {
                array_push($options, [
                    'label' => $design->getName(),
                    'value' => $design->getCode(),
                ]);
            }
        }

        return $options;
    }

    /**
     * Get CheckoutDesign from provided code
     *
     * TODO: Review for a potentially more efficient (or safer) way to return the item
     *
     * @param string $code
     * @return CheckoutDesignInterface|null
     */
    public function getDesignByCode(string $code): ?CheckoutDesignInterface
    {
        $design = array_filter(
            $this->designs,
            function ($design) use ($code) {
                return $design->getCode() === $code;
            }
        );

        return !empty($design)
            ? reset($design)
            : null;
    }
}

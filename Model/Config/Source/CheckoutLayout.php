<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aimes\CheckoutLayout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * @api
 * @since 100.0.2
 */
class CheckoutLayout implements OptionSourceInterface
{
    public array $layouts;

    public function __construct(
        $layouts = []
    ) {
        $this->layouts = $layouts;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [[
            'label' => 'Default',
            'value' => '0',
        ]];

        foreach ($this->layouts as $layout) {
            $handle = $layout['layout_handle'];

            $options[$handle] = [
                'label' => $layout['label'],
                'value' => $handle,
                'layout_processor' => $layout['layout_processor'],
                'config_provider' => $layout['config_provider'],
            ];
        }

        return $options;
    }
}

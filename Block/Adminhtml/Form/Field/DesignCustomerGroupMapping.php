<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class DesignCustomerGroupMapping extends AbstractFieldArray
{
    /** @var CustomerGroups|null */
    private ?CustomerGroups $customerGroupRenderer;

    /** @var Designs|null */
    private ?Designs $designRenderer;

    /**
     * @throws LocalizedException
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('customer_group', [
            'label' => __('Customer Group'),
            'renderer' => $this->getCustomerGroupRenderer(),
        ]);

        $this->addColumn('design', [
            'label' => __('Design'),
            'renderer' => $this->getDesignRenderer(),
        ]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add New Mapping');
    }

    /**
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $customerGroup = $row->getCustomerGroup();
        $design = $row->getDesign();

        if ($customerGroup !== null) {
            $selected = $this->getCustomerGroupRenderer()->calcOptionHash($customerGroup);
            $options['option_' . $selected] = 'selected="selected"';
        }

        if ($design !== null) {
            $selected = $this->getDesignRenderer()->calcOptionHash($design);
            $options['option_' . $selected] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return CustomerGroups
     * @throws LocalizedException
     */
    private function getCustomerGroupRenderer(): CustomerGroups
    {
        if (!$this->customerGroupRenderer) {
            /** @var CustomerGroups $block */
            $block = $this->getLayout()->createBlock(
                CustomerGroups::class,
                '',
                [
                    'data' => [
                        'is_render_to_js_template' => true,
                        'class' => 'required-entry validate-no-empty',
                    ]
                ]
            );

            $this->customerGroupRenderer = $block;
        }

        return $this->customerGroupRenderer;
    }

    /**
     * @return Designs
     * @throws LocalizedException
     */
    private function getDesignRenderer(): Designs
    {
        if (!$this->designRenderer) {
            /** @var Designs $block */
            $block = $this->getLayout()->createBlock(
                Designs::class,
                '',
                [
                    'data' => [
                        'is_render_to_js_template' => true,
                        'class' => 'required-entry validate-no-empty',
                    ]
                ]
            );

            $this->designRenderer = $block;
        }

        return $this->designRenderer;
    }
}

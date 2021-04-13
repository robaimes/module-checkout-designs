<?php
/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\CheckoutDesigns\Block\Adminhtml\Form\Field;

use Magento\Customer\Api\GroupManagementInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class CustomerGroups extends Select
{
    /** @var array */
    private $customerGroups;

    /** @var GroupManagementInterface */
    protected $groupManagement;

    /** @var GroupRepositoryInterface */
    protected $groupRepository;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * @param Context $context
     * @param GroupManagementInterface $groupManagement
     * @param GroupRepositoryInterface $groupRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        GroupManagementInterface $groupManagement,
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->groupManagement = $groupManagement;
        $this->groupRepository = $groupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function getCustomerGroups(): array
    {
        if ($this->customerGroups === null) {
            $this->customerGroups = [];

            foreach ($this->groupRepository->getList($this->searchCriteriaBuilder->create())->getItems() as $item) {
                $this->customerGroups[$item->getId()] = $item->getCode();
            }

            $notLoggedInGroup = $this->groupManagement->getNotLoggedInGroup();
            $this->customerGroups[$notLoggedInGroup->getId()] = $notLoggedInGroup->getCode();
        }

        return $this->customerGroups;
    }

    /**
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            foreach ($this->getCustomerGroups() as $groupId => $groupLabel) {
                $this->addOption($groupId, addslashes($groupLabel));
            }
        }
        return parent::_toHtml();
    }

    /**
     * @param string $inputName
     * @return CustomerGroups
     */
    public function setInputName(string $inputName): CustomerGroups
    {
        return $this->setName($inputName);
    }

    /**
     * @param string $inputId
     * @return CustomerGroups
     */
    public function setInputId(string $inputId): CustomerGroups
    {
        return $this->setId($inputId);
    }
}

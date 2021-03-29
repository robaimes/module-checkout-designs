# Aimes_CheckoutDesigns [![magento-badge][magento-link]]

## Features

> Please note: This module is currently still considered a proof of concept.

This module provides the ability to change checkout page designs/layout in a similar fashion to [page specific selectable layouts](https://devdocs.magento.com/guides/v2.4/frontend-dev-guide/layouts/xml-manage.html#create-cms-pageproductcategory-specific-selectable-layouts).

The module currently provides the following functionality:

* Provide a different checkout user experience per store
* Provide a different checkout user experience per customer group

This in turn will allow you to do things such as, but not limited to, the following:

> Please note: These are only examples of functionality that this module makes possible. This module itself does not provide any additional functionality or checkout designs and serves only as a base for other modules. For an example module, please see [`Aimes_CheckoutDesignsExample`](https://github.com/robaimes/module-checkout-designs-example)

* AB Testing any checkout changes
* Something broken or users can't checkout with a specific design? Select a different design or the default Magento checkout so that users can still checkout until you can deploy your fixed code.
* Collect different data per design to help determine any issues
    * Track the different drop-off points
    * Track conversion rates

Any feature requests and/or pull requests are welcomed!

## Requirements

This module is compatible with Magento 2.3.x and Magento 2.4.x

## Installation

Please install this module via Composer

* `composer require aimes/module-checkout-designs`
* `bin/magento module:enable Aimes_CheckoutDesigns`
* `bin/magento setup:upgrade`

## Usage

> All of this is subject to (and very likely to!) change.

### Step 1: Define new checkout layout
`di.xml`
```xml
<virtualType name="Vendor\Module\Model\Checkout\Design\MyDesign"
             type="Aimes\CheckoutDesigns\Model\CheckoutDesign">
    <arguments>
        <argument name="code" xsi:type="string">my_design_code</argument>
        <argument name="name" xsi:type="string">My Design Name</argument>
        <argument name="layoutHandle" xsi:type="string">my_design_layout_handle</argument>
        <argument name="layoutProcessors" xsi:type="array">
            <item name="defaultProcessor" xsi:type="object">
                <!-- Object must implement \Magento\Checkout\Block\Checkout\LayoutProcessorInterface -->
            </item>
        </argument>
        <argument name="configProviders" xsi:type="array">
            <item name="defaultProvider" xsi:type="object">
                <!-- Object must implement \Magento\Checkout\Model\ConfigProviderInterface -->
            </item>
        </argument>
    </arguments>
</virtualType>
```

#### Explanation

* Designs must implement `\Aimes\CheckoutDesigns\Api\CheckoutDesignInterface` 
    * `code` is a unique identifier for your design
    * `name` is the frontend / human friendly label
    * `layoutHandle` is the layout handle that will be included on the page. The above would include `my_design_layout_handle.xml`
    * `layoutProcessors` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Block\Checkout\LayoutProcessorInterface`
    * `configProviders` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Model\ConfigProviderInterface`
    
#### Example code
For working code examples, please refer to [`Aimes_CheckoutDesignsExample`](https://github.com/robaimes/module-checkout-designs-example). This package can also be installed.
    
### Step 2: Add your design to the available options
`di.xml`
```xml
<type name="Aimes\CheckoutDesigns\Model\Config\Source\CheckoutDesigns">
    <arguments>
        <argument name="designs" xsi:type="array">
            <item name="my_design" xsi:type="object">
                Vendor\Module\Model\Checkout\Design\MyDesign
            </item>
        </argument>
    </arguments>
</type>
```
    
### Step 3: Select design
Your design should now show up as an option in the system configuration below:

`Sales -> Checkout -> Design / Layout -> Checkout Design`

* Select the default design
* Select specific designs per customer groups

## Licence
[GPLv3][gpl-url] © Rob Aimes


[gpl-url]:https://www.gnu.org/licenses/gpl-3.0.en.html
[magento-badge]:https://img.shields.io/badge/magento-2.3.x%20%7C%202.4.x-orange.svg?logo=magento
[magento-url]:https://devdocs.magento.com/:w

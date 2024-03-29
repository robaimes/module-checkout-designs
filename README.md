# Aimes_CheckoutDesigns

!["Supported Magento Version"][magento-badge] !["Latest Release"][release-badge]

* Compatible with _Magento Open Source_ and _Adobe Commerce_ `2.3.x` & `2.4.x`
* Compatible with _[Hyvä Themes][hyva]_ using the _Luma Checkout Fallback_

## Features

This module provides the ability to change checkout page designs/layout similar to [page specific selectable layouts][page-layouts].

The module currently provides the following functionality:

* Provide a different checkout user experience per store
* Provide a different checkout user experience per customer group

<details>
  <summary>Example Config</summary>
   
  ![Example Config](https://user-images.githubusercontent.com/4225347/112895353-ec7ccb00-90d4-11eb-937f-cd54636fbf19.png)
</details>

This in turn will allow you to do things such as, but not limited to, the following:

> Please note: These are only examples of functionality that this module makes possible. This module itself does not provide any additional functionality and serves only as a base for other modules. For example usage, please see [`Aimes_CheckoutDesignsExample`][example-module].

* AB Testing any checkout changes
* Something broken or users can't checkout with a specific design? Select a different design or the default Magento checkout so that users can still checkout until you can deploy your fixed code.
* Collect different data per design to help determine any issues
    * Track the different drop-off points
    * Track conversion rates

Any feature requests and/or pull requests are welcomed!

## Requirements

* Magento Open Source or Adobe Commerce version `2.3.x` or `2.4.x`

## Installation

Please install this module via Composer. This module is hosted on [Packagist][packagist].

* `composer require aimes/module-checkout-designs`
* `bin/magento module:enable Aimes_CheckoutDesigns`
* `bin/magento setup:upgrade`

## Usage

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
    * `code` is a unique string identifier for your design
    * `name` is a string to represnt the frontend / human friendly label
    * `layoutHandle` is a string to represent the layout handle that will be processed when the design is in use. The above would include `my_design_layout_handle.xml`
    * `layoutProcessors` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Block\Checkout\LayoutProcessorInterface`
    * `configProviders` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Model\ConfigProviderInterface`
    
#### Example code
For working code examples, please refer to [`Aimes_CheckoutDesignsExample`][example-module]. This package can also be installed.
    
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
[GPLv3][gpl] © [Rob Aimes][author]

[magento-badge]:https://img.shields.io/badge/magento-2.3.x%20%7C%202.4.x-orange.svg?logo=magento&style=for-the-badge
[release-badge]:https://img.shields.io/github/v/release/robaimes/module-checkout-designs?sort=semver&style=for-the-badge&color=blue
[page-layouts]:https://devdocs.magento.com/guides/v2.4/frontend-dev-guide/layouts/xml-manage.html#create-cms-pageproductcategory-specific-selectable-layouts
[example-module]:https://github.com/robaimes/module-checkout-designs-example
[packagist]:https://packagist.org/packages/aimes/module-checkout-designs
[gpl]:https://www.gnu.org/licenses/gpl-3.0.en.html
[author]:https://aimes.dev/
[hyva]:https://hyva.io/

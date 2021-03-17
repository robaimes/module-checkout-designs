# Aimes_CheckoutDesigns

Proof of concept module to provide the ability to add custom checkout layout updates, and switch via system configuration.

The main idea is the ability to have different layouts for the checkout that can be managed in separate layout files. Currently these all implement / extend from `checkout_index_index.xml`

Potential useful scenarios:

* AB Testing checkout changes and redesigns
    * Collect data per design
* Provide different checkout experience on different storefronts
* Provide different checkout experience to certain user groups
* Provide different checkout experience depending on other criteria...

## Support

**Currently this is a proof of concept and no support will be provided if you decide to use this in its current state.**

* This module has been created and semi-tested on Magento 2.4.2
* This module _should_ be compatible with Magento 2.3.x, but I make no guarantee

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

#### What's going on?
* Designs must implement `\Aimes\CheckoutDesigns\Api\CheckoutDesignInterface` 
    * `code` is a unique identifier for your design
    * `name` is the frontend / human friendly label
    * `layoutHandle` is the layout handle that will be included on the page. The above would include `my_design_layout_handle.xml`
    * `layoutProcessors` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Block\Checkout\LayoutProcessorInterface`
    * `configProviders` is an array of objects that will only be processed when the associated design is utilised
        * Items must implement `\Magento\Checkout\Model\ConfigProviderInterface`
    
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

Currently, this supports changes per website or per store, but further improvements can be made in the future.

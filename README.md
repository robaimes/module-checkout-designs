# Aimes_CheckoutLayout

Proof of concept module to provide the ability to add custom checkout layout updates, and switch via system configuration.

The main idea is the ability to have different layouts for the checkout that can be managed in separate layout files. Currently these all implement / extend from `checkout_index_index.xml`

Useful scenarios (not yet implemented):

* AB Testing checkout changes and redesigns
* Provide different checkout experience on different storefronts
* Provide different checkout experience to certain user groups
* Provide different checkout experience depending on other criteria...

## Support

**Currently this is a proof of concept and no support will be provided if you decide to use this in its current state.**

* This module has been created and tested on Magento 2.4.2.
* This module makes use of PHP 7.4 features, and as such will only support Magento versions that support this requirement.

## Usage

> All of this is subject to (and very likely to!) change.

### Step 1: Define new checkout layout
> Currently this is done with a simple array, but will make use of `<virtualType>` declarations in the future

`di.xml`
```xml
<type name="Aimes\CheckoutLayout\Model\Config\Source\CheckoutLayout">
    <arguments>
        <argument name="layouts" xsi:type="array">
            <item name="unique_key" xsi:type="array">
                <item name="label" xsi:type="string" translatable="true">My New Custom Checkout Layout</item>
                <item name="layout_handle" xsi:type="string">my_custom_layout_handle</item>
                <item name="layout_processor" xsi:type="object">Vendor\Module\Model\Checkout\Layout\CustomLayout\LayoutProcessor</item>
                <item name="config_provider" xsi:type="object">Vendor\Module\Model\Checkout\Config\CustomLayout\ConfigProvider</item>
            </item>
        </argument>
    </arguments>
</type>
```

#### What's going on?
* Label will be used to describe the layout. Currently, this is used in the admin config dropdown.
* The config provider and layout processors will only be processed if that design is selected for use.
    * These currently accept a single object, but will support multiple in future to act as a composite design provider
* The `layout_handle` argument is currently hwo you determine which layout file should be included on the page
    * For example a value of `custom_checkout_design` will add `custom_checkout_design.xml` to the page handles
    
### Step 2: Select design
* `Sales -> Checkout -> Design / Layout -> Checkout Design`
* Again, this could support customer groups, or other conditionals in the future

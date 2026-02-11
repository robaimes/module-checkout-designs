# Aimes_CheckoutDesigns

!["Supported Magento Version"][magento-badge] !["Supported Adobe Commerce Version"][adobe-commerce-badge] !["Supported Mage OS Version"][mage-os-badge] !["Latest Release"][release-badge]

* Compatible with _Magento Open Source_ and _Adobe Commerce_ `2.3.x` & `2.4.x`
* Compatible with _[Hyvä Themes][hyva]_ using the _Luma Checkout Fallback_
* Compatible with Mage OS

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

[magento-badge]:https://img.shields.io/badge/magento-2.3.x%20%7C%202.4.x-orange.svg?style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAADz0lEQVR4AZSVXYhVVRTHf+vcGYoYyMGMeigyyaSSHoJ6iGIy8kF6yGhmwsfog8KSqCjo5b7Zg0VkHzAFPZZ3RIekl5Kah+qhR0kU6ZOCwigHRdE795zlf+19zp3Rex10s9fZa//X9zpn71OwwnAwf5ZR6uFP8rA/wQT1CFno1NuhyyUD+AQjBm4zLPokN5RTfOwVB934tpzmQ2FrQhY6oTvUu8CBADJsBdk8PW9T+BSvy+kv5jyNg4HK4nlhv0r2ChoWupO0wk7bC2Y/QNh6ZD1LaSIZP+ZHOOrOW7K4RhTzpByfVrAIMuawq5rmiE/zaNgEuVoq3EI5KAUIQIhbzmRjNcVXwvZTcVtKWZoK9JmVbLCCuxRkTnKhmhUbJDsgmy9VwR39tpEtCymaqde+ldXq7W7Bh9SKR4QRAvE/KuMHWnvZZvv42z7n96LDVoPNkh1CjFY0trhxWO/qHd/GuGDFxYrEqDU+yvdWsV0BsQTyjyp4qpjlPpX+nUeP23onNQn7WrK7pbod4wRh6LiSedl7fKOAgvHUIm7iKgHjItVCT+vbdpZ1tpdPxec5TmFtqiDmyXaAdfjAutwqTx8pMSeP1fEugs2KC4SgG4DoqHV41Q5wRnyaat271QJvpo0e1fXsLCfZKTZNm2OhtYcX1JO/Im2BXY4ln0uZCDRRzP7h0texvpriZ3N24KyiGc51Un6jmuQnte7mgLWOaY1EURCJSSNXkNhljxNUaVdxp9Z1ch6tWxTfzK6cBB/y24Ph6qSV2OWP4QEaDeNcw6rWflZytcQ3OrnNffWGGQxgdW6h4TVvsbkENTqrat2L1AYD+EUasR2GBX4ZNBggjP4dnk2IrpSWB2jyXKkhl+dfB65RzAFy//K9b3qFjbRZrzzkKOtzF3KAP9PX8l/tr1WveWnqqvQdZQSZZjuWjfwVFSk957jpPxLSfNnN07Mu9+uy+kTGzpraWVQT2btUC07rmafRP+UZ0NOIxHry8Z6dYxMaMqsvOzCbY6HV4RldeFsgKWtZmjrNm/1xbtRv8xbxE7YkypxT6jp/SD522BecCufS8VRqMN6m0HFv6Zb8Tec3H7CoQOaSg3Gvj3BMv83D4jfq3gkMpZJP/T2ctX384ROMuCQWZx9IAbRibSo5L12BaKdOwrUcNHhNZZ/RisYYTv67GSdVyYuU/CAcZOOytWh37RyNfgDxaVpbgaTgYDbDonXYZYusxZiRc6FE8rvlfK3N8r6oRMNkY21yNdo3cyBAIzAZBB/3uu3nuO3hOd33m8x5UH1+SY7/D1norETnAQAA//+Y9KBSAAAABklEQVQDAGztYjr3b7CxAAAAAElFTkSuQmCC
[adobe-commerce-badge]:https://img.shields.io/badge/adobe%20commerce-2.3.x%20%7C%202.4.x-red.svg?style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEBElEQVR4AZSVO4hdVRSG/73vdUJwZu4kZjIhpBFiI2IVQdTGIipoLJQQVFTwFVMJWqQLpNLWTvBRxJAmNoKvykrstBVExBdkZq6PTKYx3nPO9vvXvvdkhkwguex11utf/1pn733vzbrBp0gDp9YW9el4SWV9pGY8UrGE7diSvjEG7A15dky4IEnt+qLuSkmPmwTZinXzoqIHaXgEbEeNY8C2r61FWzMRh/xVZFCKGjQ8FYItYm1o6VSNqs9P/VBBFNb0wSSua1ZXdDv289Nwnc4UlhqsMen46rz2E27Ao2py9ryuAYkozFd1HPsA0lDFwtqyCLDUEFoYDPUc2itqbcxkpwZdJItO+lXYitS/PCOy75F2jFw2hoJXHEyKhjZ72daA+gGgbm1BD4C4H6G23qYgTuog9uEqfMn1bSq6mwvxGHiHt72FAY7PJNlgqtn0HXYlS5xrUWbqFE2S5Bx+scZ9XTt8+gZMnwE14306qBT7b3hMQ67DIa2vyF2ybWKPi10xScd4i8OAWvA9b28ADLtM9AL2bqRhsgSRet3pDRV9Ts6rFWzTnLEZ/yUnkIzECoOO4ORrZv9lOxBnyAxqeUCl75c39SPYi+QEJpqT83Kdt/LF3w9pN2BzoRSH1APWl/QkzmGkTao5iIoJIX6fuPZv6Gv0D4i3pvMQSYFtlHRw7oqeJuflfCTshHAbTkHIaeImD+RyDfE2Jp0uouGIq3jOTcH6bOQgfkrUsE6qfiKXmcyH267u0T3EH0G8ojuGtwelTw5t6i+wc3aGWRew/8Meouu1lVxTaPbQn4u6L0nx++S9c4L7p9c8AZP4wOIt8H0tVTp9BJmXb8hg7z/6DYLPHEBaSAVW1LbWXdLsLZKnn/y9RyOS177uhTKp5ekBvlvZ1LeEXOsYYVbRh9SYuB42AKIxLPrEpXktM0RjArWdTuDsJdGgWXJhHC6s58XnF2kXHD4PPGn5Ct8J6SecARL7TSFLDf48v0/PohUNKPTPspgoCwg+Kw53fd9lvWvgndK/pDyAt2kOu+NSfOxrwBDRQATNgS/i8Z3IayMdheAIYtKM9rJtvcEfyum1JZ0dL+oM/2TvYD8Fjw9YbdJ5gN62/rDJmcMN7x0v6AmfwVvuSOf4TTErvg/Xvv/R3uaqnSlJZ4mfZur3IL0NyQc29LOSvnQN0mHLApfAqmS96W6Pqn5sV4tqAAmgr2CjJG9NQ/IqsszbHGXSDls8PgAn8GJbqqhuPfmHsxMG4PgMquBMY4leQ2xvgfXA+JT1DBDz5ZXL+iJJv+IPwPruY9IHx9iY2sZNStwiGh77Y0F3QMyV14THObPCURDNxDHvdUPBrYi3abQraba1GrS6AMcE8Q5s4/ofAAD//1LB0XgAAAAGSURBVAMAZFiYxTIfQh8AAAAASUVORK5CYII=
[mage-os-badge]:https://img.shields.io/badge/Mage%20OS-2.x-orange.svg?style=for-the-badge&logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAADyElEQVR4AexUTYhbVRT+znkvmUkmE1LFUm2tybRC0WqRVhQXMi5EVwpKVfwruBg3DkmmdlERfSA4UEFbdFNdtKCoWBTBhUVE2kVBmB+lLaJYGaugogs1ySA0793jd57pjNaObnQheMnl3nu+73zfuSfvPcW/PP43+NsG/2WLLIHadkQrqTjmnJVwj5/XwACxZDyWBEEOIbNzjM4KO+Yc5xpzcJ7xJwMnC2CSHEk7O+ubuq2xOyQ5azQe5zhNPdZp12/vNRtXO1eY49i5HksGS1VR2JIrit1W/UkJ+BgIb3abYx8sTl12TS5EvNveeGWn3XgXkLdNMN9r1Z+29rqS48aga2EwNA94OwZVdZv1u3s//fI54wkgQxBJTcJNIcg8Tff22o09sOykmN3KqlMIogDs7iH+oteu72DMvHV+G2qI5oHkSLrYHtvWbTWOQuV1g60XkT4A44i5z0gGRJrBbBeYBDc2i4kb8b4ZLjbIwU6r/mFnasMNfhvSTDu7N13YbTf2BwszFL4RQMoEHq1gLJt7d4m4Uis4lpJjloWYK31ECBS4D5yOX4eQHfv5kfUHu49uWK0SCvcQmDAgo0hGcsxk1WKE0iU16DB1WB45hDWmqeNSqJVQWlN1c0JwIx3kZqKSDq+p7iivrd7PP1m9IhLyfkSiiqGLKiivqyEeKeL3gwKIhosora1hePUotPDbK0LnnOZrYVU5Grl0lRRZgKr21QQs3nEBgqF4QTmfHuE545pyUtvAylj1KOIyjYOHzDHngLdGXBmicQUSaX6GiakGKVPAf04MIrmR99NnRIA9AoMUc4wBtillhDE45hznZnB8YCxCWFDWEGWHDZhlHsuCcvWnx1eF4C3L7DGILAISg3f0KcK94YxE0RNi9hpjykkj81wqY4j3Ow4Lh7U6feLT6nML17JVEwx+zyepQMHPJLPbZHL2zsqeU9MR7HIYDlDEhZT4q+jLxqg999TovtP30u4WFn4CEM/9UUwmtTm3RVrzx9X8O0Ok+uzCS9o7s1kMD+L6cJVMzb+TYxNbCyN7T39b3fflQ3FRx7PUbpbJmftk58zXtn9rwfgxrDyz8F7t+a+2QOUBWHGztGZfAIfnqyQIApgliEcPfPdD8fGTL8u2ub6/iZIQe9H3YCHjcWn61NHCro/etze2R8bC5OG5vvALwL23z0rJJ6/I5LFvPJf68Hz1jU8eUgPyrygfe/E3EYNBLPjZq3VxuetQ5rEB7EIr5i4ZOFl4ExeSpUfXo8vTq3Xx5cjybqXcPxgs0/+53X/f4FcAAAD//5bsOMMAAAAGSURBVAMA9grhQClBJP4AAAAASUVORK5CYII=
[release-badge]:https://img.shields.io/github/v/release/robaimes/module-checkout-designs?sort=semver&style=for-the-badge&color=blue
[page-layouts]:https://devdocs.magento.com/guides/v2.4/frontend-dev-guide/layouts/xml-manage.html#create-cms-pageproductcategory-specific-selectable-layouts
[example-module]:https://github.com/robaimes/module-checkout-designs-example
[packagist]:https://packagist.org/packages/aimes/module-checkout-designs
[gpl]:https://www.gnu.org/licenses/gpl-3.0.en.html
[author]:https://aimes.dev/
[hyva]:https://hyva.io/

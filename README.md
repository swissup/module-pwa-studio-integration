# PWA-Studio Integration 

This module add custom fixes and integration for compatability with pwa-studio and our pwa themes
https://github.com/swissup/pwa-argento-home

###### For clients

There are several ways to install extension for clients:

 1. If you've bought the product at Magento's Marketplace - use
    [Marketplace installation instructions](https://docs.magento.com/marketplace/user_guide/buyers/install-extension.html)

 2. Otherwise, you have two options:
    - Install the sources directly from [our repository](https://docs.swissuplabs.com/m2/extensions/pwa-studio-integration/installation/composer/) - **recommended**
    - Download archive and use [manual installation](https://docs.swissuplabs.com/m2/extensions/pwa-studio-integration/installation/manual/)


###### For maintainers

```bash
cd <magento_root>
composer config repositories.swissup composer https://docs.swissuplabs.com/packages/
composer require swissup/module-pwa-studio-integration --prefer-source --ignore-platform-reqs
bin/magento module:enable Swissup_PwaStudioIntegration Swissup_Core
bin/magento setup:upgrade
bin/magento setup:di:compile
```

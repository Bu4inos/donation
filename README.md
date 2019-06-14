# donation

The Donation extension will add donation option to checkout, order and invoice. Donation amount sets from admin side.   

###Requirements

 * Installed Magento 2.3.* system ([Magento 2 requirements](https://devdocs.magento.com/guides/v2.3/install-gde/system-requirements-tech.html))

###Install

* Create the folder for the extension:
 
```mkdir-p {magento2_root}/app/code/Magecom/Checkout```

* Clone this extension from Git and move into the created folder (or just copy code to the folder). 

 ```php bin/magento module:enable Magecom_Checkout && php bin/magento setup:upgrade && php bin/magento setup:di:compile```

* Run the following commands:

```php bin/magento c:c```

* If Magento 2 works in the production mode, run this command:

```php bin/magentosetup:static-content:deploy```

###Configurations

Go to Stores → Settings → Configuration → Magecom donation → Configuration

#####Enable Donation module

* Enable or disable module

#####Title

* Set title shown in checkout

#####Rates for `Donation` module

* Set list of donation rates

###Deleting the Donation extension

* Run the commands:

```php bin/magentomodule:disable Magecom_Checkout && php bin/magentosetup:di:compile```

* If Magento 2 works in the production mode you need to run the command:

```php bin/magento setup:static-content:deploy```

* if you installed the module to app/code you need to remove the Magecom/Checkout folder with all files.

```rm-rf {magento2_root}/app/code/Magecom/Checkout```

* Run the commands:

```php bin/magento setup:upgrade && php bin/magento indexer:reindex && php bin/magento cache:flush```
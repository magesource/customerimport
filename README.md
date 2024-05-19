# Magesource_CustomerImport
Import Customer with command in csv or json files

## Installation

 - Install the module composer by running `composer require magesource/customerimport:dev-main`
 - Enable the module by running `php bin/magento module:enable Magesource_CustomerImport`
 - Run Magento commands by running

   `php bin/magento set:up;php bin/magento s:d:c;php bin/magento s:s:d -f;php bin/magento c:f`


## Features

Create customers from csv or json file from command line terminal.

## Configurations

`bin/magento customer:import <profile-name> <source>`

##### So to import from the CSV and the JSON respectively the user would execute either one of the following

##### `profile-name` is 'customer-csv' or 'customer-json'

##### `source` is your file path name added in `var/import` folder (eg. 'customer.csv' or 'customer.json')

*    `php bin/magento customer:import --help`
    
*    Description:
      Customer Import via CSV & JSON

*    Usage:
      customer:import <profile> <source>

*    Arguments:
      profile     Profile name ex: customer-csv or customer-json
      source      Source Path ex: customer.csv or customer.json
  
    
    bin/magento customer:import customer-csv customer.csv
    bin/magento customer:import customer-json customer.json
    
*    [csv](/files/customer.csv) and [json](/files/customer.json) files you can find inside `files` folder of this module.

Once we run our customer import command,also need to make sure to re-index the Customer Grid indexer

    `php bin/magento indexer:reindex customer_grid`

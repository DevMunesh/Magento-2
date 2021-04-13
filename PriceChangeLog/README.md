This module creates a log whenever the price of a product is changed from Magento Backend (Admin).

**Note:** Make sure to keep the module directory under "magento_root/app/code/DevMunesh/". -- here 'DevMunesh' is the vendor name.

The log mentions the following:
1. ID and SKU of the product (whose price has been changed).
2. Last price and New price
3. Admin username, who has changed the price
4. Date and Time of price change

An example snapshot of log has been given below:
![DevMunesh_PriceChangeLog_Snapshot](https://user-images.githubusercontent.com/81867465/114346789-a1a58d80-9b81-11eb-8b4b-8d5561dd9542.PNG)

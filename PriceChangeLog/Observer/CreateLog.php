<?php
namespace DevMunesh\PriceChangeLog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\Observer;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Stdlib\DateTime\DateTime;

use DevMunesh\PriceChangeLog\Logger\Logger;

class CreateLog implements ObserverInterface
{
    protected $_productRepository;
    protected $_logger;
    protected $_authSession;
    protected $_date;
    
    public function __construct(
        ProductRepository $productRepository,
        Logger $logger,
        Session $session,
        DateTime $date
    )
    {
        $this->_productRepository = $productRepository;
        $this->_logger = $logger;
        $this->_authSession = $session;
        $this->_date = $date;
    }

    public function execute(Observer $observer)
    {
        // get Product from observer
        $product = $observer->getProduct();

        // get Product from table
        $product_db = $this->_productRepository->getById($product->getEntityId());

        // price comparison
        // if not equal -> create a log
        if($product->getPrice() != $product_db->getPrice()){
            $outputLog = "Price changed for product::  ID: " . $product->getEntityId() . "  SKU: " . $product->getSku() . "\n\t Last Price: " . $product_db->getPrice() . "  New Price: " . $product->getPrice() . "\n\t User: " . $this->getCurrentUser() . "\n\t Updation Time: " . $this->getCurrentTime();
            
            // creates log
            $this->_logger->info($outputLog);
        }
    }

    // function to get current admin user 
    public function getCurrentUser() {
        return $this->_authSession->getUser()->getUserName();
    }

    // funtion to get current store time
    public function getCurrentTime() {
        return $this->_date->gmtDate();
    }
}

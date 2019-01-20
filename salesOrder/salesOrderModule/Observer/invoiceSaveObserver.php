<?php
namespace salesOrder\salesOrderModule\Observer;

use Magento\Framework\Event\ObserverInterface;

class invoiceSaveObserver implements ObserverInterface
{
  protected $_objectManager;
  public function __construct()
  {
    //Observer initialization code...
    //You can use dependency injection to get any class this observer may need.

    $this-> _objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager

  }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {

  	$invoice = $observer->getEvent()->getInvoice();
    $order = $invoice->getOrder();
    $orderID = $order-> getIncrementId();


    $handle = fopen("/home/ae7aa8a0/blazingglass.com/html/dev_webhive_order.txt", "a");
    $formatedDate = date("Y-m-d H:i:s");
    $formatedDate.= '---- Invoiced' . " " . $orderID . "\r\n";
    fwrite ($handle , $formatedDate);


    $this->_objectManager->create('\Magento\Sales\Model\Order\Email\Sender\InvoiceSender')
        ->send($invoice);

  }

}
?>
<?php
namespace salesOrder\salesOrderModule\Observer;

use Magento\Framework\Event\ObserverInterface;

class orderSaveObserver implements ObserverInterface
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

  	$shipment = $observer->getEvent()->getShipment();
    $order = $shipment->getOrder();
    $orderID = $order-> getIncrementId();
    //$shipment->sendEmail(true);
    //
    // $trackingNumbers = array();
    //     foreach ($shipment->getAllTracks() as $track) {
    //         $trackingNumbers[] = $track->getNumber();
    //     };
    
    // Blazing Live Site Path:  /home/ae7aa8a0/blazingglass.com/html/dev_webhive_order.txt
    
    $handle = fopen("/home/ae7aa8a0/blazingglass.com/html/dev_webhive_order.txt", "a");
    $formatedDate = date("Y-m-d H:i:s");
    $formatedDate.= '---- Shipment' . " " . $orderID . "\r\n";
    fwrite ($handle , $formatedDate);


    $this->_objectManager->create('Magento\Shipping\Model\ShipmentNotifier')
        ->notify($shipment);

  }

}
?>
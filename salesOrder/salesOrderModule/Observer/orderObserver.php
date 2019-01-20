<?php
namespace salesOrder\salesOrderModule\Observer;

use Magento\Framework\Event\ObserverInterface;

class orderObserver implements ObserverInterface
{
	protected $_connection;

  public function __construct()
  {
    //Observer initialization code...
    //You can use dependency injection to get any class this observer may need.

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $this->_connection = $resource->getConnection();

  }

  public function InsertOrderDescription($id){
        

        $query = "UPDATE sales_order_grid SET createdBy='website' WHERE entity_id=". $id;

        $this->_connection->query($query);
    }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {
  	$orderIds = $observer->getEvent()->getOrderIds();
  	$orderId = $orderIds[0];

  	// to get the data of entire order
  	// $order = $this->orderFactory->load($lastorderId);

    $this->InsertOrderDescription($orderId);
  }

}
?>
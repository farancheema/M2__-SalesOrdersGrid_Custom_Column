<?php
namespace salesOrder\salesOrderModule\Observer;

use Magento\Framework\Event\ObserverInterface;
class adminObserver implements ObserverInterface
{
	protected $_connection;
  protected $_authSession;

  public function __construct(\Magento\Backend\Model\Auth\Session $authSession)
  {
    //Observer initialization code...
    //You can use dependency injection to get any class this observer may need.

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $this->_connection = $resource->getConnection();

        $this->_authSession = $authSession;
  }


  public function execute(\Magento\Framework\Event\Observer $observer)
  {

    /*$order = $observer->getEvent()->getOrder();
    $incrementId = $order->getIncrementId();*/

    $user = $this->getCurrentUser();
    $userName = $user->getUsername();
    $userName.= " " . $user->getLastname();

  	$order = $observer->getEvent()->getOrder();
  	$orderId = $order-> getId();

  	// to get the data of entire order
  	// $order = $this->orderFactory->load($lastorderId);


       $this->InsertOrderDescription($orderId, $userName); 
  
  }

   public function InsertOrderDescription($id, $userName){
        

        $query = "UPDATE sales_order_grid SET createdBy='" . $userName . "' WHERE entity_id=". $id;

        $this->_connection->query($query);
    }


      public function getCurrentUser()
    {
        return $this->_authSession->getUser();
    }

}
?>
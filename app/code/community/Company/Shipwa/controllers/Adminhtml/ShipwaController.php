<?php
     class Company_Shipwa_Adminhtml_ShipwaController extends Mage_Adminhtml_Controller_action
   {

	
	public function indexAction() {		
	$this->loadLayout();
  $block = $this->getLayout()->createBlock('company_shipwa/adminhtml_shipwa');
  $this->getLayout()->getBlock('content')->append($block);
  $this->renderLayout();
}
/* protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('shipwa/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	 */
	
public function showdetailsAction(){
				
$data = $this->getRequest()->getPost();

			 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$table='shipway';
			$loginid=$data['loginid'];
			$licencekey=$data['licencekey'];
			 $url         = "http://shipway.in/api/authenticateUser";
    $data_string = array(
        "username" => $loginid,
        "password" => $licencekey
    );
    $data_string = json_encode($data_string);
    $curl        = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json'
    ));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);  
 curl_close($curl);
        
 $output = json_decode($output); // print_r($output); die; 
 if(isset($output->status) && strtolower($output->status) == 'success'){
$query = "UPDATE {$table} SET loginid= '{$loginid}' , licencekey= '{$licencekey}'  WHERE shipway_id = 1";
    			$write->query($query);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('shipwa')->__('Setting saved '));
 }
 else{
 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('shipwa')->__('Invalid Access'));
 
 }
 
 
			
		

 
			
				$this->_redirect('*/*/index');

}

public function couriermappingAction(){


$this->loadLayout();
$block=$this->getLayout()->createblock('company_shipwa/adminhtml_couriermapping');
$this->getLayout()->getBlock('content')->append($block);
$this->renderLayout();
}

public function savecouriermappAction(){
 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
$data = $this->getRequest()->getPost();

//print_r($data); die; 
//$read->fetchAll(" DELETE FROM shipwa_couriermapping where 1 "); 
$write->delete("shipway_couriermapping"); 

$i=1;
foreach($data['shipway'] as $key => $value){
$write->insert("shipway_couriermapping", array("id"=>$i,"default_courier"=>$key , "shipway_courierid"=>$value,"courier_type"=>"default"));
$i++;
}

foreach($data['shipway_customcourier_name'] as $key => $value){
if($value!=''){
$write->insert("shipway_couriermapping", array("id"=>$i,"default_courier"=>$value , "shipway_courierid"=>$data['shipway_courier_id'][$key],"courier_type"=>"custom"));
$i++;
}
}

Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('shipwa')->__('Courier has mapped '));
 
			
				$this->_redirect('*/*/couriermapping');
 
		 }
		

	}
?>
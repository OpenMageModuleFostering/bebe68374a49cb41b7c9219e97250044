<?php
     class Onj_Shipway_Adminhtml_ShipwayController extends Mage_Adminhtml_Controller_action
   {

	
	public function indexAction() {
	
	$this->loadLayout();
  $block = $this->getLayout()->createBlock('onj_shipway/adminhtml_shipway');
  $this->getLayout()->getBlock('content')->append($block);
  $this->renderLayout();
}
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
        
 $output = json_decode($output); 
 if(isset($output->status) && strtolower($output->status) == 'success'){
$query = "UPDATE {$table} SET loginid= '{$loginid}' , licencekey= '{$licencekey}'  WHERE shipway_id = 1";
    			$write->query($query);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('shipway')->__('Setting saved '));
 }
 else{
 Mage::getSingleton('adminhtml/session')->addError(Mage::helper('shipway')->__('Invalid Access'));
 
 }
 
 
			
		

 
			
				$this->_redirect('*/*/index');

}

public function couriermappingAction(){


$this->loadLayout();
$block=$this->getLayout()->createblock('onj_shipway/adminhtml_couriermapping');
$this->getLayout()->getBlock('content')->append($block);
$this->renderLayout();
}

public function savecouriermappAction(){
 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
$data = $this->getRequest()->getPost();
echo '<pre>';
//print_r($data); die;
//$read->fetchAll(" DELETE FROM shipway_couriermapping where 1 "); 
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

Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('shipway')->__('Courier has mapped '));
 
			
				$this->_redirect('*/*/couriermapping');
 
		 }
		

	}
?>
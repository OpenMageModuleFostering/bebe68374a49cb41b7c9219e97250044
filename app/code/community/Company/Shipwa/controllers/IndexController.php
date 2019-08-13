<?php
class Company_Shipwa_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    { 
	
	$this->loadLayout();
  $block = $this->getLayout()->createBlock('company_shipwa/shipwa','shipwa');
  $this->getLayout()->getBlock('content')->append($block);
  $this->renderLayout();
    }
	
	
	public function showdetailsAction(){
	
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');

		$logindetail= $read->fetchAll("select * from shipway  where shipway_id=1");
		if(count($logindetail)){
				$username  = $logindetail[0]['loginid'];
				$password  = $logindetail[0]['licencekey'];
				$data['hasAccount'] = true;
		}
		else{
				$username  = '';
				$password  = '';
				$data['hasAccount'] = false;
				echo "<p style='color:#BA1A1A;font-size:14px;'>Something went wrong.Please inform the website administrator.</p>";die;
			 
		}

	
		
        if ($this->getRequest()->getPost()) {
	$data=	$this->getRequest()->getPost();
            $status_result = '';
			

            if (isset($data['order_id'])) { 
              		$increment__id=$data['order_id'];
	//$order = Mage::getModel('sales/order')->load($order__id); 
	 $order = Mage::getModel('sales/order')->loadByIncrementId($increment__id); 
	// $order__id=$order->getId();
	 $order__id=$increment__id;
	 foreach ($order->getTracksCollection() as $_track){
   $track_no=$_track->getNumber();
   $track_code=$_track->getCarrier_code();
   $track_title=$_track->getTitle();
   }
  			if($track_code!='custom'){
$courierDetail= $read->fetchAll("select * from shipway_couriermapping  where default_courier='".$track_code."'");
}else{
$courierDetail= $read->fetchAll("select * from shipway_couriermapping  where default_courier='".$track_title."'");
}
   if(count($courierDetail)){
$shipway_carrier_id= $courierDetail[0]['shipway_courierid'];
}else{
$shipway_carrier_id= '';
}
            } 
            if (!empty($track_no)) {
                $awbno                      = $track_no;
                $data['awbno']        = $awbno;
                $data['carrier_name'] = $track_title;                
                
                $courier_id = $shipway_carrier_id;
                $order_id = $order__id;
				
                $status_result = $this->getAWBResults($username, $password, $courier_id, $awbno,$order_id);
				
				$isJson = json_decode($status_result);
				if(!empty($isJson) && strtolower($isJson->status) == 'failed'){
					$status_result = "<p style='color:#BA1A1A;font-size:14px;'>Something went wrong.Please inform the website administrator.</p>";
				}
            } else {                
                $status_result = 'No tracking number associated with this order';
            }
                    
            if ($status_result != '') {
                $data['status_result'] = $status_result;
            }

            }   
	print_r($status_result);
	}
	
	
	
    
    public function getAWBResults($username, $password, $carrier_id, $awbno, $order_id)
    {
        $url         = "http://shipway.in/api/getawbresult";
        $data_string = array(
            "username" 		=> $username,
            "password" 		=> $password,
            "carrier_id" 	=> $carrier_id,
            "awb" 			=> $awbno,
			"order_id"		=> $order_id
        );
		//print_r($data_string);
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
        return $output;   
	
    }
}
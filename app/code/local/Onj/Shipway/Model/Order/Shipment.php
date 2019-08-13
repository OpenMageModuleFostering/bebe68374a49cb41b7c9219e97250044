<?php 

class Onj_shipway_Model_Order_Shipment extends Mage_Sales_Model_Order_Shipment
{
	  protected function _afterSave()
    {
        if (null !== $this->_items) {
            foreach ($this->_items as $item) {
                $item->save();
            }
        }

        if (null !== $this->_tracks) {
            foreach($this->_tracks as $track) {
                $track->save();
            }
        }

        if (null !== $this->_comments) {
            foreach($this->_comments as $comment) {
                $comment->save();
            }
        }
		$order__id=$this->getOrderId();
	 $order = Mage::getModel('sales/order')->load($order__id); 
	 foreach ($order->getTracksCollection() as $_track){
   $track_no=$_track->getNumber();
   $track_code=$_track->getCarrier_code();
   $track_title=$_track->getTitle();
}
$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
				if($track_code!='custom'){
$courierDetail= $read->fetchAll("select * from shipway_couriermapping  where default_courier='".$track_code."'");
}else{
$courierDetail= $read->fetchAll("select * from shipway_couriermapping  where default_courier='".$track_title."'");
}
$logindetail= $read->fetchAll("select * from shipway  where shipway_id=1");
if(count($logindetail)){

$shipway_loginid= $logindetail[0]['loginid'];
$shipway_licencekey= $logindetail[0]['licencekey'];
}
else{
$shipway_loginid= '';
$shipway_licencekey= '';
}
if(count($courierDetail)){
$shipway_carrier_id= $courierDetail[0]['shipway_courierid'];
}else{
$shipway_carrier_id= '';
}
$data = array(
            'carrier_id' => $shipway_carrier_id,
            'order_id' => $order__id,
            'awb' => $track_no,
            'username' => $shipway_loginid,
            'password' => $shipway_licencekey
        );
		$this->assignAwb($data);
        return parent::_afterSave();
    }
	
	public function assignAwb($data)
    {
	
        $order = Mage::getModel("sales/order")->load($data['order_id']); 
		$payment_code= $order->getPayment()->getMethodInstance()->getCode();
		$pos = strpos($payment_code, 'cash');
	$payment_type = 'P';
			if( strpos($payment_code, 'cash')){
				$payment_type = 'C';
			}
			$orderdetails['payment_type'] = $payment_type;
			$orderdetails['payment_method'] = $payment_code;
			$orderdetails['return_address'] = 'abc';
			
			$orderTotalValue = number_format ($order->getGrandTotal(), 2, '.' , $thousands_sep = '');
$orderdetails['collectable_amount'] = $orderTotalValue;
			$orderdetails['collectable_amount'] = ($payment_type == 'C') ? $orderTotalValue : 0;
$ordered_items = $order->getAllItems(); 
$itms='';
$products=array();
$orderdetails=array();
foreach($ordered_items as $item){   
			$products[]=array(
					'product_id'=> $item->getProductId(),
					'name'=> $item->getName(),
					'price'=> $item->getPrice(),
					'quantity'=> $item->getQtyOrdered(),
					'url'=> 'abc'
					);
					
	$itms .= $item->getName().' ';
  }

$itms=substr($itms,0,35);
  $shipping_address = $order->getShippingAddress();
$orderdetails=array(
				'order_id' => $data['order_id'],
            'order_date' => $order->getCreatedAt(),
            'firstname' => $shipping_address->getFirstname(),
            'lastname' =>$shipping_address->getLastname(),
            'email' => $shipping_address->getEmail(),
            'phone' => $shipping_address->getTelephone(),
            'address' => $shipping_address->getCity(),
            'city' => $shipping_address->getCity(),
            'state' => $shipping_address->getRegion(),
            'zipcode' => $shipping_address->getPostcode(),
          
            'country' => 'India',
			'products' =>  $products,  
			'amount' => $orderTotalValue,
			'payment_type' => $payment_type,
			'payment_method' => $payment_code,
			'collectable_amount' => $orderTotalValue,
			'return_address' => 'abc',
			

);
   $data['first_name']     = $shipping_address->getFirstname();
   $data['last_name']      = $shipping_address->getLastname();
  $data['email']          = $shipping_address->getEmail();
   $data['phone']          = $shipping_address->getTelephone();
   $data['products']       = $itms;
   $data['company']     = 'Mairabazaar.com';
   $data['order']   = $orderdetails;

    $url = "http://shipway.in/api/pushOrderData";
   
   $data_string = json_encode($data);
   $curl = curl_init();
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
   $output = json_decode($output);
   curl_close($curl); 
$result=(array)$output;

if($result['status']=='Failed '){
echo $result['message'];
}
else{
echo $result['message'];
}

    }
	
}
?>
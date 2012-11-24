<?php
class SNH_ApplyCoupon_Model_Observer
{
    public function applyCouponEvent($observer){
	$coupon_code = trim(Mage::getSingleton("checkout/session")->getData("coupon_code"));
    if ($coupon_code != ''){
        Mage::getSingleton('checkout/cart')->getQuote()->setCouponCode($coupon_code)->save();
    }
}

}

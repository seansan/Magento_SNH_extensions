<?php
/**
 * controller extension
 *
 * This is the URL example to call: http://www.liveoutthere.com/applycoupon/index/?url=buy/the_north_face.html&coupon_code=TNF10
 * Insspiration (and actually 98% of the codde is from http://www.drewgillson.com/blog/how-to-apply-magento-coupon-codes-automatically/
 * @author      contact@baleinen.com
 */

class SNH_ApplyCoupon_IndexController extends Mage_Core_Controller_Front_Action {

	public function goodbyeAction() {
		echo 'Goodbye World!';
	}

	public function indexAction() {


		$coupon_code = $this->getRequest()->getParam('coupon_code');

	    if ($coupon_code != '') {
		Mage::getSingleton("checkout/session")->setData("coupon_code",$coupon_code);
		Mage::getSingleton('checkout/cart')->getQuote()->setCouponCode($coupon_code)->save();
		Mage::getSingleton('core/session')->addSuccess($this->__('Coupon was automatically applied'));
// $oCoupon = Mage::getModel('salesrule/coupon')->load($coupon_code, 'code');
// $oRule = Mage::getModel('salesrule/rule')->load($oCoupon->getRuleId());
// var_dump($oRule->getData()); exit;

	    }
	    else {
		Mage::getSingleton("checkout/session")->setData("coupon_code","");
		$cart = Mage::getSingleton('checkout/cart');
		foreach( Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item ) {
		    $cart->removeItem( $item->getId() );
		}
		$cart->save();
	    }

	    if ($this->getRequest()->getParam('url')) {
		$this->_redirectUrl($this->getRequest()->getParam('url'));
		/* // using raw header instead of _redirect because _redirect appends a / */
		// header('HTTP/1.1 301 Moved Permanently');
		// $gclid = $this->getRequest()->getParam('gclid');
		// $url = $this->getRequest()->getParam('url');
		// header('Location: /' . $url . '?gclid=' . $gclid);
		// die();
	    } else {
		$this->_redirect();
	    }
	}


}

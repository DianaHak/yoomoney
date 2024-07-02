<?php
 /**
  * Webkul Software.
  *
  * @category Webkul
  * @package Opencart Module Tutorial
  * @author Webkul
  * @license https://store.webkul.com/license.html
  */
 class ModelExtensionPaymentYoomoneyPayment extends Model {
    public function getMethod($address, $total) {
        $this->load->language('extension/payment/yoomoney_payment');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payment_yoomoney_payment_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('payment_yoomoney_payment_total') > 0 && $this->config->get('payment_yoomoney_payment_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('payment_yoomoney_payment_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'       => 'yoomoney_payment',
                'title'      => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => $this->config->get('payment_yoomoney_payment_sort_order')
            );
        }

        return $method_data;
    }
}
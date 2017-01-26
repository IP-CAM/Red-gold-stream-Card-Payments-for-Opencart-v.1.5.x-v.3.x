<?php

class ModelPaymentEsafe24PayShip extends Model {

    public function getMethod($address, $total) {
        $this->load->language('payment/esafe_24payship');
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('esafe_24payship_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        if ($this->config->get('esafe_24payship_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('esafe_24payship_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }
        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'esafe_24payship',
                'title' => $this->language->get('text_title'),
                'sort_order' => $this->config->get('esafe_24payship_sort_order')
            );
        }
        return $method_data;
    }

}

?>
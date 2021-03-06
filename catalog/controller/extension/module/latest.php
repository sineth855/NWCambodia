<?php
class ControllerExtensionModuleLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/latest');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();
		
		$filter_data = array(
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit'],
			'is_flash_sale' => 1,
			// 'date_now' => date("Y-m-d")
			'date_now' => '20200718'
		);


		$results = $this->model_catalog_product->getFlashsaleProducts($filter_data);

		if ($results) {
			foreach ($results as $result) {

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					// $image = $result['image'];
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				// if ($result['image']) {
				// 	// $image = $this->model_tool_image->resize($result['image'], 480, 480);
				// 	$image = $result['image'];
				// } else {
				// 	$image = $this->model_tool_image->resize('placeholder.png', 480, 480);
				// }

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}				
				$data['products'][] = array(
					'product_id'  		=> $result['product_id'],
					'thumb'       		=> $image,
					'name'        		=> $result['name'],
					'description' 		=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       		=> $price,
					'special'     		=> $special,
					'special_discount' 	=> $result['special_discount'] ? $result['special_discount']:false,
					'date_start'     	=> $result['date_start'],
					'date_expired'		=> $result['date_expired'],
					'is_flash_sale' 	=> $result['is_flash_sale'] ,
					'date_end'     		=> date_format(date_create($result['date_end']), "M d, Y H:i:s"),
					'tax'         		=> $tax,
					'rating'      		=> $rating,
					'href'        		=> $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
				//print_r($data['products']);/
			}
			return $this->load->view('extension/module/latest', $data);
		}
	}
}

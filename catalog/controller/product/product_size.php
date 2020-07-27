<?php
class ControllerProductProductSize extends Controller {
	private $error = array();

	public function index(){
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$productSizeId = $this->request->post['product_size_id'];
		$productId = $this->request->post['product_id'];

		// Addon Products
		$json['productSizes'] = array();

		$productSizes = $this->model_catalog_product->getProductBySize($productSizeId, $productId);

		foreach ($productSizes as $result) {
			if (isset($result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
			}

			$data['addonProducts'] = array();
			$addOnResultMores = $this->model_catalog_product->getProductAddon($result['id']);
			
			foreach ($addOnResultMores as $addon) {

				$addon_product_info = $this->model_catalog_product->getProduct($addon["addon_product_id"]);
				if ($addon_product_info['image'] !=null) {
					$imageAddon = $this->model_tool_image->resize($addon_product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				} else {
					$imageAddon = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				}
				
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$priceAddon = $this->currency->format($this->tax->calculate($addon_product_info['price'], $addon_product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$priceAddon = false;
				}

				if ((float)$addon_product_info['special']) {
					$specialAddon = $this->currency->format($this->tax->calculate($addon_product_info['special'], $addon_product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$specialAddon = false;
				}
				if ((int)$addon_product_info['quantity'] <= 0) {
					$stock = "./catalog/view/theme/default/image/out_stock.png";
				} elseif ((int)$addon_product_info['quantity'] <= 5) {
					$stock = "./catalog/view/theme/default/image/low_stock.png";
				} else {
					$stock = "./catalog/view/theme/default/image/in_stock.png";
				}
				$data['addonProducts'][] = array(
					'product_id'  => $addon_product_info['product_id'],
					'thumb'       => $imageAddon,
					'name'        => $addon_product_info['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($addon_product_info['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'date_expired' => $addon_product_info['date_expired'] ? date($this->language->get('date_format_short'), strtotime($addon_product_info['date_expired'])) : '',
					'price'       => $priceAddon,
					'stock'       => $stock,
					'special'     => $specialAddon,
					'minimum'     => $addon_product_info['minimum'] > 0 ? $addon_product_info['minimum'] : 1,
					'href'        => $this->url->link('product/product', 'product_id=' . $addon_product_info['product_id'])
					
				);
			}
			$json['productSizes'][] = array(
				'thumb'        	  => $image,
				'image'		  	  => $result["image"],
				'name'         	  => $result['size_name'],
				'is_group_order'  => $result['is_group_order'],
				'price'        	  => $this->currency->format($this->tax->calculate($result['price'], 0, $this->config->get('config_tax')), $this->session->data['currency']),
				//'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
				// 'price'       => $price,
				// 'special'     => $special,
				// 'tax'         => $tax,
				// 'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
				// 'rating'      => $rating,
				// 'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				'addonProducts'  =>  $data['addonProducts']
			);
		}

		// $json = array(
		// 	'data' => 'test',
		// 	'product_size_id' => $productSizeId
		// );
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
    
}
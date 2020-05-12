<?php
	class ControllerCommonMenu extends Controller {
		public function index() {
			$this->load->language('common/menu');
			$data['logged'] = $this->customer->isLogged();
			if($data['logged']) {
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['logout'] = $this->url->link('account/logout', '', false);
			}
			// Menu
			
			$this->load->model('catalog/category');

			$this->load->model('catalog/product');

			$data["register"] = $this->url->link('account/register', '', false);
			$data["login"] = $this->url->link('account/login', '', false);

			$data['contact'] = $this->url->link('information/contact');

			$data['categories'] = array();

			$categories = $this->model_catalog_category->getCategories(0);

			foreach ($categories as $category) {
				if ($category['top']) {
					// Level 2
					$children_data = array();

					$children = $this->model_catalog_category->getCategories($category['category_id']);

					foreach ($children as $child) {
						$filter_data = array(
							'filter_category_id'  => $child['category_id'],
							'filter_sub_category' => true
						);

						$children_data[] = array(
							// 'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'name'  => $child['name'],
							'url'  => $child['url'],
							'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
						);
					}

					// Level 1
					$data['categories'][] = array(
						'name'     => $category['name'],
						'children' => $children_data,
						'url'   => $category['url'],
						'column'   => $category['column'] ? $category['column'] : 1,
						'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
					);
				}
			}

			return $this->load->view('common/menu', $data);
		}
	}
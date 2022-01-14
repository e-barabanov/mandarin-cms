<?php
class ControllerExtensionPaymentMandarinbank extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/mandarinbank');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('payment_mandarinbank', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));

		}

		$data['payment_mandarinbank_version'] = '1.0 for OpenCart 3.0';
		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['entry_mandarinbank_group_name'] = $this->language->get('entry_mandarinbank_group_name');
		$data['entry_mandarinbank_group_markup'] = $this->language->get('entry_mandarinbank_group_markup');
		$data['entry_mandarinbank_group_desc'] = $this->language->get('entry_mandarinbank_group_desc');
		$data['entry_mandarinbank_groups_settings'] = $this->language->get('entry_mandarinbank_groups_settings');
		$data['help_mandarinbank_groups_settings'] = $this->language->get('help_mandarinbank_groups_settings');

		$data['entry_mandarinbank_show_pay_now'] = $this->language->get('entry_mandarinbank_show_pay_now');
		$data['help_mandarinbank_show_pay_now'] = $this->language->get('help_mandarinbank_show_pay_now');

		$data['entry_mandarinbank_name'] = $this->language->get('entry_mandarinbank_name');
		$data['help_mandarinbank_name'] = $this->language->get('help_mandarinbank_name');

		$data['entry_mandarinbank_total'] = $this->language->get('entry_mandarinbank_total');
		$data['help_mandarinbank_total'] = $this->language->get('help_mandarinbank_total');

		$data['customer_groups'] = array();

		if (file_exists(DIR_APPLICATION . '/model/sale/customer_group.php'))
		{
			$this->load->model('sale/customer_group');
			$customer_group_total = $this->model_sale_customer_group->getTotalCustomerGroups();
			$results = $this->model_sale_customer_group->getCustomerGroups();

		}
		else
		{
			$this->load->model('customer/customer_group');
			$customer_group_total = $this->model_customer_customer_group->getTotalCustomerGroups();
			$results = $this->model_customer_customer_group->getCustomerGroups();

		}



		foreach ($results as $result) {

			$data['customer_groups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_group_id')) ? $this->language->get('text_default') : null)
			);
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['entry_mandarinbank_shop_id'] = $this->language->get('entry_mandarinbank_shop_id');
		$data['help_mandarinbank_shop_id'] = $this->language->get('help_mandarinbank_shop_id');

		$data['entry_mandarinbank_id'] = $this->language->get('entry_mandarinbank_id');
		$data['help_mandarinbank_id'] = $this->language->get('help_mandarinbank_id');

		$data['entry_mandarinbank_id'] = $this->language->get('entry_mandarinbank_id');
		$data['help_mandarinbank_id'] = $this->language->get('help_mandarinbank_id');

		$data['entry_mandarinbank_id'] = $this->language->get('entry_mandarinbank_id');
		$data['help_mandarinbank_id'] = $this->language->get('help_mandarinbank_id');

		$data['entry_mandarinbank_ccy_select'] = $this->language->get('entry_mandarinbank_ccy_select');
		$data['help_mandarinbank_ccy_select'] = $this->language->get('help_mandarinbank_ccy_select');

		$data['entry_mandarinbank_status'] = $this->language->get('entry_status');
		$data['entry_mandarinbank_sort_order'] = $this->language->get('entry_sort_order');
		$data['help_mandarinbank_sort_order'] = $this->language->get('help_mandarinbank_sort_order');

		$data['entry_mandarinbank_order_status_progress_id'] 		= $this->language->get('The status of the order to pay');
		$data['help_mandarinbank_order_status_progress_id'] 		= $this->language->get('The status of the order to pay.');

        $data['entry_mandarinbank_geo_zone_id'] = $this->language->get('entry_mandarinbank_geo_zone_id');
        $data['help_mandarinbank_geo_zone_id'] = $this->language->get('help_mandarinbank_geo_zone_id');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['shop_id'])) {
			$data['error_mandarinbank_shop_id'] = $this->error['shop_id'];
		} else {
			$data['error_mandarinbank_shop_id'] = '';
		}

		if (isset($this->error['rest_id'])) {
			$data['error_mandarinbank_id'] = $this->error['rest_id'];
		} else {
			$data['error_mandarinbank_id'] = '';
		}



		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_mandarinbank'),
			'href'      => $this->url->link('extension/payment/mandarinbank', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/payment/mandarinbank', 'user_token=' . $this->session->data['user_token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$data['action'] = $this->url->link('extension/payment/mandarinbank', 'user_token=' . $this->session->data['user_token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment/mandarinbank', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		// Номер магазина
		if (isset($this->request->post['payment_mandarinbank_shop_id'])) {
			$data['payment_mandarinbank_shop_id'] = $this->request->post['payment_mandarinbank_shop_id'];
		} else {
			$data['payment_mandarinbank_shop_id'] = $this->config->get('payment_mandarinbank_shop_id');
		}

		if (isset($this->request->post['payment_mandarinbank_id'])) {
			$data['payment_mandarinbank_id'] = $this->request->post['payment_mandarinbank_id'];
		} else {
			$data['payment_mandarinbank_id'] = $this->config->get('payment_mandarinbank_id');
		}


		// URL
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['payment_mandarinbank_result_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/mandarinbank/callback';
		} else {
			$data['payment_mandarinbank_result_url'] = HTTP_CATALOG . 'index.php?route=extension/payment/mandarinbank/callback';
		}


		if (isset($this->request->post['payment_mandarinbank_order_status_cancel_id'])) {
			$data['payment_mandarinbank_order_status_cancel_id'] = $this->request->post['payment_mandarinbank_order_status_cancel_id'];
		} else {
			$data['payment_mandarinbank_order_status_cancel_id'] = $this->config->get('payment_mandarinbank_order_status_cancel_id');
		}

        if (isset($this->request->post['payment_mandarinbank_order_status_id'])) {
            $data['payment_mandarinbank_order_status_id'] = $this->request->post['payment_mandarinbank_order_status_id'];
        } else {
            $data['payment_mandarinbank_order_status_id'] = $this->config->get('payment_mandarinbank_order_status_id');
        }

		if (isset($this->request->post['payment_mandarinbank_lifetime'])) {
			$data['payment_mandarinbank_lifetime'] = (int)$this->request->post['payment_mandarinbank_lifetime'];
		} elseif( $this->config->get('payment_mandarinbank_lifetime') ) {
			$data['payment_mandarinbank_lifetime'] = (int)$this->config->get('payment_mandarinbank_lifetime');
		} else {
			$data['payment_mandarinbank_lifetime'] = 24;
		}


		if (isset($this->request->post['payment_mandarinbank_markup'])) {
			$data['payment_mandarinbank_markup'] = $this->request->post['payment_mandarinbank_markup'];
		} elseif( $this->config->get('payment_mandarinbank_markup') ) {
			$data['payment_mandarinbank_markup'] = $this->config->get('payment_mandarinbank_markup');
		} else {
			$data['payment_mandarinbank_markup'] = 0.0;
		}

		if (isset($this->request->post['payment_mandarinbank_group_markup'])) {
			$data['payment_mandarinbank_group_markup'] = $this->request->post['payment_mandarinbank_group_markup'];
		} elseif( $this->config->get('payment_mandarinbank_group_markup') ) {
			$data['payment_mandarinbank_group_markup'] = $this->config->get('payment_mandarinbank_group_markup');
		} else {
			$data['payment_mandarinbank_group_markup'] = 0.0;
		}

		if (isset($this->request->post['payment_mandarinbank_group_desc'])) {
			$data['payment_mandarinbank_group_desc'] = $this->request->post['payment_mandarinbank_group_desc'];
		} elseif( $this->config->get('payment_mandarinbank_group_desc') ) {
			$data['payment_mandarinbank_group_desc'] = $this->config->get('payment_mandarinbank_group_desc');
		} else {
			$data['payment_mandarinbank_group_desc'] = 0.0;
		}


		if (isset($this->request->post['payment_mandarinbank_ccy_select'])) {
			$data['payment_mandarinbank_ccy_select'] = $this->request->post['payment_mandarinbank_ccy_select'];
		} elseif( $this->config->get('payment_mandarinbank_ccy_select') ) {
			$data['payment_mandarinbank_ccy_select'] = $this->config->get('payment_mandarinbank_ccy_select');
		} else {
			$data['payment_mandarinbank_ccy_select'] = 'RUB';
		}

		if (isset($this->request->post['payment_mandarinbank_show_pay_now'])) {
			$data['payment_mandarinbank_show_pay_now'] = $this->request->post['payment_mandarinbank_show_pay_now'];
		} elseif( $this->config->get('payment_mandarinbank_show_pay_now') ) {
			$data['payment_mandarinbank_show_pay_now'] = $this->config->get('payment_mandarinbank_show_pay_now');
		} else {
			//$data['payment_mandarinbank_show_pay_now'] = '1';
		}

		if (isset($this->request->post['payment_mandarinbank_name'])) {
			$data['payment_mandarinbank_name'] = $this->request->post['payment_mandarinbank_name'];
		} elseif( $this->config->get('payment_mandarinbank_name') ) {
			$data['payment_mandarinbank_name'] = $this->config->get('payment_mandarinbank_name');
		} else {
			$data['payment_mandarinbank_name'] = $this->language->get('payment_mandarinbank_name');
		}


		if (isset($this->request->post['payment_mandarinbank_total'])) {
			$data['payment_mandarinbank_total'] = $this->request->post['payment_mandarinbank_total'];
		} elseif( $this->config->get('payment_mandarinbank_total') ) {
			$data['payment_mandarinbank_total'] = $this->config->get('payment_mandarinbank_total');
		} else {
			$data['payment_mandarinbank_total'] = 0.0;
		}


		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payment_mandarinbank_geo_zone_id'])) {
			$data['payment_mandarinbank_geo_zone_id'] = $this->request->post['payment_mandarinbank_geo_zone_id'];
		} else {
			$data['payment_mandarinbank_geo_zone_id'] = $this->config->get('payment_mandarinbank_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['payment_mandarinbank_status'])) {
            $data['payment_mandarinbank_status'] = $this->request->post['payment_mandarinbank_status'];
        } else {
            $data['payment_mandarinbank_status'] = $this->config->get('payment_mandarinbank_status');
        }

		if (isset($this->request->post['payment_mandarinbank_sort_order'])) {
			$data['payment_mandarinbank_sort_order'] = $this->request->post['payment_mandarinbank_sort_order'];
		} else {
			$data['payment_mandarinbank_sort_order'] = $this->config->get('payment_mandarinbank_sort_order');
		}

		if (isset($this->request->post['payment_mandarinbank_mode_select'])) {
			$data['payment_mandarinbank_mode_select'] = $this->request->post['payment_mandarinbank_mode_select'];
		} else {
			$data['payment_mandarinbank_mode_select'] = $this->config->get('payment_mandarinbank_mode_select');
		}

		if (isset($this->request->post['payment_mandarinbank_mode_show_picture'])) {
			$data['payment_mandarinbank_mode_show_picture'] = $this->request->post['payment_mandarinbank_mode_show_picture'];
		} else {
			$data['payment_mandarinbank_mode_show_picture'] = $this->config->get('payment_mandarinbank_mode_show_picture');
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('/extension/payment/mandarinbank', $data));

	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/mandarinbank')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_mandarinbank_shop_id']) {
			$this->error['shop_id'] = $this->language->get('error_shop_id');
		}

		if (!$this->request->post['payment_mandarinbank_id']) {
			$this->error['rest_id'] = $this->language->get('error_rest_id');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

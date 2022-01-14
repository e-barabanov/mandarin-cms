<?php

class ControllerExtensionPaymentMandarinbank extends Controller
{
    public function index()
    {
        $data['button_confirm'] = $this->language->get('button_confirm');
        $this->load->language('extension/payment/mandarinbank');
        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $data['form'] = $this->generate_form($this->config->get('payment_mandarinbank_id'), $values = array(
            "email" => $order_info['email'],
            "merchantId" => $this->config->get('payment_mandarinbank_shop_id'),
            "returnUrl" => $this->url->link('checkout/success', '', true),
            "callbackUrl" => $this->url->link('extension/payment/mandarinbank/callback', '', true),
            "orderId" => $this->session->data['order_id'],
            "price" => round($order_info['total'], 2),
        ));

        return $this->load->view('extension/payment/mandarinbank', $data);
    }

    public function check_sign($secret,$fields)
    {
        $signAnswer = $fields['sign'];
        $sign = $this->calc_sign($secret,$fields);
        return $sign == $signAnswer;
    }

    public function calc_sign($secret, $fields)
    {
        if (isset($fields['sign'])) {
            unset($fields['sign']);
        }
        ksort($fields);
        $secret_t = '';
        foreach ($fields as $key => $val) {
            $secret_t = $secret_t . '-' . $val;
        }
        $secret_t = substr($secret_t, 1) . '-' . $secret;
        return hash("sha256", $secret_t);
    }

    public function generate_form($secret, $fields)
    {
        $sign = $this->calc_sign($secret, $fields);
        $form = "";
        foreach ($fields as $key => $val) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($val) . '"/>' . "\n";
        }
        $form .= '<input type="hidden" name="sign" value="' . $sign . '"/>';
        return $form;
    }

    public function callback()
    {
        $error_status = 10;
        $this->load->language('extension/payment/mandarinbank');
        $amount = $_POST['price'];

        $order_id = trim($_POST['orderId']);

        $marchantId = $_POST['merchantId'];

        $manderinBankTransactionId = $_POST['transaction'];

        $customerEmail = $_POST['customer_email'];
        $customerPhone = $_POST['customer_phone'];
        $action = $_POST['action'];

        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);
        if (empty($order))
            die('Оплачиваемый заказ не найден');

        $status = 'failed';
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        }


        if ($status == 'failed') {
            $this->model_checkout_order->addOrderHistory($order_id, $error_status, $this->language->get('errors_payment'));
            die("Оплата прошла с ошибкой (status faild)");
        }

        if (round($order['total'], 2) != round($amount, 2) || $amount <= 0) {
            $this->model_checkout_order->addOrderHistory($order_id, $error_status, $this->language->get('errors_payment'));
            die("Неверная сумма оплаты");
        }

        if ($this->config->get('payment_mandarinbank_shop_id') != $marchantId) {
            $this->model_checkout_order->addOrderHistory($order_id, $error_status, $this->language->get('errors_payment'));
            die('Мерчант указан не верно');
        }

        if (!$this->check_sign($this->config->get('payment_mandarinbank_id'),$_POST)) {
            $this->model_checkout_order->addOrderHistory($order_id, $error_status, $this->language->get('errors_payment'));
            die('Sign указан не верно');
        }

        $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payment_mandarinbank_order_status_id'), $this->language->get('success_payment'));

    }

}
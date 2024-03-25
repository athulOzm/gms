<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cweb_setting extends CI_Controller {

    public $menu;
    public $user_id;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lweb_setting');
        $this->load->library('session');
        $this->load->model('Web_settings');
        $this->auth->check_admin_auth();
        $this->template->current_menu = 'web_setting';
        $this->user_id = $this->session->userdata('user_id');
    }

    public function index() {
        $content = $this->lweb_setting->setting_add_form();
        $this->template->full_admin_html_view($content);
    }

    // Update setting
    public function update_setting() {
        $this->load->model('Web_settings');

        if ($_FILES['logo']['name']) {
            //Chapter chapter add start

            $config['upload_path'] = './my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
                $data = $this->upload->data();
                $logo = $config['upload_path'] . $data['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $logo;
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 200;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $logo = base_url() . $logo;
            }
        }

        if ($_FILES['favicon']['name']) {
            //Chapter chapter add start
            $config['upload_path'] = './my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('favicon')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $favicon = base_url() . "my-assets/image/logo/" . $image['file_name'];
            }
        }

        if ($_FILES['invoice_logo']['name']) {
            //Chapter chapter add start

            $config['upload_path'] = './my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('invoice_logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
                $data = $this->upload->data();
                $invoice_logo = $config['upload_path'] . $data['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $invoice_logo;
                $config['create_thumb'] = false;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 200;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $invoice_logo = base_url() . $invoice_logo;
            }
        }

        $old_logo = $this->input->post('old_logo');
        $old_invoice_logo = $this->input->post('old_invoice_logo');
        $old_favicon = $this->input->post('old_favicon');

        $data = array(
            'logo' => (!empty($logo) ? $logo : $old_logo),
            'invoice_logo' => (!empty($invoice_logo) ? $invoice_logo : $old_invoice_logo),
            'favicon' => (!empty($favicon) ? $favicon : $old_favicon),
            'currency' => $this->input->post('currency'),
            'currency_position' => $this->input->post('currency_position'),
            'labour_cost' => $this->input->post('labour_cost'),
            'date_format' => $this->input->post('date_format'),
            'footer_text' => $this->input->post('footer_text'),
            'language' => $this->input->post('language'),
            'rtr' => $this->input->post('rtr'),
            'timezone' => $this->input->post('timezone'),
            'captcha' => $this->input->post('captcha'),
            'site_key' => $this->input->post('site_key'),
            'secret_key' => $this->input->post('secret_key'),
            'discount_type' => $this->input->post('discount_type'),
        );

        $this->Web_settings->update_setting($data);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cweb_setting'));
        exit;
    }

//    =========== its for paypal settings ===============
    public function paypal_setting() {
        $data['title'] = display('create_checklist');
        $data['paypal_setting'] = $this->db->select('*')->from('gateway_tbl')->where('id', 1)->get()->result();
//        
        $content = $this->parser->parse('web_setting/paypal_setting', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for paypal_setting_update ============
    public function paypal_setting_update() {
        $payment_gateway = $this->input->post('payment_gateway');
        $email = $this->input->post('email');
        $currency = $this->input->post('currency');
        $mode = $this->input->post('mode');


        $paypal_data = array(
            'payment_gateway' => $payment_gateway,
            'payment_mail' => $email,
            'currency' => $currency,
            'status' => $mode,
            'updated_by' => $this->user_id,
            'updated_date' => date('Y-m-d'),
        );
//        dd($paypal_data);
        $this->db->where('id', 1)->update('gateway_tbl', $paypal_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cweb_setting/paypal_setting'));
    }

    //    =========== its for mail settings ===============
    public function mail_setting() {
        $data['title'] = display('mail_configuration');
        $data['mail_setting'] = $this->db->select('*')->from('email_config')->where('id', 1)->get()->result();
//        
        $content = $this->parser->parse('web_setting/mail_setting', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for mail_config_update ============
    public function mail_config_update() {
        $protocol = $this->input->post('protocol');
        $smtp_host = $this->input->post('smtp_host');
        $smtp_port = $this->input->post('smtp_port');
        $smtp_user = $this->input->post('smtp_user');
        $smtp_pass = $this->input->post('smtp_pass');
        $mailtype = $this->input->post('mailtype');

        $mail_data = array(
            'protocol' => $protocol,
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'mailtype' => $mailtype,
        );
//        dd($paypal_data);
        $this->db->where('id', 1)->update('email_config', $mail_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cweb_setting/mail_setting'));
    }

    //    =========== its for sms settings ===============
    public function sms_setting() {
        $data['title'] = display('sms_configuration');
        $gateway_id = 1;
//        $data['sms_setting'] = $this->db->select('*')->from('sms_gateway')->where('gateway_id', 1)->get()->result();
        $data['sms_gateway'] = $this->Web_settings->sms_gateway($gateway_id);
//        
        $content = $this->parser->parse('web_setting/sms_setting', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for mail_config_update ============
    public function sms_config_update() {
        $provider_name = $this->input->post('provider_name');
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');
        $phone = $this->input->post('phone');
        $sender_name = $this->input->post('sender_name');

        $sms_data = array(
            'provider_name' => $provider_name,
            'user' => $user_name,
            'password' => $password,
            'phone' => $phone,
            'authentication' => $sender_name,
        );
//        dd($mail_data);
        $this->db->where('gateway_id', 1)->update('sms_gateway', $sms_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cweb_setting/sms_setting'));
    }

}

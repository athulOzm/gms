<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// -------------------------------------------------------------
// Paypal IPN Class
//--------------------------------------------------------------
// PayPal Data
$ci = & get_instance();
$paypal = $ci->db->select('payment_mail, currency,status')
        ->from('gateway_tbl')
        ->where('id', 1)
        ->get()
        ->row();
//echo "<pre>";print_r($paypal); die();
$sandbox = "";

if ($paypal) {
    if ($paypal->status == 1) {
        $sandbox = FALSE;
    } else {
        $sandbox = TRUE;
    }
}


// Use PayPal on Sandbox or Live
$config['sandbox'] = $sandbox; // FALSE for live environment
// PayPal Business Email ID
$config['business'] = (!empty($paypal->paypal_email) ? $paypal->paypal_email : 'fleet_business@example.com');

// What is the default currency?
$config['paypal_lib_currency_code'] = (!empty($paypal->currency) ? $paypal->currency : 'USD');

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = TRUE;

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';

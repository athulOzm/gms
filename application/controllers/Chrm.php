<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chrm extends CI_Controller {

    public $menu;
    public $user_id;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Hrm_model');
        $this->load->model('Permission_model');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
    }

    //Designation form
    public function add_designation() {
        $data['title'] = display('add_designation');
        $content = $this->parser->parse('hr/employee_type', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // create designation
    public function create_designation() {
        $this->form_validation->set_rules('designation', display('designation'), 'required|max_length[100]');
        $this->form_validation->set_rules('details', display('details'), 'max_length[250]');
        #-------------------------------#
        if ($this->form_validation->run()) {
            $postData = [
                'id' => $this->input->post('id', true),
                'designation' => $this->input->post('designation', true),
                'details' => $this->input->post('details', true),
            ];
            if (empty($this->input->post('id', true))) {
                if ($this->Hrm_model->create_designation($postData)) {
                    $this->session->set_flashdata('message', display('save_successfully'));
                } else {
                    $this->session->set_flashdata('error_message', display('please_try_again'));
                }
            } else {
                if ($this->Hrm_model->update_designation($postData)) {
                    $this->session->set_flashdata('message', display('successfully_updated'));
                } else {
                    $this->session->set_flashdata('error_message', display('please_try_again'));
                }
            }
            redirect("Chrm/manage_designation");
        }
        redirect("Chrm/add_designation");
    }

    //Manage designation
    public function manage_designation() {
        $this->load->model('Hrm_model');
        $data['title'] = display('manage_designation');
        $data['designation_list'] = $this->Hrm_model->designation_list();
        $content = $this->parser->parse('hr/designation_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

    //designation Update Form
    public function designation_update_form($id) {
        $this->load->model('Hrm_model');
        $data['title'] = display('designation_update_form');
        $data['designation_data'] = $this->Hrm_model->designation_editdata($id);
        $content = $this->parser->parse('hr/employee_type', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // designation delete
    public function designation_delete($id) {
        $this->load->model('Hrm_model');
//        $id = $_POST['id'];
        $this->Hrm_model->delete_designation($id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
//        return true;
        redirect('Chrm/manage_designation');
    }

    // ================== Employee part =============================
    public function add_employee() {
        $this->auth->check_admin_auth();
        $this->load->model('Hrm_model');
        $data['title'] = display('add_employee');
        $data['desig'] = $this->Hrm_model->designation_dropdown();
        $data['get_rolelist'] = $this->Permission_model->user_list();
        $content = $this->parser->parse('hr/employee_form', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // create employee
    public function create_employee() {
        $this->load->model('Hrm_model');
        $user_id = $this->auth->generator(15);
        if ($_FILES['image']['name']) {
            $config['upload_path'] = './my-assets/image/employee/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Chrm/add_employee'));
            } else {
                $image = $this->upload->data();
                $image_url = base_url() . "my-assets/image/employee/" . $image['file_name'];
            }
        }
        $postData = [
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'designation' => $this->input->post('designation', true),
            'phone' => $this->input->post('phone', true),
            'image' => (!empty($image_url) ? $image_url : ''),
            'rate_type' => $this->input->post('rate_type', true),
            'email' => $this->input->post('email', true),
            'hrate' => $this->input->post('hrate', true),
            'address_line_1' => $this->input->post('address_line_1', true),
            'address_line_2' => $this->input->post('address_line_2', true),
            'blood_group' => $this->input->post('blood_group', true),
            'country' => $this->input->post('country', true),
            'city' => $this->input->post('city', true),
            'zip' => $this->input->post('zip', true),
            'user_id' => $user_id,
            'role_id' => $this->input->post('role_id', true),
        ];

        if ($this->Hrm_model->create_employee($postData)) {

//        ============ its for user access role assign ========
            $user_access_info = array(
                'user_id' => $user_id,
                'roleid' => 4,
                'createby' => $this->user_id,
                'createdate' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('sec_userrole', $user_access_info);

            $login_details = array(
                'user_id' => $user_id,
                'username' => $this->input->post('user_name'),
                'password' => md5("gef" . $this->input->post('password')),
                'user_type' => '2',
                'status' => '1',
            );
            $this->db->insert('user_login', $login_details);
//        =========== its for user info ============
            $user_details = array(
                'user_id' => $user_id,
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'gender' => '',
                'date_of_birth' => '',
                'logo' => (!empty($image_url) ? $image_url : ''),
                'status' => '1',
            );
            $this->db->insert('users', $user_details);
//        ============ its for user access role assign ========
            $user_access_info = array(
                'user_id' => $user_id,
                'roleid' => $this->input->post('role_id'),
                'createby' => $this->session->userdata('user_id'),
                'createdate' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('sec_userrole', $user_access_info);
            $this->session->set_flashdata('message', display('save_successfully'));
        } else {
            $this->session->set_flashdata('error_message', display('please_try_again'));
        }
        redirect("Chrm/manage_employee");
    }

    // Manage employee
    public function manage_employee() {
        $this->load->model('Hrm_model');
        $data['title'] = display('manage_employee');
        $data['employee_list'] = $this->Hrm_model->employee_list();
        $content = $this->parser->parse('hr/employee_list', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Employee Update form
    public function employee_update_form($id) {
        $this->load->model('Hrm_model');
        $data['title'] = display('employee_update');
        $data['employee_data'] = $this->Hrm_model->employee_editdata($id);
        $data['desig'] = $this->Hrm_model->designation_dropdown();
        $data['get_rolelist'] = $this->Permission_model->user_list();
        $content = $this->parser->parse('hr/employee_updateform', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // Update employee
    public function update_employee() {
//        echo $this->input->post('role_id', true); die();
        $this->load->model('Hrm_model');
        $user_id = $this->input->post('employee_id');

        if ($_FILES['image']['name']) {
            $config['upload_path'] = './my-assets/image/employee/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Chrm/add_employee'));
            } else {
                $image = $this->upload->data();
                $image_url = base_url() . "my-assets/image/employee/" . $image['file_name'];
            }
        }
        $headname = $this->input->post('id', true) . '-' . $this->input->post('old_first_name', true) . '' . $this->input->post('old_last_name', true);
        $postData = [
            'id' => $this->input->post('id', true),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'designation' => $this->input->post('designation', true),
            'phone' => $this->input->post('phone', true),
            'image' => (!empty($image_url) ? $image_url : $this->input->post('old_image', true)),
            'rate_type' => $this->input->post('rate_type', true),
            'email' => $this->input->post('email', true),
            'hrate' => $this->input->post('hrate', true),
            'address_line_1' => $this->input->post('address_line_1', true),
            'address_line_2' => $this->input->post('address_line_2', true),
            'blood_group' => $this->input->post('blood_group', true),
            'country' => $this->input->post('country', true),
            'city' => $this->input->post('city', true),
            'zip' => $this->input->post('zip', true),
            'role_id' => $this->input->post('role_id', true),
        ];
//        dd($postData);
        if ($this->Hrm_model->update_employee($postData, $headname)) {

//        ============ its for user access role assign ========
            $check_user_access = $this->db->select('*')->where('user_id', $user_id)->get('sec_userrole')->row();
//            dd($check_user_access);
            if ($check_user_access) {
                $user_access_info = array(
                    'roleid' => $this->input->post('role_id'),
                    'createby' => $this->user_id,
                    'createdate' => date('Y-m-d H:i:s'),
                );
                $this->db->where('user_id', $user_id);
                $this->db->update('sec_userrole', $user_access_info);
            } else {
                $user_access_info = array(
                    'user_id' => $user_id,
                    'roleid' => $this->input->post('role_id'),
                    'createby' => $this->user_id,
                    'createdate' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('sec_userrole', $user_access_info);
            }

            $oldpass = $this->input->post('oldpassword');
//            dd($oldpass);
            $password = md5("gef" . $this->input->post('password'));
            $login_details = array(
//                'user_id' => $user_id,
                'username' => $this->input->post('user_name'),
                'password' => (!empty($this->input->post('password')) ? $password : $oldpass),
                'user_type' => '2',
                'status' => '1',
            );
            $this->db->where('user_id', $user_id)->update('user_login', $login_details);
//        =========== its for user info ============
            $user_details = array(
//                'user_id' => $user_id,
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'gender' => '',
                'date_of_birth' => '',
                'logo' => (!empty($image_url) ? $image_url : $this->input->post('old_image', true)),
                'status' => '1',
            );
            $this->db->where('user_id', $user_id)->update('users', $user_details);

            $this->session->set_flashdata('message', display('successfully_updated'));
        } else {
            $this->session->set_flashdata('error_message', display('please_try_again'));
        }
        redirect("Chrm/manage_employee");
    }

    // delete employee
    public function employee_delete($id) {
        $this->load->model('Hrm_model');
//        $id = $_POST['id'];
        $get_employee_info = $this->db->select('*')->from('employee_history')->where('id', $id)->get()->row();
        $employee_user_id = $get_employee_info->user_id;
        if ($employee_user_id) {
            $this->db->where('user_id', $employee_user_id)->delete('users');
            $this->db->where('user_id', $employee_user_id)->delete('user_login');
        }
        if ($id) {
            $this->Hrm_model->delete_employee($id);
        }
        $this->session->set_userdata(array('message' => display('successfully_delete')));
        redirect("Chrm/manage_employee");
    }

    public function employee_details($id) {
        $this->load->model('Hrm_model');
        $data['title'] = display('employee_update');
        $data['row'] = $this->Hrm_model->employee_details($id);
        $content = $this->parser->parse('hr/resumepdf', $data, true);
        $this->template->full_admin_html_view($content);
    }

}

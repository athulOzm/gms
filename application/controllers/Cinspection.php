<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cinspection extends CI_Controller {

    public $menu;
    private $user_id;
    private $user_type;

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Jobs_model');
        $this->load->model('Inspection_model');
        $this->auth->check_admin_auth();
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    // Job Form
    public function create_checklist() {
        $data['title'] = display('create_checklist');
        $data['job_category'] = $this->db->select('*')->from('job_category')->order_by('job_category_name')->get()->result();
//        $data['get_jobtypelist'] = $this->Jobs_model->get_jobtypelist();
//        $data['get_employeelist'] = $this->Jobs_model->get_employeelist();
//        $data['get_productlist'] = $this->Jobs_model->get_productlist();
        $content = $this->parser->parse('inspection/create_checklist', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============= its for job_category_wise_type =============
    public function job_category_wise_type() {
        $category_id = $this->input->post('category_id');
        $job_category_wise_type = $this->Inspection_model->job_category_wise_type($category_id);
        $r = '';
        $sl = 0;
        foreach ($job_category_wise_type as $job_type) {
            $sl++;
            echo $r = '<div class="col-sm-6"><label for="' . $job_type->job_type_id . '_' . $sl . '">
                <input type="checkbox" id="' . $job_type->job_type_id . '_' . $sl . '" name="' . $category_id . '_job_type_id[]" value="' . $job_type->job_type_id . '"> ' . $job_type->job_type_name . ' </label></div>';
        }
    }

//    ============== its for checklist_save =============
    public function inspection_checklist_save() {
        $checklist_name = $this->input->post('checklist_name');
        $rate = $this->input->post('rate');
        $standard_timing = $this->input->post('standard_timing');
        $job_category_id = $this->input->post('job_category_id');

        $checklist_data = array(
            'inspection_name' => $checklist_name,
            'job_type_rate' => $rate,
            'standard_timing' => $standard_timing,
            'create_by' => $this->user_id,
            'create_date' => date('Y-m-d'),
        );
        $this->db->insert('inspection', $checklist_data);
        $checklist_last_id = $this->db->insert_id();

        $checklist_to_jobtype = array(
            'fk_inspection_id' => $checklist_last_id,
            'job_category_id' => '',
            'job_type_name' => $checklist_name,
            'job_type_rate' => $rate,
            'standard_timing' => $standard_timing,
            'create_by' => $this->user_id,
            'create_date' => date('Y-m-d'),
            'status' => 1
        );
        $this->db->insert('job_type', $checklist_to_jobtype);

        $i = 0;
        foreach ($job_category_id as $category) {
            $i++;
            $job_type_ids = $this->input->post($category . '_job_type_id');
            $job_typecount = count($job_type_ids);
            for ($j = 0; $j < $job_typecount; $j++) {
                $checklist_details = array(
                    'inspection_id' => $checklist_last_id,
                    'category_id' => $category,
                    'job_type_id' => $job_type_ids[$j],
                );
                $this->db->insert('inspection_list', $checklist_details);
            }
        }

        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cinspection/create_checklist/'));
    }

//    ======== its for view_checklist ============
    public function view_checklist() {
        $data['title'] = display('view_checklist');
//        $data['get_inspectionlist'] = $this->Inspection_model->get_inspectionlist();
        $config["base_url"] = base_url('Cinspection/view_checklist/');
        $config["total_rows"] = $this->db->count_all('inspection');
        $config["per_page"] = 15;
        $config["uri_segment"] = 3;
        $config["last_link"] = "Last";
        $config["first_link"] = "First";
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        #Paggination end#


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        $data['get_inspectionlist'] = $this->Inspection_model->get_inspectionlist($limit, $page);
        $data['links'] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        $content = $this->parser->parse('inspection/view_checklist', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for inspection_edit =============
    public function inspection_edit($inspection_id) {
        $data['title'] = display('edit_inspection');
        $data['job_category'] = $this->db->select('*')->from('job_category')->order_by('job_category_name')->get()->result();
        $data['inspection_edit'] = $this->Inspection_model->inspection_edit($inspection_id);
        $data['inspection_list_edit'] = $this->Inspection_model->inspection_list_edit($inspection_id);

        $content = $this->parser->parse('inspection/edit_inspection', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============= its for inspection_checklist_update ==========
    public function inspection_checklist_update() {
        $inspection_id = $this->input->post('inspection_id');
        $checklist_name = $this->input->post('checklist_name');
        $rate = $this->input->post('rate');
        $standard_timing = $this->input->post('standard_timing');
        $job_category_id = $this->input->post('job_category_id');

        $checklist_data = array(
            'inspection_name' => $checklist_name,
            'job_type_rate' => $rate,
            'standard_timing' => $standard_timing,
            'update_by' => $this->user_id,
            'update_date' => date('Y-m-d'),
        );
        $this->db->where('inspection_id', $inspection_id)->update('inspection', $checklist_data);
        $this->db->where('inspection_id', $inspection_id)->delete('inspection_list');

        $i = 0;
        foreach ($job_category_id as $category) {
            $i++;
            $job_type_ids = $this->input->post($category . '_job_type_id');
            $job_typecount = count($job_type_ids);
            for ($j = 0; $j < $job_typecount; $j++) {
                $checklist_details = array(
                    'inspection_id' => $inspection_id,
                    'category_id' => $category,
                    'job_type_id' => $job_type_ids[$j],
                );
                $this->db->insert('inspection_list', $checklist_details);
            }
        }

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cinspection/view_checklist/'));
    }

//    ======== its for get_checklist_design ===========
    public function get_checklist_design() {
        $inspection_id = $this->input->post('inspection_id');
        $data['job_id'] = $this->input->post('job_id');
        $data['get_inspection'] = $this->db->select('*')
                        ->from('inspection a')
                        ->join('job_type b', 'b.fk_inspection_id = a.inspection_id')
                        ->where('a.inspection_id', $inspection_id)
                        ->get()->row();
        $data['get_jobcategory'] = $this->Inspection_model->get_jobcategory($inspection_id);

        $this->load->view('inspection/checklist_design', $data);
    }

//    ========== its for package_save =============
    public function package_save() {
        $job_id = $this->input->post('job_id');
        $inspection_job_typeid = $this->input->post('inspection_job_typeid');
        $job_category_id = $this->input->post('job_category_id');
        $job_type_id = $this->input->post('job_type_id');
        $comment = $this->input->post('comment');
        $pass_fail = '';
        $check_packages = $this->db->select('*')->from('package_tbl a')
                        ->where('a.inspection_job_typeid', $inspection_job_typeid)
                        ->where('a.job_id', $job_id)->get()->result();
        if ($check_packages) {
            $this->db->where('inspection_job_typeid', $inspection_job_typeid)->where('job_id', $job_id)->delete('package_tbl');
        }
//        dd($check_packages);
        foreach ($job_category_id as $category) {
            $job_type_ids = $this->input->post($category . '_job_type_id');
            $job_typecount = count($job_type_ids);
            for ($j = 0; $j < $job_typecount; $j++) {
                $job_type_ids[$j] . '_pass_fail';
                $package_data = array(
                    'job_id' => $job_id,
                    'inspection_job_typeid' => $inspection_job_typeid,
                    'job_category_id' => $category,
                    'job_type_id' => $job_type_ids[$j],
                    'pass_fail' => $this->input->post($job_type_ids[$j] . '_pass_fail'),
                    'comment' => $comment,
                    'created_by' => $this->user_id,
                    'created_date' => date('Y-m-d'),
                    'status' => 1,
                );
//                echo '<pre>';                print_r($package_data); echo '</pre>';
                $this->db->insert('package_tbl', $package_data);
            }
        }

        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cjob/job_confirmation_form/' . $job_id));
    }

//    ======== its for get_view_checklist ===========
    public function get_view_checklist() {
        $inspection_id = $this->input->post('inspection_id');
        $data['job_id'] = $this->input->post('job_id');
        $data['get_inspection'] = $this->db->select('*')
                        ->from('inspection a')
                        ->join('job_type b', 'b.fk_inspection_id = a.inspection_id')
                        ->where('a.inspection_id', $inspection_id)
                        ->get()->row();
        $data['package_info'] = $this->Inspection_model->package_info($data['job_id']);
        $data['get_jobcategory'] = $this->Inspection_model->get_jobcategory($inspection_id);

        $this->load->view('inspection/view_checklist_design', $data);
    }

//    ============== its for inspection_delete ===========
    public function inspection_delete($inspection_id) {
        $job_type_data = $this->db->select('job_type_id')->where('fk_inspection_id', $inspection_id)->get('job_type')->row();
        $job_type_id = $job_type_data->job_type_id;
        if ($job_type_id) {
            $this->db->where('job_type_id', $job_type_id)->delete('job_type');
        }
        if ($inspection_id) {
            $this->db->where('inspection_id', $inspection_id)->delete('inspection');
            $this->db->where('inspection_id', $inspection_id)->delete('inspection_list');
        }
        $this->session->set_userdata(array('message' => display('delete_successfully')));
        redirect(base_url('Cinspection/view_checklist'));
    }

}

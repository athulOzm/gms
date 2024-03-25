<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission extends CI_Controller {

//    function __construct() {
//        parent::__construct();
//    }
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lpermission');
        $this->load->library('session');
        $this->load->model('Permission_model');
        $this->auth->check_admin_auth();
    }

    //Permission form
    public function index() {
        $content = $this->lpermission->permission_form();
        $this->template->full_admin_html_view($content);
    }

    public function create() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Permission_model');


        $data['title'] = display('add_role_permission');
        /* ----------------------------------- */
        //  $this->form_validation->set_rules('role_id', display('required'), 'required|numeric|max_length[11]');
        /* ----------------------------------- */
        $data = array(
            'type' => $this->input->post('role_id'),
        );
        $insert_id = $CI->Permission_model->insert_user_entry($data);
        /* ----------------------------------- */
        //$module       = $this->input->post('module'); 

        $fk_module_id = $this->input->post('fk_module_id');
        $create = $this->input->post('create');
        $read = $this->input->post('read');
        $update = $this->input->post('update');
        $delete = $this->input->post('delete');


        $new_array = array();
        for ($m = 0; $m < sizeof($fk_module_id); $m++) {
            for ($i = 0; $i < sizeof($fk_module_id[$m]); $i++) {
                for ($j = 0; $j < sizeof($fk_module_id[$m][$i]); $j++) {
                    $dataStore = array(
                        'role_id' => $insert_id,
                        'fk_module_id' => $fk_module_id[$m][$i][$j],
                        'create' => (!empty($create[$m][$i][$j]) ? $create[$m][$i][$j] : 0),
                        'read' => (!empty($read[$m][$i][$j]) ? $read[$m][$i][$j] : 0),
                        'update' => (!empty($update[$m][$i][$j]) ? $update[$m][$i][$j] : 0),
                        'delete' => (!empty($delete[$m][$i][$j]) ? $delete[$m][$i][$j] : 0),
                    );
                    array_push($new_array, $dataStore);
                }
            }
        }
        /* ----------------------------------- */
        if ($this->Permission_model->create($new_array)) {
            $id = $this->db->insert_id();
            $this->session->set_flashdata('message', display('role_permission_added_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("Permission/add_role");
    }

    public function user_assign() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpermission');
        $content = $this->lpermission->assign_form();
        $this->template->full_admin_html_view($content);
    }

    public function usercreate($id = null) {
        $data['title'] = display('list_Role_setup');
        #-------------------------------#
        $this->form_validation->set_rules('user_id', display('user_id'), 'required');
        $this->form_validation->set_rules('user_type', display('user_type'), 'required|max_length[30]');

        $user_id = $this->input->post('user_id');
        $roleid = $this->input->post('user_type');
        $create_by = $this->session->userdata('user_id');
        $create_date = date('Y-m-d h:i:s');
        #-------------------------------#
        $data['role_data'] = (Object) $postData = array(
            'id' => $this->input->post('id'),
            'user_id' => $user_id,
            'roleid' => $roleid,
            'createby' => $create_by,
            'createdate' => $create_date
        );
        if ($this->form_validation->run()) {
            if (empty($postData['id'])) {
                if ($this->Permission_model->role_create($postData)) {
                    $id = $this->db->insert_id();
                    $this->session->set_flashdata('exception', display('please_try_again'));
                } else {
                    
                }
                $this->session->set_flashdata('message', display('save_successfully'));
                redirect("Permission/user_assign");
            } else {

                $this->permission->method('dashboard', 'update')->redirect();

                if ($this->user_model->update_role($postData)) {

                    $this->session->set_flashdata('message', display('update_successfully'));
                } else {
                    $this->session->set_flashdata('exception', display('please_try_again'));
                }

                redirect("dashboard/user/create_user_role/" . $postData['id']);
            }
        } else {
            if (!empty($id)) {
                $data['title'] = display('update');
                $data['role'] = $this->user_model->findById($id);
            }
            $data['module'] = "dashboard";
            $data['user_list'] = $this->user_model->dropdown();
            $data['role_list'] = $this->user_model->role_list();
            $data['roles'] = $this->user_model->viewRole();
            $data['page'] = "user/role_setupform";
            redirect("Permission/user_assign");
        }
    }

    public function select_to_rol() {
        $id = $this->input->post('id');
        $role_reult = $this->db->select('sec_role.*,sec_userrole.*')
                ->from('sec_userrole')
                ->join('sec_role', 'sec_userrole.roleid=sec_role.id')
                ->where('sec_userrole.user_id', $id)
                ->group_by('sec_role.type')
                ->get()
                ->result();
        if ($role_reult) {
            $html = "";
            $html .= "<table id=\"dataTableExample2\" class=\"table table-bordered table-striped table-hover\">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>role_name</th>
                            </tr>
                        </thead>
                       <tbody>";
            $i = 1;
            foreach ($role_reult as $key => $role) {
                $html .= "<tr>
                                <td>$i</td>
                                <td>$role->type</td>
                            </tr>";
                $i++;
            }
            $html .= "</tbody>
                    </table>";
        }
        echo json_encode($html);
    }

    public function add_role() {
        $content = $this->lpermission->role_form();
        $this->template->full_admin_html_view($content);
    }

    public function role_list() {
        $content = $this->lpermission->role_view();
        $this->template->full_admin_html_view($content);
    }

    public function insert_role_user() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lpermission');

        $data = array(
            'type' => $this->input->post('type'),
        );

        $this->lpermission->roleinsert_user($data);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect("Permission/add_role");
    }

    public function edit_user($id) {

        $content = $this->lpermission->user_edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function role_update() {
        $this->load->model('Permission_model');
        $id = $this->input->post('id');
        $data = array(
            'type' => $this->input->post('type'),
        );
        $this->Permission_model->update_role($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect("Permission/add_role");
    }

    public function role_delete($id) {
        $this->load->model('Permission_model');
        $role = $this->Permission_model->delete_role($id);
        $role_per = $this->Permission_model->delete_role_permission($id);

        $data = array(
            'role' => $role,
            'role_per' => $role_per
        );

        if ($data) {
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("Permission/role_list");
    }

    public function edit_role($id) {
        $content = $this->lpermission->edit_role_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Permission_model');

        $id = $this->input->post('rid');

        $data = array(
            'type' => $this->input->post('role_id'),
            'id' => $this->input->post('rid'),
        );

        $CI->Permission_model->role_update($data, $id);


        $fk_module_id = $this->input->post('fk_module_id');
        $create = $this->input->post('create');
        $read = $this->input->post('read');
        $update = $this->input->post('update');
        $delete = $this->input->post('delete');


        $new_array = array();
        for ($m = 0; $m < sizeof($fk_module_id); $m++) {
            for ($i = 0; $i < sizeof($fk_module_id[$m]); $i++) {
                for ($j = 0; $j < sizeof($fk_module_id[$m][$i]); $j++) {
                    $dataStore = array(
                        'role_id' => $this->input->post('rid'),
                        'fk_module_id' => $fk_module_id[$m][$i][$j],
                        'create' => (!empty($create[$m][$i][$j]) ? $create[$m][$i][$j] : 0),
                        'read' => (!empty($read[$m][$i][$j]) ? $read[$m][$i][$j] : 0),
                        'update' => (!empty($update[$m][$i][$j]) ? $update[$m][$i][$j] : 0),
                        'delete' => (!empty($delete[$m][$i][$j]) ? $delete[$m][$i][$j] : 0),
                    );
                    array_push($new_array, $dataStore);
                }
            }
        }
        if ($this->Permission_model->create($new_array)) {
            $id = $this->db->insert_id();
            $this->session->set_flashdata('message', display('role_permission_updated_successfully'));
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect("Permission/role_list");
    }

    public function module_form($id = null) {
        if (!empty($id)) {
            $data['title'] = 'Module Update';
        } else {
            $data['title'] = 'Add Module';
        }
        $data['moduleinfo'] = $this->Permission_model->moduleinfo($id);
        $content = $this->parser->parse('permission/add_module', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function add_module() {
        $data = [
            'id' => $this->input->post('id'),
            'name' => $this->input->post('module_name'),
            'description' => null,
            'image' => null,
            'directory' => null,
            'status' => 1,
        ];
        if (!empty($this->input->post('id'))) {
            $this->db->where('id', $this->input->post('id'))
                    ->update('module', $data);
            $this->session->set_userdata(array('message' => display('successfully_updated')));
            redirect("Permission/module_form");
        } else {
            $this->db->insert('module', $data);
            $this->session->set_userdata(array('message' => display('successfully_inserted')));
            redirect("Permission/module_form");
        }
    }

    //Menu add 
    public function menu_form($id = null) {
        $config["base_url"] = base_url('Permission/menu_form');
        $config["total_rows"] = $this->db->count_all('sub_module');
        $config["per_page"] = 25;
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
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["menusetuplist"] = $this->Permission_model->menu_setuplist($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['pagenum'] = $page;

        if (!empty($id)) {
            $data['title'] = 'Menu Update';
        } else {
            $data['title'] = 'Add Menu';
        }
//        $data['module_list'] = $this->Permission_model->module_list($id);
//        $data['menuinfo'] = $this->Permission_model->menuinfo($id);
        $data['parent_menu'] = $this->Permission_model->get_parent_menu();
        $content = $this->parser->parse('permission/add_menu', $data, true);
        $this->template->full_admin_html_view($content);
    }

    // menu submit info
    public function add_menu() {
        $name = $this->input->post('menu_name');
        $module = $this->input->post('module');
        $check_menu = $this->db->select('*')->from('sub_module')->where('name', $name)->where('module', $module)->get()->row();
        if ($check_menu) {
            $this->session->set_userdata(array('error_message' => display('already_exists')));
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'module' => $module,
                'name' => $name,
                'url' => $this->input->post('url'),
                'parent_menu' => $this->input->post('parent_menu'),
                'ordering' => $this->input->post('order'),
                'icon' => $this->input->post('icon'),
                'description' => null,
                'image' => null,
                'directory' => null,
                'status' => 1,
            ];
            if (!empty($this->input->post('id'))) {
                $this->db->where('id', $this->input->post('id'))
                        ->update('sub_module', $data);
                $this->session->set_userdata(array('message' => display('successfully_updated')));
                redirect("Permission/menu_form");
            } else {
                $this->db->insert('sub_module', $data);
                $this->session->set_userdata(array('message' => display('successfully_inserted')));
                redirect("Permission/menu_form");
            }
        }
    }

    //    ===================== its for menusetup_inactive ===============
    public function menusetup_inactive($id) {
        $data = array(
            'status' => 0,
        );
        $this->db->where('id', $id);
        $this->db->update('sub_module', $data);
        $this->session->set_flashdata('success', "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Menu inactive successfully!</div>");
//        redirect('b-menu-setup');
        redirect($_SERVER['HTTP_REFERER']);
    }

//    ===================== its for menusetup_active ===============
    public function menusetup_active($id) {
        $data = array(
            'status' => 1,
        );
        $this->db->where('id', $id);
        $this->db->update('sub_module', $data);
        $this->session->set_flashdata('success', "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Menu active successfully!</div>");
//        redirect('b-menu-setup');
        redirect($_SERVER['HTTP_REFERER']);
    }

//    =========== its for menusetup edit ==========
    public function menusetup_edit($id) {
        $data['title'] = 'Menu Edit';
        $data['get_editdata'] = $this->Permission_model->menusetup_edit($id);
//        $data['module_list'] = $this->Permission_model->module_list($id);
        $data['parent_menu'] = $this->Permission_model->get_parent_menu();

        $content = $this->parser->parse('permission/menusetup_edit', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for menu update =============
    public function menu_update() {
        $menu_id = $this->input->post('menu_id');
        $data = [
            'module' => $this->input->post('module'),
            'name' => $this->input->post('menu_name'),
            'url' => $this->input->post('url'),
            'parent_menu' => $this->input->post('parent_menu'),
            'ordering' => $this->input->post('order'),
            'icon' => $this->input->post('icon'),
            'description' => null,
            'image' => null,
            'directory' => null,
            'status' => 1,
        ];
//        dd($data);
        $this->db->where('id', $menu_id)->update('sub_module', $data);
        $this->session->set_flashdata('success', "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>Menu inactive successfully!</div>");
        redirect('Permission/menu_form');
    }

//    =========== its for menu search =============

    public function menu_search() {
        $keyword = $this->input->post('keyword');
        $data['get_menu_search_result'] = $this->Permission_model->menu_search($keyword);
//        echo '<pre>';        print_r($data['get_menu_search_result']);die();
        $this->load->view('permission/menu_search_result', $data);
    }

//    ============= its for menu delete ============
    public function menusetup_delete($menu_id) {
        $this->db->where('id', $menu_id)->delete('sub_module');
        $this->session->set_flashdata('message', "Deleted successfully!");
        redirect('Permission/menu_form');
    }

}

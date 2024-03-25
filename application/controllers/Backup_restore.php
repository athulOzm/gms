<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_restore extends CI_Controller {

    private $savePath = "assets/data/backup/";
    private $fileName = "backup.sql";

    public function __construct() {
        parent::__construct();

        // if (! $this->session->userdata('isAdmin') )
        // 	redirect('login');
    }

    public function index() {
        $data['title'] = display('backup_and_restore');
        $data['module'] = "dashboard";
        $data['page'] = "home/backup_and_restore";
        $data['backup'] = $this->checkBackup();
        $data['file'] = $this->checkFileInfo();

//        echo '<pre>';        print_r($data['file']);        die();

        $content = $this->parser->parse('synchronizer/backup_and_restore', $data, true);
        $this->template->full_admin_html_view($content);

        //echo Modules::run('template/layout', $data); 
    }



    public function process() {
        $input = $this->input->post('input');
        if ($input == 1) {
            if ($this->backup()) {
                $data['success'] = display('backup_successfully');
            } else {
                $data['error'] = display('please_try_again');
            }
        }

        if ($input == 2) {
            if ($this->restore()) {
                $data['success'] = display('restore_successfully');
            } else {
                $data['error'] = display('please_try_again');
            }
        }

        echo json_encode($data);
    }

    public function checkBackup() {
        if (file_exists($this->savePath . $this->fileName)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkFileInfo() {
        if (file_exists($this->savePath . $this->fileName)) {
            $info = get_file_info($this->savePath . $this->fileName);
//            echo '<pre>';            print_r($info);die();
            return ( array(
                'name' => $info['name'],
                'size' => number_format($info['size'] / 1024, 2) . " KB (" . $info['size'] . " bytes)",
                'date' => date('Y-m-d H:i', $info['date']) . ' (' . $this->timeAgo($info['date']) . ')'
            ));
        } else {
            return false;
        }
    }

    public function backup() {
        $this->load->helper('file');
        $this->load->dbutil();

        $prefs = array(
            'format' => 'txt',
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n"
        );

        $backup = $this->dbutil->backup($prefs);

        if (write_file($this->savePath . $this->fileName, $backup)) {
            return true;
        } else {
            return false;
        }
    }

    public function restore() {
        $isi_file = file_get_contents($this->savePath . $this->fileName);
        $string_query = rtrim($isi_file, "\n;");
        $array_query = explode(";", $string_query);
        foreach ($array_query as $query) {
            $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->query($query);
            $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        }
        if (@unlink($this->savePath . $this->fileName)) {
            return true;
        } else {
            return false;
        }
    }

    public function download() {
        $db_name = 'backup' . '.sql';

        $this->load->dbutil();
        $prefs = array(
            'format' => 'sql',
            'filename' => 'backup.sql');
        $b = $this->dbutil->backup($prefs);
        $save = 'assets/data/backup/' . $db_name;
        $this->load->helper('file');
        $username = $this->db->username;
        //----- Removing Security Hash FROM CREATE VIEW Queries
        $backup = str_replace("ALGORITHM=UNDEFINED DEFINER=`" . $username . "`@`localhost` SQL SECURITY DEFINER", " ", $b);
        //----- Commenting INSERT queries FOR VIEWS


        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, str_replace("utf8mb4_unicode_ci;", " ", $backup));
    }



    public function delete() {
        if (file_exists($this->savePath . $this->fileName)) {
            if (@unlink($this->savePath . $this->fileName)) {
                $this->session->set_flashdata('message', display('delete_successfully'));
            } else {
                $this->session->set_flashdata('exception', display('please_try_again'));
            }
        } else {
            $this->session->set_flashdata('exception', display('please_try_again'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function timeAgo($time_ago) {
        $time_ago = strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
        $time = time() - $time_ago;

        switch ($time) {
            // seconds
            case $time <= 60;
                return 'less than a minute ago';
            // minutes
            case $time >= 60 && $time < 3600;
                return (round($time / 60) == 1) ? 'a minute' : round($time / 60) . ' minutes ago';
            // hours
            case $time >= 3600 && $time < 86400;
                return (round($time / 3600) == 1) ? 'a hour ago' : round($time / 3600) . ' hours ago';
            // days
            case $time >= 86400 && $time < 604800;
                return (round($time / 86400) == 1) ? 'a day ago' : round($time / 86400) . ' days ago';
            // weeks
            case $time >= 604800 && $time < 2600640;
                return (round($time / 604800) == 1) ? 'a week ago' : round($time / 604800) . ' weeks ago';
            // months
            case $time >= 2600640 && $time < 31207680;
                return (round($time / 2600640) == 1) ? 'a month ago' : round($time / 2600640) . ' months ago';
            // years
            case $time >= 31207680;
                return (round($time / 31207680) == 1) ? 'a year ago' : round($time / 31207680) . ' years ago';
        }
    }
// import form
      public function import_form(){
    $data['title'] = display('db_import');
    $content = $this->parser->parse('synchronizer/import', $data, true);
    $this->template->full_admin_html_view($content); 
  }
  // import database
  public function importdata() {
           
            if ($_FILES['image']['name']) {
            $config['upload_path'] = './assets/dbimport/';
            $config['allowed_types'] = 'sql';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Backup_restore/import_form'));
            } else {
                $file = $this->upload->data();
                $file_url = base_url() . "assets/dbimport/" . $file['file_name'];
            }
        }
    echo $this->db->database;exit();
        @$mysqli = new \mysqli(
            $this->db->hostname,
            $this->db->username,
            $this->db->password,
            $this->db->database
        );

        // Check for errors
        if (mysqli_connect_errno())
            return false;
        // Open the default SQL file
        $query = file_get_contents($file_url);

        // Execute a multi query
        $multi_query = $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        if ($multi_query){
            return true;
        } else {
            return false;
        }


    }
}

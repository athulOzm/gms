<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

    function get_userlist() {
        $this->db->select('*');
        $this->db->from('acc_coa');
        $this->db->where('IsActive', 1);
        $this->db->order_by('HeadName');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function dfs($HeadName, $HeadCode, $oResult, $visit, $d) {
        if ($d == 0)
            echo "<li class=\"jstree-open\">$HeadName";
        else if ($d == 1)
            echo "<li class=\"jstree-open\"><a href='javascript:' onclick=\"loadData('" . $HeadCode . "')\">$HeadName</a>";
        else
            echo "<li><a href='javascript:' onclick=\"loadData('" . $HeadCode . "')\">$HeadName</a>";
        $p = 0;
        for ($i = 0; $i < count($oResult); $i++) {

            if (!$visit[$i]) {
                if ($HeadName == $oResult[$i]->PHeadName) {
                    $visit[$i] = true;
                    if ($p == 0)
                        echo "<ul>";
                    $p++;
                    $this->dfs($oResult[$i]->HeadName, $oResult[$i]->HeadCode, $oResult, $visit, $d + 1);
                }
            }
        }
        if ($p == 0)
            echo "</li>";
        else
            echo "</ul>";
    }

// Accounts list
    public function Transacc() {
        return $data = $this->db->select("*")
                ->from('acc_coa')
                ->where('IsTransaction', 1)
                ->where('IsActive', 1)
                ->order_by('HeadName')
                ->get()
                ->result();
    }

// Credit Account Head
    public function Cracc() {
        return $data = $this->db->select("*")
                ->from('acc_coa')
                ->like('HeadCode', 1020102, 'after')
                ->where('IsTransaction', 1)
                ->order_by('HeadName')
                ->get()
                ->result();
    }

    // Insert Debit voucher 
    public function insert_debitvoucher() {
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "DV";
        $cAID = $this->input->post('cmbDebit');
        $dAID = $this->input->post('txtCode');
        $Debit = $this->input->post('txtAmount');
        $Credit = $this->input->post('grand_total');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo' => $voucher_no,
            'Vtype' => $Vtype,
            'VDate' => $VDate,
            'COAID' => $cAID,
            'Narration' => $Narration,
            'Debit' => 0,
            'Credit' => $Credit,
            'IsPosted' => $IsPosted,
            'CreateBy' => $CreateBy,
            'CreateDate' => $createdate,
            'IsAppove' => 0
        );

        $this->db->insert('acc_transaction', $cinsert);
        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Damnt = $Debit[$i];

            $debitinsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $dbtid,
                'Narration' => $Narration,
                'Debit' => $Damnt,
                'Credit' => 0,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $debitinsert);
        }
        return true;
    }

// Update debit voucher
    public function update_debitvoucher() {
        $voucher_no = $this->input->post('txtVNo');
        $Vtype = "DV";
        $cAID = $this->input->post('cmbDebit');
        $dAID = $this->input->post('txtCode');
        $Debit = $this->input->post('txtAmount');
        $Credit = $this->input->post('grand_total');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo' => $voucher_no,
            'Vtype' => $Vtype,
            'VDate' => $VDate,
            'COAID' => $cAID,
            'Narration' => $Narration,
            'Debit' => 0,
            'Credit' => $Credit,
            'IsPosted' => $IsPosted,
            'CreateBy' => $CreateBy,
            'CreateDate' => $createdate,
            'IsAppove' => 0
        );
        $this->db->where('VNo', $voucher_no)
                ->delete('acc_transaction');

        $this->db->insert('acc_transaction', $cinsert);
        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Damnt = $Debit[$i];

            $debitinsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $dbtid,
                'Narration' => $Narration,
                'Debit' => $Damnt,
                'Credit' => 0,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $debitinsert);
        }
        return true;
    }

//Generate Voucher No
    public function voNO() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'DV-', 'after')
                ->order_by('ID', 'desc')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

    // Credit voucher no
    public function crVno() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'CV-', 'after')
                ->order_by('ID', 'desc')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

    // Contra voucher 

    public function contra() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'Contra-', 'after')
                ->order_by('ID', 'desc')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

    // Insert Credit voucher 
    public function insert_creditvoucher() {
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "CV";
        $dAID = $this->input->post('cmbDebit');
        $cAID = $this->input->post('txtCode');
        $Credit = $this->input->post('txtAmount');
        $debit = $this->input->post('grand_total');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo' => $voucher_no,
            'Vtype' => $Vtype,
            'VDate' => $VDate,
            'COAID' => $dAID,
            'Narration' => $Narration,
            'Debit' => $debit,
            'Credit' => 0,
            'IsPosted' => $IsPosted,
            'CreateBy' => $CreateBy,
            'CreateDate' => $createdate,
            'IsAppove' => 0
        );

        $this->db->insert('acc_transaction', $cinsert);
        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $Credit[$i];

            $debitinsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $crtid,
                'Narration' => $Narration,
                'Debit' => 0,
                'Credit' => $Cramnt,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $debitinsert);
        }
        return true;
    }

// Insert Countra voucher 
    public function insert_contravoucher() {
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "Contra";
        $dAID = $this->input->post('cmbDebit');
        $cAID = $this->input->post('txtCode');
        $debit = $this->input->post('txtAmount');
        $credit = $this->input->post('txtAmountcr');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $credit[$i];
            $debit = $debit[$i];

            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $crtid,
                'Narration' => $Narration,
                'Debit' => $debit,
                'Credit' => $Cramnt,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            //print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $contrainsert);
        }
        return true;
    }

// Insert journal voucher 
    public function insert_journalvoucher() {
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "JV";
        $dAID = $this->input->post('cmbDebit');
        $cAID = $this->input->post('txtCode');
        $debit = $this->input->post('txtAmount');
        $credit = $this->input->post('txtAmountcr');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $credit[$i];
            $debit = $debit[$i];

            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $crtid,
                'Narration' => $Narration,
                'Debit' => $debit,
                'Credit' => $Cramnt,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            //print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $contrainsert);
        }
        return true;
    }

// journal voucher
    public function journal() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'Journal-', 'after')
                ->order_by('ID', 'desc')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

    // voucher Aprove 
    public function approve_voucher() {
        $values = array("DV", "CV", "JV", "Contra");

        return $approveinfo = $this->db->select('*')
                ->from('acc_transaction')
                ->where_in('Vtype', $values)
                ->where('IsAppove', 0)
                ->group_by('VNo')
                ->get()
                ->result();
        // print_r($approveinfo);exit;
    }

//approved
    public function approved($data = []) {
        return $this->db->where('VNo', $data['VNo'])
                        ->update('acc_transaction', $data);
    }

    //debit update voucher
    public function dbvoucher_updata($id) {
        return $vou_info = $this->db->select('*')
                ->from('acc_transaction')
                ->where('VNo', $id)
                ->where('Credit <', 1)
                ->get()
                ->result();
        // print_r($vou_info);exit;
    }

    //credit voucher update 
    public function crdtvoucher_updata($id) {
        return $vou_info = $this->db->select('*')
                ->from('acc_transaction')
                ->where('VNo', $id)
                ->where('Debit <', 1)
                ->get()
                ->result();
        // print_r($vou_info);exit;
    }

    //Debit voucher inof
    //credit voucher update 
    public function debitvoucher_updata($id) {
         $cr_info = $this->db->select('*')
                ->from('acc_transaction')
                ->where('VNo', $id)
                ->where('Credit<', 1)
                ->get()
                ->row();
         //echo $this->db->last_query();
        return $cr_info;
    }

    // debit update voucher credit info
    public function crvoucher_updata($id) {
        return $v_info = $this->db->select('*')
                ->from('acc_transaction')
                ->where('VNo', $id)
                ->where('Debit<', 1)
                ->get()
                ->row();
        //print_r($v_info);exit;
    }

    // update Credit voucher
    public function update_creditvoucher() {
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "CV";
        $dAID = $this->input->post('cmbDebit');
        $cAID = $this->input->post('txtCode');
        $Credit = $this->input->post('txtAmount');
        $debit = $this->input->post('grand_total');
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = $this->session->userdata('id');
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo' => $voucher_no,
            'Vtype' => $Vtype,
            'VDate' => $VDate,
            'COAID' => $dAID,
            'Narration' => $Narration,
            'Debit' => 0,
            'Credit' => $debit,
            'IsPosted' => $IsPosted,
            'CreateBy' => $CreateBy,
            'CreateDate' => $createdate,
            'IsAppove' => 0
        );
        $this->db->where('VNo', $voucher_no)
                ->delete('acc_transaction');

        $this->db->insert('acc_transaction', $cinsert);
        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $Credit[$i];

            $debitinsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $crtid,
                'Narration' => $Narration,
                'Debit' => 0,
                'Credit' => $Cramnt,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $debitinsert);
        }
        return true;
    }

    //Trial Balance Report 
    public function trial_balance_report($FromDate, $ToDate, $WithOpening) {

        if ($WithOpening)
            $WithOpening = true;
        else
            $WithOpening = false;

        $sql = "SELECT * FROM acc_coa WHERE IsGL=1 AND IsActive=1 AND HeadType IN ('A','L') ORDER BY HeadCode";
        $oResultTr = $this->db->query($sql);

        $sql = "SELECT * FROM acc_coa WHERE IsGL=1 AND IsActive=1 AND HeadType IN ('I','E') ORDER BY HeadCode";
        $oResultInEx = $this->db->query($sql);

        $data = array(
            'oResultTr' => $oResultTr->result_array(),
            'oResultInEx' => $oResultInEx->result_array(),
            'WithOpening' => $WithOpening
        );

        return $data;
    }

    //al hassan working
    public function get_vouchar() {


        $date = date('Y-m-d');
        $sql = "SELECT *, VNo, Vtype,VDate, SUM(Debit+Credit)/2 as Amount FROM acc_transaction  WHERE VDate='$date' AND VType IN ('DV','JV','CV') GROUP BY VNO, Vtype, VDate ORDER BY VDate";
        // $sql="SELECT VNo, Vtype,VDate, SUM(Debit+Credit)/2 as Amount FROM acc_transaction where Vdate='$date' AND VType IN('DV','JV','CV') GROUP BY VNo, Vtype, VDate ORDER BY VDate";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //al hassan working
    public function get_vouchar_view($date) {
        $sql = "SELECT acc_income_expence.COAID,SUM(acc_income_expence.Amount) AS Amount, acc_coa.HeadName FROM acc_income_expence INNER JOIN acc_coa ON acc_coa.HeadCode=acc_income_expence.COAID WHERE Date='$date' AND acc_income_expence.IsApprove=1 AND acc_income_expence.Paymode='Cash' GROUP BY acc_income_expence.COAID, acc_coa.HeadName ORDER BY acc_coa.HeadName";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //al hassan working
    public function get_cash() {
        $date = date('Y-m-d');


        $sql = "SELECT SUM(Debit) as Amount FROM acc_transaction WHERE VDate='$date' AND COAID ='1020101' AND VType NOT IN ('DV','JV','CV') AND IsAppove='1'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    //al hassan working
    public function get_general_ledger() {

        $this->db->select('*');
        $this->db->from('acc_coa');
        $this->db->where('IsGL', 1);
        $this->db->order_by('HeadName', 'asc');
        $query = $this->db->get();
        return $query->result();

//        $sql="SELECT * FROM acc_coa WHERE IsGL='1' ORDER BY HeadName";
//        $query = $this->db->query($sql);
//        return $query->result();
    }

    //al hassan working
    public function general_led_get($Headid) {

        $sql = "SELECT * FROM acc_coa WHERE HeadCode='$Headid' ";
        $query = $this->db->query($sql);
        $rs = $query->row();


        $sql = "SELECT * FROM acc_coa WHERE IsTransaction=1 AND PHeadName='" . $rs->HeadName . "' ORDER BY HeadName";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function voucher_report_serach($vouchar) {
        $sql = "SELECT SUM(Debit) as Amount FROM acc_transaction WHERE VDate='$vouchar' AND COAID ='1020101' AND VType NOT IN ('DV','JV','CV') AND IsAppove='1'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function general_led_report_headname($cmbGLCode) {
        $this->db->select('*');
        $this->db->from('acc_coa');
        $this->db->where('HeadCode', $cmbGLCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function general_led_report_headname2($cmbGLCode, $cmbCode, $dtpFromDate, $dtpToDate, $chkIsTransction) {

        if ($chkIsTransction) {
            //$cmbCode1=$cmbCode;
            $this->db->select('acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.Narration, acc_transaction.Debit, acc_transaction.Credit, acc_transaction.IsAppove, acc_transaction.COAID,acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType');
            $this->db->from('acc_transaction');
            $this->db->join('acc_coa', 'acc_transaction.COAID = acc_coa.HeadCode', 'left');
            $this->db->where('acc_transaction.IsAppove', 1);
            $this->db->where('VDate BETWEEN "' . $dtpFromDate . '" and "' . $dtpToDate . '"');
            $this->db->where('acc_transaction.COAID', $cmbCode);
            //$this->db->like('acc_transaction.COAID',$cmbGLCode,'after');

            $query = $this->db->get();
            return $query->result();
        } else {
            // $cmbCode1=$cmbCode;
            $this->db->select('acc_transaction.COAID,acc_transaction.Debit, acc_transaction.Credit,acc_coa.HeadName,acc_transaction.IsAppove, acc_coa.PHeadName, acc_coa.HeadType');
            $this->db->from('acc_transaction');
            $this->db->join('acc_coa', 'acc_transaction.COAID = acc_coa.HeadCode', 'left');
            $this->db->where('acc_transaction.IsAppove', 1);
            $this->db->where('VDate BETWEEN "' . $dtpFromDate . '" and "' . $dtpToDate . '"');
            $this->db->where('acc_transaction.COAID', $cmbCode);
            //$this->db->like('acc_transaction.COAID',$cmbGLCode,'after');
            $query = $this->db->get();
            return $query->result();
        }
//            $sql="SELECT acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.Debit, acc_transaction.Credit, acc_transaction.IsAppove, acc_transaction.COAID, acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType, FROM acc_transaction INNER JOIN acc_coa ON acc_transaction.COAID = acc_coa.HeadCode
//      WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '$dtpFromDate' AND '$dtpToDate' AND acc_transaction.COAID LIKE '$cmbGLCode%' ";
//            $query = $this->db->query($sql);
//            return $query->result();
    }

    // prebalance calculation
    public function general_led_report_prebalance($cmbCode, $dtpFromDate) {


        //$cmbCode1=$cmbCode;
        $this->db->select('sum(acc_transaction.Debit) as predebit, sum(acc_transaction.Credit) as precredit');
        $this->db->from('acc_transaction');
        $this->db->where('acc_transaction.IsAppove', 1);
        $this->db->where('VDate < ', $dtpFromDate);
        $this->db->where('acc_transaction.COAID', $cmbCode);
        //$this->db->like('acc_transaction.COAID',$cmbGLCode,'after');

        $query = $this->db->get()->row();
        // print_r($query);exit;
        return $balance = $query->predebit - $query->precredit;
    }

    public function get_status() {

        $this->db->select('*');
        $this->db->from('acc_coa');
        $this->db->where('IsTransaction', 1);
        $this->db->like('HeadCode', '1020102', 'after');
        $this->db->order_by('HeadName', 'asc');
        $query = $this->db->get();
        return $query->result();
        // $sql="SELECT * FROM acc_coa WHERE HeadCode LIKE '1020102%' AND IsTransaction=1 ORDER BY HeadName";
    }

    //Profict loss report search
    public function profit_loss_serach() {

        $sql = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='I'";
        $sql1 = $this->db->query($sql);

        $sql = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='E'";
        $sql2 = $this->db->query($sql);

        $data = array(
            'oResultAsset' => $sql1->result(),
            'oResultLiability' => $sql2->result(),
        );
        return $data;
    }

    public function profit_loss_serach_date($dtpFromDate, $dtpToDate) {
        $sqlF = "SELECT  acc_transaction.VDate, acc_transaction.COAID, acc_coa.HeadName FROM acc_transaction INNER JOIN acc_coa ON acc_transaction.COAID = acc_coa.HeadCode WHERE acc_transaction.VDate BETWEEN '$dtpFromDate' AND '$dtpToDate' AND acc_transaction.IsAppove = 1 AND  acc_transaction.COAID LIKE '301%'";
        $query = $this->db->query($sqlF);
        return $query->result();
    }

    public function treeview_selectform($id) {
        $data = $this->db->select('*')
                ->from('acc_coa')
                ->where('HeadCode', $id)
                ->get()
                ->row();
        return $data;
    }

    public function get_supplier() {
        $this->db->select('*');
        $this->db->from('supplier_information');
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // Customer list
    public function get_customer() {
        $this->db->select('*');
        $this->db->from('customer_information');
        $query = $this->db->get();
        return $query->result();
    }

    public function Spayment() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'PM-', 'after')
                ->order_by('ID', 'desc')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

// customer code
    public function Creceive() {
        return $data = $this->db->select("Max(VNo) as voucher")
                ->from('acc_transaction')
                ->like('VNo', 'CR-', 'after')
                ->get()
                ->result_array();
        // print_r($data);exit;
    }

    public function supplier_payment_insert() {
        $this->load->model('Web_settings');
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "PM";
        $cAID = $this->input->post('cmbDebit');
        $dAID = $this->input->post('txtCode');
        $Debit = $this->input->post('txtAmount');
        $Credit = 0;
        $VDate = $this->input->post('dtpDate');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        $IsPosted = 1;
        $IsAppove = 1;
        $sup_id = $this->input->post('supplier_id');

        $CreateBy = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');

        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Damnt = $Debit[$i];
            $supplier_id = $sup_id[$i];
            $supinfo = $this->db->select('*')->from('supplier_information')->where('supplier_id', $supplier_id)->get()->row();
            $supplierdebit = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $dbtid,
                'Narration' => $Narration,
                'Debit' => $Damnt,
                'Credit' => 0,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 1
            );
            $cc = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => 1020101,
                'Narration' => 'Cash in Hand For Voucher No' . $voucher_no,
                'Debit' => 0,
                'Credit' => $Damnt,
                'IsPosted' => 1,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 1
            );
            $datapay = array(
                'transaction_id' => $voucher_no,
                'supplier_id' => $supplier_id,
                'chalan_no' => NULL,
                'deposit_no' => $voucher_no,
                'amount' => $Damnt,
                'description' => 'Paid From Accounts',
                'payment_type' => 1,
                'cheque_no' => '',
                'date' => $VDate,
                'status' => 1,
                'd_c' => 'd'
            );
            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $supplierdebit);
            $this->db->insert('acc_transaction', $cc);
            $this->db->insert('supplier_ledger', $datapay);
            $message = 'Mr.' . $supinfo->supplier_name . ',
        ' . 'You have Receive ' . $Damnt . ' ' . $currency_details[0]['currency'];
            $this->send_sms($supinfo->mobile, $message);
        }
        return true;
    }

    public function customer_receive_insert() {
        $this->load->model('Web_settings');
        $currency_details = $this->Web_settings->retrieve_setting_editdata();
        $voucher_no = addslashes(trim($this->input->post('txtVNo')));
        $Vtype = "CR";
        $cAID = $this->input->post('cmbDebit');
        $dAID = $this->input->post('txtCode');
        $Debit = 0;
        $Credit = $this->input->post('txtAmount');
        $VDate = $this->input->post('dtpDate');
        $customer_id = $this->input->post('customer_id');
        $Narration = addslashes(trim($this->input->post('txtRemarks')));
        if ($Narration) {
            $Narration = $Narration;
        } else {
            $Narration = "Paid by customer";
        }
//        dd($Narration);
        $IsPosted = 1;
        $IsAppove = 1;
        $CreateBy = $this->session->userdata('user_id');
        $createdate = date('Y-m-d H:i:s');

        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Credit = $Credit[$i];
            $customerid = $customer_id[$i];
            $customerinfo = $this->db->select('*')->from('customer_information')->where('customer_id', $customerid)->get()->row();
            $supplierdebit = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $dbtid,
                'Narration' => $Narration,
                'Debit' => 0,
                'Credit' => $Credit,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 1
            );
            $datarcv = array(
                'transaction_id' => $voucher_no,
                'customer_id' => $customerid,
                'invoice_no' => NULL,
                'receipt_no' => $voucher_no,
                'description' => "Accunts receive",
                'amount' => $Credit,
                'description' => $Narration,
                'payment_type' => 1,
                'cheque_no' => '',
                'date' => $VDate,
                'receipt_from' => 'receipt',
                'status' => 1,
                'd_c' => 'c',
            );
            $cc = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $createdate,
                'COAID' => 1020101,
                'Narration' => 'Cash in Hand For Voucher No' . $voucher_no,
                'Debit' => $Credit,
                'Credit' => 0,
                'IsPosted' => 1,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 1
            );


            // print_r($debitinsert);exit;
            $this->db->insert('acc_transaction', $supplierdebit);
            $this->db->insert('acc_transaction', $cc);
            $this->db->insert('customer_ledger', $datarcv);
            $message = 'Mr.' . $customerinfo->customer_name . ',
        ' . 'You have Paid ' . $Credit . ' ' . $currency_details[0]['currency'];
            $this->send_sms_customer($customerinfo->customer_mobile, $message);
        }
        return true;
    }

// =================== Settings data ==============================
    public function software_setting_info() {
        $this->db->select('*');
        $this->db->from('web_setting');
        $this->db->where('setting_id', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

// sms configuration 

    public function send_sms($phone = null, $msg = null) {
        $config_data = $this->db->select('*')->from('sms_settings')->get()->row();
        if ($config_data->ispayment == 0) {
            return true;
        } else {
            $recipients = $phone;
            $url = $config_data->url; //"http://sms.bdtask.com/smsapi"; 
            $senderid = $config_data->sender_id; //"8801847169884";
            $apikey = $config_data->api_key; //"C20029865c42c504afc711.77492546";
            $message = $msg;
            //echo "$url?api_key=$apikey&type=text&contacts=$recipients&senderid=$senderid&msg=$message";
            $urltopost = $config_data->url; //"http://sms.bdtask.com/smsapi";
            $datatopost = array(
                "api_key" => $apikey,
                "type" => 'text',
                "senderid" => $senderid,
                "msg" => $message,
                "contacts" => $recipients
            );

            $ch = curl_init($urltopost);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
//print_r($result);
            if ($result === false) {
                echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
                return;
            }
            curl_close($ch);
            return $result;
        }
    }

    public function send_sms_customer($phone = null, $msg = null) {
        $config_data = $this->db->select('*')->from('sms_settings')->get()->row();
        if ($config_data->isreceive == 0) {
            return true;
        } else {
            $recipients = $phone;
            $url = $config_data->url; //"http://sms.bdtask.com/smsapi"; 
            $senderid = $config_data->sender_id; //"8801847169884";
            $apikey = $config_data->api_key; //"C20029865c42c504afc711.77492546";
            $message = $msg;
            //echo "$url?api_key=$apikey&type=text&contacts=$recipients&senderid=$senderid&msg=$message";
            $urltopost = $config_data->url; //"http://sms.bdtask.com/smsapi";
            $datatopost = array(
                "api_key" => $apikey,
                "type" => 'text',
                "senderid" => $senderid,
                "msg" => $message,
                "contacts" => $recipients
            );

            $ch = curl_init($urltopost);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
//print_r($result);
            if ($result === false) {
                echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
                return;
            }
            curl_close($ch);
            return $result;
        }
    }

}

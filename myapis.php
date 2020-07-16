<?php use myDatabaseUtils\myDatabaseUtils; ?>
<?php include_once '../vendor/autoload.php';?>
<?php error_reporting(0); ?>
<?php @ini_set('display_errors', 0);?>
<?php
    $db = new myDatabaseUtils();
    $db->DbType('mysql')
            ->HostName('localhost')
            ->DbName('supergam_godigit')
            ->Username('supergam_godigit')
            ->Password('supergam_godigit');
    $db->TableName('tb_customer');
    $db->connect();
    if(isset($_GET['action'])){
        if($_GET['action'] == 'get'){
            if(isset($_GET['cus'])){
                echo get_customer($db, trim($_GET['cus']));
            }else{
                echo json_encode(array('status'=> 100, 'msg' => 'Fail, Varaible "cus" is not exist.' , 'result' => null));    
            }
            
        }elseif(in_array($_GET['action'], array('insert', 'update', 'delete'))){
            $mode = $_GET['action'];
            $fn = (isset($_POST['fn']) ? trim($_POST['fn']) : null);
            $ln = (isset($_POST['ln']) ? trim($_POST['ln']) : null);
            $tl = (isset($_POST['tl']) ? trim($_POST['tl']) : null);
            $id = (isset($_POST['id']) ? trim($_POST['id']) : null);
            echo query_customer($mode, $db, $fn, $ln, $tl, $id);
        }else{
            echo json_encode(array('status'=> 100, 'msg' => 'Fail, Mode ' . $_GET['action'] . ' not found.' , 'result' => $_GET['cus']));
        }
    }
    
    function get_customer($db, $n){
        if($n == 'all'){
            $customer_data = $db->get([]);
        }else{
            if(chknum($n)){
                $customer_data = $db->get(['wheres' => 'customer_id = ?', 'value' => [$n]]);
            }else{
                return json_encode(array('status'=> 100, 'msg' => 'Fail, Variable format is incorrect.', 'result' => null));
            }
        }
        return json_encode(array('status'=> 200, 'msg' => 'Success', 'result' => $customer_data));
    }
    function chknum($n){
        return preg_match('/^[0-9]+$/',$n);
    }
    function chkname($n){
        return preg_match('/[ก-๙a-zA-Z]+$/',$n);
    }
    function chktele($n){
        return preg_match('/^[0{1}689{1}0-9{8}]+$/',$n);
    }
    function query_customer($mode, $db, $fn = null, $ln = null, $tl = null, $id = null){
        if($mode == 'delete' && chknum($id)){
            $r = $db->delete("DELETE FROM tb_customer WHERE customer_id = ?", [$id]);
            if(!$r){
                $msg = 'ไม่สามารถลบข้อมูลได้ โปรดลองใหม่อีกครั้ง';
                $status = 100;
            } else {
                $msg = 'ลบข้อมูลเสร็จสิ้น ทั้งหมด ' . $r . ' แถว';
                $status = 200;
            }
        }else if($mode == 'update' && chkname($fn) && chkname($ln) && chktele($tl) && chknum($id)){
            $r = $db->put("UPDATE tb_customer SET first_name = ?, last_name = ?, tel_no = ? WHERE customer_id = ?", [$fn,$ln,$tl,$id]);
            if(!$r){
                $msg = 'ไม่สามารถอัพเดทข้อมูลได้ โปรดลองใหม่อีกครั้ง';
                $status = 100;
            } else {
                $msg = 'อัพเดทข้อมูลเสร็จสิ้น ทั้งหมด ' . $r . ' แถว';
                $status = 200;
            }
        }else if($mode == 'insert' && chkname($fn) && chkname($ln) && chktele($tl)){
            $r = $db->post("INSERT INTO tb_customer (first_name, last_name, tel_no) VALUES (?,?,?)", [$fn,$ln,$tl]);
            if(!$r){
                $msg = 'ไม่สามารถเพิ่มข้อมูลได้ โปรดลองใหม่อีกครั้ง';
                $status = 100;
            } else {
                $msg = 'เพิ่มข้อมูลเสร็จสิ้น';
                $status = 200;
            }
        }else{
            $msg = '';
            if($mode != 'delete' && !chkname($fn)){
                $msg = 'รูปแบบของชื่อไม่ถูกต้อง';
            }
            if($mode != 'delete' && !chkname($ln)){
                $msg = ($msg != '' ? $msg . PHP_EOL  : '');
                $msg .= 'รูปแบบของนามสกุลไม่ถูกต้อง';
            }
            if($mode != 'delete' && !chktele($tl)){
                $msg = ($msg != '' ? $msg . PHP_EOL  : '');
                $msg .= 'รูปแบบของเบอร์โทรไม่ถูกต้อง';
            }
            if($mode == 'delete' || $mode == 'update' && !chknum($id)){
                $msg = ($msg != '' ? $msg . PHP_EOL  : '');
                $msg .= 'รูปแบบของข้อมูลไม่ถูกต้อง';
            }
            $msg .= PHP_EOL . 'โปรดลองใหม่อีกครั้ง';
            $status = 100;
        }
        return json_encode(array('status'=> $status, 'msg' => $msg, 'result' => (isset($r) ? $r : null)));
    }

?>

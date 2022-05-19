<?php

namespace App\Controllers;

use App\Models\Mol_employees;
use App\Models\Mol_product;
use App\Models\Mol_order;



class Home extends BaseController
{

    public function __construct()
    {

        $this->mol_emp = new Mol_employees();
        $this->mol_prd = new Mol_product();
        $this->mol_ord = new Mol_order();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function runFunction()
    {
        //?id=191
        header('Content-Type: application/json');

        if ($this->request->isAJAX()) {

            $process = esc($this->request->getPost('process')); // รับค่า post
            $mol_emp = new Mol_employees(); // ประกาศ model 
            $mol_prd = new Mol_product(); // ประกาศ model 
            $mol_ord = new Mol_order();
            if ($process == 'get_employeesdata') {

                $arrData['officeCode'] = esc($this->request->getPost('office_code'));
                if (isset($arrData['officeCode'])) {
                    $data = $mol_emp->select_employees($arrData);
                } else {
                    $data = $mol_emp->select_employees();
                }

                if (isset($data)) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                        'response' => $data
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'nodata',
                        'response' => null
                    ]);
                }
            } else if ($process == 'insert_employeesdata') {

                // $mol_emp = new Mol_employees();

                // SELECT * FROM Table ORDER BY ID DESC LIMIT 1

                $last_emp = $mol_emp->select_last_employeesnumber();
                $last_emp_decode = json_decode(json_encode($last_emp[0]), true);

                $data = [
                    'employeeNumber' => $last_emp_decode['employeeNumber'] + 1,
                    'lastName' => $this->request->getPost('lastName'),
                    'firstName' => $this->request->getPost('firstName'),
                    'email' => $this->request->getPost('email'),
                    'officeCode' => '1',
                    'jobTitle' => 'TestAdd',
                    'extension' => 'xxx1235',
                ];
                $insert = $mol_emp->insert($data);
                if ($insert == 0) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => false,
                        'message' => 'fail',
                    ]);
                }
            } else if ($process == 'delete_employeesdata') {

                $id = $this->request->getPost('id');
                $delete = $mol_emp->delete_employees($id);
                if ($delete == 1) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => false,
                        'message' => 'fail',
                    ]);
                }
            } else if ($process == 'update_employeesdata') {
                $id = $this->request->getPost('id');
                $data = [
                    'lastName' => $this->request->getPost('lastName'),
                    'firstName' => $this->request->getPost('firstName'),
                    'email' => $this->request->getPost('email'),
                ];
                $update = $mol_emp->update_employees($data, $id);

                if ($update == 0) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => false,
                        'message' => 'fail',
                    ]);
                }
            } else if ($process == 'get_productdata') {

                $arrData['productScale'] = "1:10";
                $data = $mol_prd->select_product($arrData);

                if (isset($data)) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                        'response' => $data
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'nodata',
                        'response' => null
                    ]);
                }
            } else if ($process == 'get_order') {
                $data = $mol_ord->select_order();

                if (isset($data)) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                        'response' => $data
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'nodata',
                        'response' => null
                    ]);
                }
            } else if ($process == 'get_order_detail') {

                $arrData['orderNumber'] = $this->request->getPost('id');
                $data = $mol_ord->select_order_detail_join($arrData);

                if (isset($data)) {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'success',
                        'response' => $data
                    ]);
                } else {
                    http_response_code(200);
                    echo json_encode($response = [
                        'status' => true,
                        'message' => 'nodata',
                        'response' => null
                    ]);
                }
            }
        }
    }
    public function test_order()
    {

        // $arrData['orderNumber'] = 10100;
        // $mol_ord = new Mol_order();
        // $data = $mol_ord->select_order_detail_join($arrData);
        //var_dump($data);
        return view('datatableorder');
    }
    public function test_most_product()
    {
        return view('datatableproduct');
    }

    public function test_tokyo_emp()
    {
        return view('datatable2');
    }

    public function test()
    {
        return view('datatable');
    }

    public function add_emp_from()
    {
        return view('form');
    }


    public function edit_emp_from()
    {
        // $mol_emp = new Mol_employees();
        // $data = $mol_emp->select_employees();
        // print_r($data);
        $mol_emp = new Mol_employees();
        $arrWheredata['employeeNumber'] = $this->request->getGet('id');
        $data = $mol_emp->select_employees($arrWheredata);
        $arrContent['data'] = json_decode(json_encode($data[0]), true);
        // $array = json_decode(json_encode($object), true);
        return view('form', $arrContent);
    }

    // public function insert_emp()
    // {


    //     ['employeeNumber', 'lastName', 'firstName', 'extension', 'email', 'officeCode', 'jobTitle']

    // }


}
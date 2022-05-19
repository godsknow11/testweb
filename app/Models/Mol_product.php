<?php

namespace App\Models;

use CodeIgniter\Model;




class Mol_product extends Model
{

    // protected $table = 'employees';
    // protected $allowedFields = ['employeeNumber', 'lastName', 'firstName', 'extension', 'email', 'officeCode', 'jobTitle'];

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    // protected $table = "employees";
    // protected $primaryKey = "employeeNumber";
    // protected $allowedFields = ['employeeNumber', 'lastName', 'firstName', 'extension', 'email', 'officeCode', 'jobTitle'];


    public function select_product(array $data = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        //$builder->orderBy('employeeNumber', 'DESC');
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                // $this->db->where($key, $value);
                $query = $builder->getWhere([$key => $value]);
            }
        } else {
            $query = $builder->get();
        }

        $result = $query->getResult();

        if (count($result) > 0) {
            return $result;
        } else {
            return 0;
        }
    }

    public function delete_employees($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('employees');
        $result = $builder->delete(['employeeNumber' => $id]);
        return $result;
    }

    // public function insert_employees($data, $id)
    // {
    //     $db = \Config\Database::connect();
    //     $query = $db->query('insert into employees');
    //     $result = $query->getResult();

    //     if (count($result) > 0) {
    //         return $result;
    //     } else {
    //         return 0;
    //     }
    // }

    // public function  Insertridernumber($data)
    // {
    //     $this->load->database('quickservice_rider', false, true);
    //     $data['CreateDate'] = date("Y-m-d H:i:s");
    //     $data['CreateUserId'] = $_SESSION['Id'];
    //     $data['DeleteFlag'] = 0;
    //     $t = $this->db->insert('ridernumber', $data);
    //     if (isset($t)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }



    public function select_employeestest()
    {
        $data = [
            ['Name' => 'BOONNAJA', 'Age' => '20'],
            ['Name' => 'BOONNAJA2', 'Age' => '202'],
            ['Name' => 'BOONNAJA3', 'Age' => '203']
        ];
        return $data;
    }
}
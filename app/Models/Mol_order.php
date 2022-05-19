<?php

namespace App\Models;

use CodeIgniter\Model;




class Mol_order extends Model
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


    public function select_order(array $data = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
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

    public function select_order_detail(array $data = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orderdetails');
        //$builder->orderBy('employeeNumber', 'DESC');
        //$builder->join('product', 'comments.productCode = orderdetails.productCode');
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

    public function select_order_detail_join(array $data = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orderdetails as od');
        $builder->select('od.*,pd.productName as productname');
        $builder->join('products as pd', 'pd.productCode = od.productCode', "left");
        // $query = $builder->get();


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
}
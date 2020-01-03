<?php

namespace BodeLocke\Rotessa;

use BodeLocke\Rotessa\Request;

class Rotessa
{
    public function __construct()
    {
        $this->request = new Request();
    }

    public function createCustomer($data)
    {
        return $this->request->post('create_customer', $data);
    }

    public function getCustomer($id)
    {
        return $this->request->get('customer', $id);
    }

    public function updateCustomer($data)
    {
        return $this->request->post('update_customer', $data);
    }

    public function getAllCustomers()
    {
        return $this->request->get('all_customers', null);
    }

    public function createTransactionSchedule($data)
    {
        return $this->request->post('create_transaction', $data);
    }

    public function getTransactionSchedule($id)
    {
        return $this->request->get('transaction', $id);
    }

    public function updateTransactionSchedule($data)
    {
        return $this->request->patch('update_transaction', $data);
    }

    public function deleteTransactionSchedule($id)
    {
        return $this->request->delete('delete_transaction', $id);
    }

    // public function showTransactionsReport($start, $end, $status = 'all', $page = 100)
    // {
    //     return $this->request->get('report', $start, $end, $status, $page);
    // }
}

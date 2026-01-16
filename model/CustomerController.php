<?php
// application/controllers/CustomerController.php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_data_model');
        $this->load->helper('download');
        $this->load->helper('url');
    }
    
    public function download_csv() {
        // Debug: Check if we're reaching this method
        error_log("CSV download requested");
        
        // Get filters from GET parameters
        $filters = [
            'country_id'      => $this->input->get('filter_country'),
            'account_status'  => $this->input->get('filter_status'),
            'search_text'     => $this->input->get('search_text'),
            'id'              => $this->input->get('filter_id'),
            'gender'          => $this->input->get('filter_gender'),
            'age'             => $this->input->get('filter_age'),
            'filter_phone'    => $this->input->get('filter_phone'),
            'membership_from' => $this->input->get('membership_from'),
            'membership_to'   => $this->input->get('membership_to'),
            'access_level'    => $this->input->get('filter_access_level'),
            'product_interest'=> $this->input->get('product_interest') ?? [],
        ];
        
        // Clean filters (remove empty values)
        $filters = array_filter($filters, function($value) {
            if (is_array($value)) {
                return !empty($value);
            }
            return $value !== '' && $value !== null;
        });
        
        error_log("Filters: " . print_r($filters, true));
        
        // Get all filtered data
        $customers = $this->Customer_data_model->get_all_filtered_customers($filters);
        error_log("Customers found: " . count($customers));
        
        // Set CSV headers
        $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Create output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        
        // CSV headers
        $headers = [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Age',
            'Gender',
            'Country',
            'Access Level',
            'Account Status',
            'Membership From',
            'Membership To',
            'Product Interests',
            'Registration Date'
        ];
        
        fputcsv($output, $headers);
        
        // Add data rows
        foreach ($customers as $customer) {
            $row = [
                $customer->id,
                $customer->first_name,
                $customer->last_name,
                $customer->email,
                $customer->phone,
                $customer->age,
                $customer->gender,
                $this->get_country_name($customer->country_id),
                $customer->access_level,
                $customer->account_status,
                $customer->membership_from,
                $customer->membership_to,
                $customer->product_interest,
                $customer->created_at
            ];
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit;
    }
    
    private function get_country_name($country_id) {
        $countries = [
            1 => 'USA',
            2 => 'Canada',
            3 => 'UK'
        ];
        return $countries[$country_id] ?? 'Unknown';
    }
    
    public function download_pdf() {
        // For now, show a proper error or message
        $this->session->set_flashdata('error', 'PDF download feature is under development. Please use CSV download.');
        redirect('test/displayData');
    }
}
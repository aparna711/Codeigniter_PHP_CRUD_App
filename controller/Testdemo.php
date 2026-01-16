<?php
// application/controllers/Test.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url','form');
        $this->load->model('Customer_data_model');
    }
    
    public function displayData() {
        // Initialize filters array
        $filters = [];
        
        // ✅ Check if this is a POST request (form submission)
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // Collect filters from POST
            $post_filters = [
                'filter_country' => $this->input->post('filter_country'),
                'filter_status' => $this->input->post('filter_status'),
                'search_text' => $this->input->post('search_text'),
                'filter_id' => $this->input->post('filter_id'),
                'filter_gender' => $this->input->post('filter_gender'),
                'filter_age' => $this->input->post('filter_age'),
                'filter_phone' => $this->input->post('filter_phone'),
                'membership_from' => $this->input->post('membership_from'),
                'membership_to' => $this->input->post('membership_to'),
                'filter_access_level' => $this->input->post('filter_access_level'),
                'product_interest' => $this->input->post('product_interest') ?? [],
            ];
            
            // Build query string and redirect
            $query_string = http_build_query(array_filter($post_filters, function($value) {
                return $value !== '' && $value !== null && $value !== [];
            }));
            
            if ($query_string) {
                redirect("test/displayData?" . $query_string);
            } else {
                redirect('test/displayData');
            }
            return;
        }
        
        // ✅ If GET request, get filters from URL
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
        
        // Handle pagination
        $pagination_data = $this->_handle_pagination($filters);
        
        // Pass data to view - FIXED: Added total_count
        $data = [
            'filters' => $filters,
            'current_filters' => [
                'filter_country' => $this->input->get('filter_country'),
                'filter_status' => $this->input->get('filter_status'),
                'search_text' => $this->input->get('search_text'),
                'filter_id' => $this->input->get('filter_id'),
                'filter_gender' => $this->input->get('filter_gender'),
                'filter_age' => $this->input->get('filter_age'),
                'filter_phone' => $this->input->get('filter_phone'),
                'membership_from' => $this->input->get('membership_from'),
                'membership_to' => $this->input->get('membership_to'),
                'filter_access_level' => $this->input->get('filter_access_level'),
                'product_interest' => $this->input->get('product_interest') ?? [],
            ],
            'total_count' => $pagination_data['total_customers'], // ✅ Added this line
        ];
        
        // Merge pagination data
        $data = array_merge($data, $pagination_data);
        
        $this->load->view('customer_lists', $data);
    }
    
    private function _handle_pagination($filters) {
        $per_page = 10;
        $page = $this->input->get('page') ?: 1;
        $offset = ($page - 1) * $per_page;
        
        $customers = $this->Customer_data_model->get_filtered_customers($filters, $per_page, $offset);
        $total_count = $this->Customer_data_model->get_filtered_count($filters);
        
        $has_filters = !empty(array_filter($filters));
        $show_pagination = $total_count > $per_page;
        
        return [
            'customers' => $customers,
            'total_customers' => $total_count, // ✅ This is $total_count
            'current_page' => $page,
            'per_page' => $per_page,
            'total_pages' => ceil($total_count / $per_page),
            'has_filters' => $has_filters,
            'show_pagination' => $show_pagination
        ];
    }
    
    // ... rest of your Test controller methods ...
    // Add these methods to your Test controller (application/controllers/Test.php)

public function import_csv() {
    if (!$this->input->is_ajax_request()) {
        show_404();
    }
    
    $this->load->library('upload');
    
    // Upload config
    $config['upload_path'] = './uploads/csv/';
    $config['allowed_types'] = 'csv';
    $config['max_size'] = 2048; // 2MB
    $config['encrypt_name'] = TRUE;
    
    if (!is_dir($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, TRUE);
    }
    
    $this->upload->initialize($config);
    
    if (!$this->upload->do_upload('csv_file')) {
        echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        return;
    }
    
    $upload_data = $this->upload->data();
    $csv_file = fopen($upload_data['full_path'], 'r');
    
    // Skip header row
    $header = fgetcsv($csv_file);
    
    $batch_data = [];
    $inserted = 0;
    $skipped = 0;
    
    while (($row = fgetcsv($csv_file)) !== FALSE) {
        if (count($row) < 4) continue; // Skip incomplete rows
        
        $customer_data = [
            'first_name' => trim($row[0]),
            'last_name' => trim($row[1]),
            'email' => trim($row[2]),
            'phone' => trim($row[3]),
            'age' => isset($row[4]) ? (int)$row[4] : NULL,
            'membership_from' => isset($row[5]) ? $row[5] : date('Y-m-d'),
            'membership_to' => isset($row[6]) ? $row[6] : date('Y-m-d', strtotime('+1 year')),
            'country_id' => isset($row[7]) ? (int)$row[7] : NULL,
            'access_level' => isset($row[8]) ? $row[8] : NULL,
            'account_status' => isset($row[9]) ? $row[9] : 'active',
            'gender' => isset($row[10]) ? $row[10] : NULL,
            'product_interest' => isset($row[11]) ? $row[11] : NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Validate required fields
        if (empty($customer_data['first_name']) || empty($customer_data['last_name']) || 
            empty($customer_data['email']) || empty($customer_data['phone'])) {
            $skipped++;
            continue;
        }
        
        $batch_data[] = $customer_data;
        
        // Insert in batches of 100
        if (count($batch_data) >= 100) {
            $this->Customer_data_model->insert_batch_customers($batch_data);
            $inserted += count($batch_data);
            $batch_data = [];
        }
    }
    
    // Insert remaining records
    if (!empty($batch_data)) {
        $this->Customer_data_model->insert_batch_customers($batch_data);
        $inserted += count($batch_data);
    }
    
    fclose($csv_file);
    unlink($upload_data['full_path']); // Clean up
    
    echo json_encode([
        'status' => 'success', 
        'message' => "Inserted: $inserted, Skipped: $skipped"
    ]);
}

public function export_csv() {
    $this->load->dbutil();
    
    // Get current filters from GET parameters (same as displayData)
    $filters = [
        'country_id' => $this->input->get('filter_country'),
        'account_status' => $this->input->get('filter_status'),
        'search_text' => $this->input->get('search_text'),
        'id' => $this->input->get('filter_id'),
        'gender' => $this->input->get('filter_gender'),
        'age' => $this->input->get('filter_age'),
        'phone' => $this->input->get('filter_phone'),
        'membership_from' => $this->input->get('membership_from'),
        'membership_to' => $this->input->get('membership_to'),
        'access_level' => $this->input->get('filter_access_level'),
    ];
    
    // Get ALL filtered data (no pagination limit)
    $all_customers = $this->Customer_data_model->get_filtered_customers($filters, 0, 0, TRUE);
    
    // Create CSV from query result
    $delimiter = ',';
    $newline = "\r\n";
    $enclosure = '"';
    
    $csv_content = $this->dbutil->csv_from_result($all_customers, $delimiter, $newline, $enclosure);
    
    // Set headers for CSV download
    $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
    $this->output
         ->set_content_type('text/csv')
         ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
         ->set_header('Cache-Control: max-age=0')
         ->set_header('Pragma: public')
         ->_display($csv_content);
}

}
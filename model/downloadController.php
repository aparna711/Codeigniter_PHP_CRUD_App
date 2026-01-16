<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_data_model');
        $this->load->helper('download');
        $this->load->library('pdf');
    }
    
    // Download CSV
    public function download_csv() {
        // Get filters from POST/GET
        //$filters = $this->input->get();
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
        
        
        // Get all data without pagination
        // $this->load->model('Customer_data_model');
        

        // Get all filtered data
        $customers = $this->Customer_data_model->get_all_filtered_customers($filters);


        
        
        // Set CSV headers
        $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Create output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        
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
    
    // Download PDF
    public function download_pdf() {
        // You need to install TCPDF or DomPDF first
        echo "PDF download not implemented yet. Install a PDF library first.";
        // Get filters from POST/GET
        $filters = $this->input->get();
        
        // Get all data without pagination
        $customers = $this->Customer_data_model->get_all_filtered_customers($filters);
        
        // Create PDF
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->filename = 'customers_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Generate HTML content
        $html = $this->generate_pdf_html($customers, $filters);
        
        // Load PDF library and generate
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream($this->pdf->filename, array("Attachment" => true));
    }
    
    // Helper method to get country name
    private function get_country_name($country_id) {
        $countries = [
            1 => 'USA',
            2 => 'Canada',
            3 => 'UK'
        ];
        return isset($countries[$country_id]) ? $countries[$country_id] : 'Unknown';
    }
    
    // Generate PDF HTML content
    private function generate_pdf_html($customers, $filters) {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Customer Report</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 10px; }
                .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                .header h1 { margin: 0; color: #333; }
                .header p { margin: 5px 0; color: #666; }
                .filter-info { margin-bottom: 15px; background: #f5f5f5; padding: 10px; border-radius: 5px; }
                .filter-info strong { color: #333; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th { background-color: #4CAF50; color: white; padding: 8px; text-align: left; border: 1px solid #ddd; }
                td { padding: 6px; text-align: left; border: 1px solid #ddd; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .total-row { background-color: #e8f5e9 !important; font-weight: bold; }
                .footer { margin-top: 30px; text-align: center; color: #666; font-size: 9px; border-top: 1px solid #ddd; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Customer Report</h1>
                <p>Generated on: ' . date('F j, Y, g:i a') . '</p>
                <p>Total Records: ' . count($customers) . '</p>
            </div>';
        
        // Add filter information
        $filter_text = [];
        if (!empty($filters['search_text'])) {
            $filter_text[] = 'Search: ' . htmlspecialchars($filters['search_text']);
        }
        if (!empty($filters['country_id'])) {
            $filter_text[] = 'Country: ' . $this->get_country_name($filters['country_id']);
        }
        if (!empty($filters['account_status'])) {
            $filter_text[] = 'Status: ' . htmlspecialchars($filters['account_status']);
        }
        
        if (!empty($filter_text)) {
            $html .= '<div class="filter-info"><strong>Applied Filters:</strong> ' . implode(' | ', $filter_text) . '</div>';
        }
        
        // Table
        $html .= '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Country</th>
                    <th>Access Level</th>
                    <th>Status</th>
                    <th>Membership Period</th>
                    <th>Interests</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($customers as $customer) {
            $html .= '<tr>
                <td>' . $customer->id . '</td>
                <td>' . htmlspecialchars($customer->first_name . ' ' . $customer->last_name) . '</td>
                <td>' . htmlspecialchars($customer->email) . '</td>
                <td>' . htmlspecialchars($customer->phone) . '</td>
                <td>' . $customer->age . '</td>
                <td>' . $customer->gender . '</td>
                <td>' . $this->get_country_name($customer->country_id) . '</td>
                <td>' . ucfirst($customer->access_level) . '</td>
                <td>' . $customer->account_status . '</td>
                <td>' . date('M d, Y', strtotime($customer->membership_from)) . ' to ' . date('M d, Y', strtotime($customer->membership_to)) . '</td>
                <td>' . htmlspecialchars($customer->product_interest) . '</td>
            </tr>';
        }
        
        // Summary row
        $html .= '<tr class="total-row">
            <td colspan="11">Total Customers: ' . count($customers) . '</td>
        </tr>';
        
        $html .= '</tbody>
        </table>
        
        <div class="footer">
            <p>Report generated by Customer Management System</p>
            <p>Page generated at: ' . date('Y-m-d H:i:s') . '</p>
        </div>
        </body>
        </html>';
        
        return $html;
    }
}
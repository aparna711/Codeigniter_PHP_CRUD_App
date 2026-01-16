
<?php
class Customer_data_model extends CI_Model {

    // Constructor is optional but good practice for setup
    public function __construct() {
        parent::__construct();
        // Load the database library for use in this Model
        $this->load->database();
    }

    // This method will contain the database logic for inserting a customer
    public function insert_customer($data_array) {
        // The method from your example code moves here, using $this->db->insert()
        $result = $this->db->insert('customers', $data_array);
        return $result;
    }
    
        public function insert_batch_customers($data) {
            return $this->db->insert_batch('customers', $data);
        }


    // Retrieve a single customer record by ID
    public function get_customer($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('customers'); // **NOTE: Replace 'customers' with your actual table name**
        return $query->row(); 
    }

    // Update the customer record
    public function update_customer($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('customers', $data);
        return $this->db->affected_rows() > 0;
    }


    
    // Function to delete a customer by ID
    public function delete($customer_id) {
        $this->db->where('id', $customer_id); // Specify the condition (WHERE id = $customer_id)
        $this->db->delete('customers');       // Execute the DELETE query on the 'customers' table

        // Check if a row was affected (i.e., if the deletion was successful)
        return $this->db->affected_rows() > 0;
    }



// ✅ CORRECT: Private helper method in Model
// private function _apply_filters($filters) {
//     if (!empty($filters['country_id'])) {
//         $this->db->where('country_id', $filters['country_id']);
//     }
//     if (!empty($filters['account_status'])) {
//         $this->db->where('account_status', $filters['account_status']);
//     }
//     if (!empty($filters['search_text'])) {
//         $search = $filters['search_text'];
//         $this->db->group_start()
//                  ->like('first_name', $search)
//                  ->or_like('last_name', $search)
//                  ->or_like('email', $search)
//                  ->group_end();
//     }
// }
private function _apply_filters($filters) {
    // Country filter
    if (!empty($filters['country_id'])) {
        $this->db->where('country_id', $filters['country_id']);
    }
    
    // Status filter
    if (!empty($filters['account_status'])) {
        $this->db->where('account_status', $filters['account_status']);
    }
    
    // ID filter (exact match)
    if (!empty($filters['id'])) {
        $this->db->where('id', $filters['id']);
    }
    
    // Gender filter
    if (!empty($filters['gender']) && $filters['gender'] !== '') {
        $this->db->where('gender', $filters['gender']);
    }
    
    // Age filter (exact match)
    if (!empty($filters['age'])) {
        $this->db->where('age', $filters['age']);
    }
    
    // Phone filter
    if (!empty($filters['filter_phone'])) {
        $this->db->where('phone', $filters['filter_phone']);
    }
    
    // Access Level filter
    if (!empty($filters['access_level'])) {
        $this->db->where('access_level', $filters['access_level']);
    }
    
    // Membership date range
    if (!empty($filters['membership_from'])) {
        $this->db->where('membership_from >=', $filters['membership_from']);
    }
    if (!empty($filters['membership_to'])) {
        $this->db->where('membership_to <=', $filters['membership_to']);
    }
    
    // // Search text (name/email - keep existing)
    // if (!empty($filters['search_text'])) {
    //     $search = $filters['search_text'];
    //     $this->db->group_start()
    //              ->like('first_name', $search)
    //              ->or_like('last_name', $search)
    //              ->or_like('email', $search)
    //              ->group_end();
    // }

            // Search text (name/email - case-insensitive "starts with")
        if (!empty($filters['search_text'])) {
            $search = $filters['search_text'];
            
            // Remove any whitespace and prepare for search
            $search = trim($search);
            
            // Using LOWER() on both column and search term for case-insensitive matching
            // Adding % only at the end for "starts with" behavior
            $searchTerm = strtolower($search) . '%';
            
            $this->db->group_start()
                     ->where("LOWER(first_name) LIKE", $searchTerm)
                     ->or_where("LOWER(last_name) LIKE", $searchTerm)
                     ->or_where("LOWER(email) LIKE", $searchTerm)
                     ->group_end();
        } 
    
    // Product Interest filter (array handling)
    // if (!empty($filters['product_interest']) && is_array($filters['product_interest'])) {
    //     $this->db->where_in('product_interest', $filters['product_interest']);
    // }

    if (!empty($filters['product_interest']) && is_array($filters['product_interest'])) {
    $this->db->group_start();
    foreach ($filters['product_interest'] as $pi) {
        $this->db->like('product_interest', $pi);
    }
    $this->db->group_end();
}

}
//**********************************************************************************
// ✅ Usage in main methods
// public function get__filtered_customers($filters, $per_page = 10, $offset = 0) {
//     $this->db->select('*')->from('customers');
//     $this->_apply_filters($filters);  // ✅ Correct call
//     $this->db->order_by('id', 'DESC')
//              ->limit($per_page, $offset);
//     return $this->db->get()->result();
// }
// public function get_filtered_count($filters) {
//     $this->db->from('customers');
//     $this->_apply_filters($filters);  // ✅ Correct call
//     return $this->db->count_all_results();
// }

//**********************************************************************************

// public function get_filtered_customers($filters = [], $per_page = 10, $offset = 0) {
//     $this->db->select('*');
//     $this->db->from('customers');
    
//     // Apply all your existing filters
//     if (!empty($filters['search_text'])) {
//         $this->db->group_start();
//         $this->db->like('first_name', $filters['search_text']);
//         $this->db->or_like('last_name', $filters['search_text']);
//         $this->db->or_like('email', $filters['search_text']);
//         $this->db->or_like('phone', $filters['search_text']);
//         $this->db->group_end();
//     }
    
//     if (!empty($filters['country_id'])) {
//         $this->db->where('country_id', $filters['country_id']);
//     }
    
//     if (!empty($filters['account_status'])) {
//         $this->db->where('account_status', $filters['account_status']);
//     }
    
//     if (!empty($filters['gender'])) {
//         $this->db->where('gender', $filters['gender']);
//     }
    
//     if (!empty($filters['age'])) {
//         $this->db->where('age', $filters['age']);
//     }
    
//     if (!empty($filters['phone'])) {
//         $this->db->like('phone', $filters['phone']);
//     }
    
//     if (!empty($filters['membership_from'])) {
//         $this->db->where('membership_from >=', $filters['membership_from']);
//     }
    
//     if (!empty($filters['membership_to'])) {
//         $this->db->where('membership_to <=', $filters['membership_to']);
//     }
    
//     if (!empty($filters['access_level'])) {
//         $this->db->where('access_level', $filters['access_level']);
//     }
    
//     // **KEY FIX**: $per_page = 0 means get ALL records
//     if ($per_page > 0) {
//         $this->db->limit($per_page, $offset);
//     }
    
//     return $this->db->get()->result();
// }

public function get_filtered_customers($filters = [], $per_page = 10, $offset = 0) {
    $this->db->select('*');
    $this->db->from('customers');
    
    // ✅ Use your existing _apply_filters helper
    $this->_apply_filters($filters);
   $this->db->order_by('id', 'DESC');
    
    if ($per_page > 0) {
        $this->db->limit($per_page, $offset);
    }
    
    return $this->db->get()->result();
}

public function get_filtered_count($filters) {
    $this->db->from('customers');
    $this->_apply_filters($filters);
    return $this->db->count_all_results();
}
// ✅ NEW: Returns QUERY OBJECT for CSV export (no limit)
public function get_csv_all_customers($filters) {
    $this->db->select('*');
    $this->db->from('customers');
    
    // Apply ALL your existing filters using _apply_filters
    $this->_apply_filters($filters);
    
    //$this->db->order_by('id', 'DESC');
    
    // ✅ RETURN QUERY OBJECT (NOT result())
    return $this->db->get();
}


// In Customer_data_model.php
// public function get_all_filtered_customers($filters) {
//     $this->db->select('*')->from('customers');
//     $this->_apply_filters($filters);
//     $this->db->order_by('id', 'DESC');
//     return $this->db->get()->result();
// }

    // public function get_filtered_customers($filters) {
        
    //     $this->db->select('*');
    //     $this->db->from('customers');
        
    //     if (!empty($filters['country_id'])) {
    //         $this->db->where('country_id', $filters['country_id']);
    //     }

    //     if (!empty($filters['account_status'])) {
    //         $this->db->where('account_status', $filters['account_status']);
    //     }
        
    //     if (!empty($filters['search_text'])) {
    //         $search = $filters['search_text'];
    //         $this->db->group_start();
    //         $this->db->like('first_name', $search);
    //         $this->db->or_like('last_name', $search);
    //         $this->db->or_like('email', $search);
    //         $this->db->group_end();
    //     }
        
    //     $this->db->order_by('id', 'DESC');

    //     $query = $this->db->get();
    //     return $query->result(); 
    // }


    // You would add other methods here, e.g., get_customer(), update_customer(), etc.
}
// End of file application/models/Customer_data_model.php
?>
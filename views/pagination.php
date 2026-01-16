<!-- //pagination.php -->
 public function displayData() {
    $this->load->model('Customer_data_model');
    
    // Get filters (POST first, then URI segments)
    $filters = [
        'country_id'     => $this->input->post('filter_country') ?: $this->uri->segment(4),
        'account_status' => $this->input->post('filter_status') ?: $this->uri->segment(5),
        'search_text'    => $this->input->post('search_text') ?: $this->uri->segment(6)
    ];
    
    // ✅ Universal pagination function handles everything
    $pagination_data = $this->_handle_pagination($filters);
    
    $data = array_merge($pagination_data, [
        'current_filters' => $filters
    ]);
    
    $this->load->view('filtering', $data);
}

private function _handle_pagination($filters) {
    $per_page = 10;
    $page = $this->uri->segment(3) ?: 1;
    $offset = ($page - 1) * $per_page;
    
    // Always get data (handles both filtered/unfiltered)
    $customers = $this->Customer_data_model->get_filtered_customers($filters, $per_page, $offset);
    $total_count = $this->Customer_data_model->get_filtered_count($filters);
    
    $has_filters = !empty(array_filter($filters));
    $show_pagination = $total_count > $per_page; // Always show if > 1 page
    
    $pagination_links = '';
    if ($show_pagination) {
        $this->load->library('pagination');
        $config = [
            'base_url' => base_url('index.php/test/displayData'),
            'total_rows' => $total_count,
            'per_page' => $per_page,
            'uri_segment' => 3,
            'num_links' => 5,
            'use_page_numbers' => true,
            'full_tag_open' => '<div class="pagination">',
            'full_tag_close' => '</div>',
            'first_link' => 'First',
            'last_link' => 'Last',
            'next_link' => 'Next →',
            'prev_link' => '← Prev',
            'cur_tag_open' => '<span class="active">',
            'cur_tag_close' => '</span>',
            'num_tag_open' => '<a>',
            'num_tag_close' => '</a>'
        ];
        $this->pagination->initialize($config);
        $pagination_links = $this->pagination->create_links();
    }
    
    return [
        'customers' => $customers,
        'total_customers' => $total_count,
        'current_page' => $page,
        'per_page' => $per_page,
        'total_pages' => ceil($total_count / $per_page),
        'has_filters' => $has_filters,
        'show_pagination' => $show_pagination,
        'pagination_links' => $pagination_links
    ];
}





    <?php if ($total_customers > $per_page): ?>
<div class="pagination-container">
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="<?php echo base_url('index.php/test/displayData/'.($current_page-1)); ?>">← Prev</a>
        <?php endif; ?>

        <?php 
        $start = max(1, $current_page - 2);
        $end = min($total_pages, $current_page + 2);
        
        if ($start > 1): ?>
            <a href="<?php echo base_url('index.php/test/displayData/1'); ?>">1</a>
            <?php if ($start > 2): ?>
                <span>...</span>
            <?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i == $current_page): ?>
                <span class="active"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="<?php echo base_url('index.php/test/displayData/'.$i); ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?>
                <span>...</span>
            <?php endif; ?>
            <a href="<?php echo base_url('index.php/test/displayData/'.$total_pages); ?>"><?php echo $total_pages; ?></a>
        <?php endif; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="<?php echo base_url('index.php/test/displayData/'.($current_page+1)); ?>">Next →</a>
        <?php endif; ?>
    </div>
    
    <div class="pagination-info">
        Showing <?php echo (($current_page-1)*$per_page)+1; ?> to 
        <?php echo min($current_page*$per_page, $total_customers); ?> of 
        <?php echo $total_customers; ?> customers (Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>)
    </div>
</div>
<?php endif; 
</div> 
    <div class="filter-group" style="flex-basis: 180px; display: flex; flex-direction: column; gap: 8px;">
                <!-- Download CSV Button -->
                <a href="<?php echo site_url('customer/download_csv?' . http_build_query($current_filters)); ?>" 
                   class="btn-apply" 
                   onclick="return confirm('Download ' + <?php echo $total_count; ?> + ' records as CSV?')">
                    <i class="fas fa-file-csv"></i> Download data in CSV file
                </a>
                
                <!-- Download PDF Button -->
                <a href="<?php echo site_url('customer/download_pdf?' . http_build_query($current_filters)); ?>" 
                   class="btn-reset" 
                   onclick="return confirm('Download ' + <?php echo $total_count; ?> + ' records as PDF?')">
                    <i class="fas fa-file-pdf"></i> Download data in PDF
                </a>
    </div>



     <div class="filter-group" >
                <!-- Download CSV Button -->
                <a href="<?php echo site_url('index.php/customercontroller/download_csv?' . http_build_query($current_filters)); ?>" 
                   class="btn-apply" 
                   onclick="return confirm('Download ' + <?php echo $total_count; ?> + ' records as CSV?')">
                    <i class="fas fa-file-csv"></i> Download data in CSV file
                </a>
                
                <!-- Download PDF Button -->
                <a href="<?php echo site_url('index.php/customercontroller/download_pdf?' . http_build_query($current_filters)); ?>" 
                   class="btn-reset" 
                   onclick="return confirm('Download ' + <?php echo $total_count; ?> + ' records as PDF?')">
                    <i class="fas fa-file-pdf"></i> Download data in PDF
                </a>
        </div>

<div class="filter-group">
        <!-- Download CSV Button -->
        <a href="<?php echo site_url('customercontroller/download_csv?' . http_build_query($current_filters)); ?>" 
           class="btn-apply" 
           onclick="return confirm('Download <?php echo $total_count; ?> records as CSV?')">
            <i class="fas fa-file-csv"></i> Download data in CSV file
        </a>
    </div>

    <div style="background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px;">
        Total Records Found: <strong><?php echo $total_count; ?></strong> |
        Total Pages: <strong><?php echo isset($total_pages) ? $total_pages : 0; ?></strong>
    </div>



































    <?php
// At the top of your view, ensure variables exist
$total_count = isset($total_count) ? $total_count : 0;
$current_filters = isset($current_filters) ? $current_filters : [];

// Generate query string safely
$query_string = http_build_query(array_filter($current_filters, function($value) {
    if (is_array($value)) {
        return !empty($value);
    }
    return $value !== '' && $value !== null;
}));
?>

<div class="filter-group">
    <?php if ($total_count > 0): ?>
        <!-- CSV Download -->
        <a href="<?php echo site_url('index.php/testdownload/download_csv?' . $query_string); ?>" 
           class="btn-apply" 
           onclick="return confirm('Download <?php echo $total_count; ?> records as CSV?')">
            <i class="fas fa-file-csv"></i> Download CSV (<?php echo $total_count; ?> records)
        </a>
        
        <!-- PDF Download (Coming Soon) -->
        <button class="btn-reset" onclick="alert('PDF download coming soon!')">
            <i class="fas fa-file-pdf"></i> Download PDF (Coming Soon)
        </button>
    <?php else: ?>
        <button class="btn-apply" disabled title="No records to download">
            <i class="fas fa-file-csv"></i> No records to download
        </button>
    <?php endif; ?>
</div>
<div class="filter-group">
    <!-- Download CSV -->
    <a href="<?php echo site_url('index.php/testdownload/download_csv?' . http_build_query($current_filters)); ?>" 
       class="btn-apply" 
       onclick="return confirmDownload('CSV')">
        <i class="fas fa-file-csv"></i> Download data in CSV file
    </a>
    
    <!-- Download PDF (Temporarily disabled or shows message) -->
    <a href="javascript:void(0);" 
       class="btn-reset" 
       onclick="alert('PDF download feature coming soon!\\nTotal records: <?php echo $total_count; ?>')">
        <i class="fas fa-file-pdf"></i> Download data in PDF
    </a>
</div>


<?php
// At the top of your view, ensure variables exist
$total_count = isset($total_count) ? $total_count : 0;
$current_filters = isset($current_filters) ? $current_filters : [];

// Generate query string safely
$query_string = http_build_query(array_filter($current_filters, function($value) {
    if (is_array($value)) {
        return !empty($value);
    }
    return $value !== '' && $value !== null;
}));
?>

<div class="filter-group">
    <?php if ($total_count > 0): ?>
        <!-- CSV Download -->
        <a href="<?php echo site_url('customercontroller/download_csv?' . $query_string); ?>" 
           class="btn-apply" 
           onclick="return confirm('Download <?php echo $total_count; ?> records as CSV?')">
            <i class="fas fa-file-csv"></i> Download CSV (<?php echo $total_count; ?> records)
        </a>
        
        <!-- PDF Download (Coming Soon) -->
        <button class="btn-reset" onclick="alert('PDF download coming soon!')">
            <i class="fas fa-file-pdf"></i> Download PDF (Coming Soon)
        </button>
    <?php else: ?>
        <button class="btn-apply" disabled title="No records to download">
            <i class="fas fa-file-csv"></i> No records to download
        </button>
    <?php endif; ?>
</div>

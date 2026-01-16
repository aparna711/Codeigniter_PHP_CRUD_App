<?php
// application/views/filtering.php
defined('BASEPATH') OR exit('No direct script access allowed');


$current_gender = $current_filters['gender'] ?? '';
$current_access_level = $current_filters['access_level'] ?? '';
$current_id = $current_filters['id'] ?? '';
$current_age = $current_filters['age'] ?? '';
$current_membership_from = $current_filters['membership_from'] ?? '';
$current_membership_to = $current_filters['membership_to'] ?? '';
$current_country = $current_filters['country_id'] ?? '';
$current_status = $current_filters['account_status'] ?? '';
$current_search = $current_filters['search_text'] ?? '';

// At top of customer_list.php, add:
$current_phone = $current_filters['filter_phone'] ?? '';
$current_product_interest = $current_filters['product_interest'] ?? [];  // Array!
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Data Table</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/newdesign.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/css/delete_pop_up.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     
<!-- Add to <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    setTimeout(function() {
        const flashes = document.querySelectorAll('.flash-message');
        flashes.forEach(flash => {
            flash.style.transition = 'opacity 0.5s ease-out';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        });
    }, 5000);




 function resetFilters() {
    document.getElementById('filterForm').reset();
    window.location.href = "<?php echo base_url('index.php/test/displayData'); ?>";
}


    </script>
</head>
<body>


<div class="container">
    
    <!-- ✅ Flash Messages - MOVED TO TOP -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="flash-message flash-success">
            <span class="icon">✅</span>
            <?php echo $this->session->flashdata('success'); ?>
            <button class="close-btn" onclick="this.parentElement.remove()">×</button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="flash-message flash-error">
            <span class="icon">❌</span>
            <?php echo $this->session->flashdata('error'); ?>
            <button class="close-btn" onclick="this.parentElement.remove()">×</button>
        </div>
    <?php endif; ?>

    <div class="header-section">
        <h2>Customer Records</h2>
        
        <!-- ✅ REGISTER NEW USER BUTTON -->
        <a href="<?php echo base_url('index.php/test/crudApp'); ?>" class="btn-add-new" title="Register New User">
            ➕ Register New User
        </a>
    </div>

    <!-- Filter Form -->
    <form action="<?php echo base_url('index.php/test/displayData'); ?>" method="GET" id="filterForm">
        <div class="filter-controls">
            <div class="filter-group">
                <label for="filter_country">Filter by Country:</label>
                <select id="filter_country" name="filter_country">
                    <option value="">All Countries</option>
                    <option value="1" <?php echo ($current_country == '1' ? 'selected' : ''); ?>>USA</option>
                    <option value="2" <?php echo ($current_country == '2' ? 'selected' : ''); ?>>Canada</option>
                    <option value="3" <?php echo ($current_country == '3' ? 'selected' : ''); ?>>UK</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="filter_status">Filter by Status:</label>
                <select id="filter_status" name="filter_status">
                    <option value="">All Statuses</option>
                    <option value="Active" <?php echo ($current_status == 'Active' ? 'selected' : ''); ?>>Active</option>
                    <option value="Inactive" <?php echo ($current_status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>

            <div class="filter-group" style="flex-grow: 2;">
                <label for="search_text">Search by Name/Email:</label>
                <input type="text" id="search_text" name="search_text" 
                       placeholder="Search..." value="<?php echo html_escape($current_search); ?>">
            </div>
             

             <?php // $this->load->view('includes/newFilters'); ?>
            <div class="filter-group" style="flex-basis: 150px;">
                <button type="submit">Apply Filters</button>
            </div>
        

            <!-- ID Filter -->
                <div class="filter-group">
                    <label for="filter_id">ID:</label>
                    <input type="text" id="filter_id" name="filter_id" 
                           placeholder="Enter ID..." value="<?php echo html_escape($current_id ?? ''); ?>">
        </div>
 <!-- Gender Filter -->
        <div class="filter-group">
            <label>Gender:</label>
            <div class="radio-group">
                <label><input type="radio" name="filter_gender" value="" <?php echo (empty($current_gender) ? 'checked' : ''); ?>> All</label>
                <label><input type="radio" name="filter_gender" value="Male" <?php echo ($current_gender == 'Male' ? 'checked' : ''); ?>> Male</label>
                <label><input type="radio" name="filter_gender" value="Female" <?php echo ($current_gender == 'Female' ? 'checked' : ''); ?>> Female</label>
            </div>
        </div>
  <!-- Age Filter -->
        <div class="filter-group">
            <label for="filter_age">Age:</label>
            <input type="number" id="filter_age" name="filter_age" min="18" max="100"
                   placeholder="e.g., 25" value="<?php echo html_escape($current_age ?? ''); ?>">
        </div>

        <!-- Phone Filter -->
        <div class="filter-group">
            <label for="filter_phone">Phone:</label>
            <input type="tel" id="filter_phone" name="filter_phone" maxlength="15" 
                   placeholder="e.g., 9876543210" value="<?php echo html_escape($current_phone ?? ''); ?>">
        </div>



             <!-- Membership Date Range -->
        <div class="filter-group">
            <label for="membership_from">Membership From:</label>
            <input type="date" id="membership_from" name="membership_from" 
                   value="<?php echo html_escape($current_membership_from ?? ''); ?>">
        </div>
        <div class="filter-group">
            <label for="membership_to">To:</label>
            <input type="date" id="membership_to" name="membership_to" 
                   value="<?php echo html_escape($current_membership_to ?? ''); ?>">
        </div>

        <!-- Level of Access Filter -->
        <div class="filter-group">
            <label for="filter_access_level">Access Level:</label>
            <select id="filter_access_level" name="filter_access_level">
                <option value="">All Levels</option>
                <option value="Admin"    <?php echo ($current_access_level == 'Admin' ? 'selected' : ''); ?>>Admin</option>
                <option value="Employee" <?php echo ($current_access_level == 'Employee' ? 'selected' : ''); ?>>Employee</option>
                <option value="Sales"    <?php echo ($current_access_level == 'Sales' ? 'selected' : ''); ?>>Sales</option>
            </select>
        </div>




        <!-- Product Interest Filter -->
        <div class="filter-group">
            <label>Product Interest:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="product_interest[]" value="Product A" <?php echo (in_array('Product A', $current_product_interest ?? []) ? 'checked' : ''); ?>> Product A </label>
                <label><input type="checkbox" name="product_interest[]" value="Product B" <?php echo (in_array('Product B', $current_product_interest ?? []) ? 'checked' : ''); ?>> Product B </label>
                <label><input type="checkbox" name="product_interest[]" value="Service C" <?php echo (in_array('Service C', $current_product_interest ?? []) ? 'checked' : ''); ?>> Service C</label>
                
            </div>
        </div>
<div class="filter-group" style="flex-basis: 180px; display: flex; flex-direction: column; gap: 8px;">
    <!-- Apply Filters Button -->
    <button type="submit" class="btn-apply">
        <i class="fas fa-filter"></i> Apply Filters
    </button>
    
    <!-- Reset Filters Button -->
    <button type="button" onclick="resetFilters()" class="btn-reset">
        <i class="fas fa-times-circle"></i> Reset
    </button>
</div>


  <!-- Submit Button -->
        <!-- <div class="filter-group" style="flex-basis: 150px;">
            <button type="submit">Apply Filters</button>
            <button type="button" onclick="resetFilters()">Reset</button>
        
        </div> -->
      <!-- Search Filter -->
     <!--    <div class="filter-group" style="flex-grow: 2;">
            <label for="search_text">Search by Name/Email:</label>
            <input type="text" id="search_text" name="search_text" 
                   placeholder="Search..." value="<?php // echo html_escape($current_search); ?>">
        </div> -->
        </div>

    </form> 
    <?php //echo $pagination_data ?>
    <!-- Customer Table -->
    <table class="data-table" id="customerTable">
        <!-- Your existing table header and body code stays SAME -->
        <thead>
            <tr>
                <th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Age</th>
                <th>Status</th><th>Country</th><th>Access Level</th><th>Gender</th>
                <th>Product Interests</th><th>From Date</th><th>To Date</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($customers)): ?>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer->id; ?></td>
                        <td><?php echo $customer->first_name . ' ' . $customer->last_name; ?></td>
                        <td><?php echo $customer->email; ?></td>
                        <td><?php echo $customer->phone; ?></td>
                        <td><?php echo $customer->age; ?></td>
                        <td><?php echo $customer->account_status; ?></td>
                        <td><?php 
                            echo $customer->country_id == 1 ? 'USA' : 
                                 ($customer->country_id == 2 ? 'Canada' : 'UK');
                        ?></td>
                        <td><?php echo $customer->access_level; ?></td>
                        <td><?php echo $customer->gender; ?></td>
                        <td><?php echo implode(', ', json_decode($customer->product_interest, true) ?: ['None']); ?></td>
                        <td><?php echo $customer->membership_from; ?></td>
                        <td><?php echo $customer->membership_to; ?></td>
                        <td class="action-btns">
                            <a href="<?php echo base_url('index.php/test/edit_customer/' . $customer->id); ?>" class="btn-edit fas fa-edit"><!-- ✏️ --></a>
                           <!--  <a href="<?php echo base_url('index.php/test/delete_customer/' . $customer->id); ?>" 
                               class="btn-delete fas fa-trash" onclick="return confirm('Delete this customer?');"> 🗑️ \ </a>-->



                             <a href="<?php echo base_url('index.php/test/delete_customer/' . $customer->id); ?>"
                             class="btn-delete fas fa-trash" 
                            onclick="showDeleteConfirm(<?php echo $customer->id; ?>, '<?php echo htmlspecialchars($customer->first_name); ?>'); return false;"></a>
                             <!-- <a href="#" 
                                class="btn-delete fas fa-trash" 
                                title="Delete"
                                onclick="showDeleteConfirm(<?php //echo (int)$customer->id; ?>, '<?php //echo htmlspecialchars($customer->first_name . ' ' . $customer->last_name, ENT_QUOTES, 'UTF-8'); ?>'); return false;">
                                </a> -->
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="13" class="text-center">No customers found matching criteria.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
  <!-- ✅ Add this RIGHT BEFORE the pagination container -->

<?php
// Build query string safely
$query = '';
if (!empty($_SERVER['QUERY_STRING'])) {
    $query = '?' . $_SERVER['QUERY_STRING'];
}
?>

<!-- ✅ Pagination (Only shows when needed) -->
<?php if (!empty($show_pagination) && $show_pagination): ?>
<div class="pagination-container">
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="<?php echo base_url('index.php/test/displayData/' . ($current_page - 1)) . $query; ?>">← Prev</a>
        <?php endif; ?>

        <?php
        $start = max(1, $current_page - 2);
        $end   = min($total_pages, $current_page + 2);
        ?>

        <?php if ($start > 1): ?>
            <a href="<?php echo base_url('index.php/test/displayData/1') . $query; ?>">1</a>
            <?php if ($start > 2): ?><span>...</span><?php endif; ?>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i == $current_page): ?>
                <span class="active"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="<?php echo base_url('index.php/test/displayData/' . $i) . $query; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?><span>...</span><?php endif; ?>
            <a href="<?php echo base_url('index.php/test/displayData/' . $total_pages) . $query; ?>"><?php echo $total_pages; ?></a>
        <?php endif; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="<?php echo base_url('index.php/test/displayData/' . ($current_page + 1)) . $query; ?>">Next →</a>
        <?php endif; ?>

        <!-- ✅ Filter Badge -->
        <?php if (!empty($has_filters) && $has_filters): ?>
            <div class="filter-applied-banner">
                <span>🔍 Filters Active (<?php echo count(array_filter($current_filters)); ?>)</span>
                <a href="<?php echo base_url('index.php/test/displayData'); ?>" class="clear-btn">Clear Filters</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
        <h3>Delete Customer?</h3>
        <p>Are you sure you want to delete <strong id="customerName">Customer Name</strong>?</p>
        <p class="warning-text">This action cannot be undone.</p>
        <div class="modal-buttons">
            <button id="confirmDeleteBtn" class="delete-btn">
                <i class="fas fa-trash" aria-hidden="true"></i>
                Yes, Delete
            </button>
            <button id="cancelDeleteBtn" class="cancel-btn">
                <i class="fas fa-times" aria-hidden="true"></i>
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
let pendingDeleteId = null;

function showDeleteConfirm(customerId, customerName) {
    pendingDeleteId = customerId;
    document.getElementById('customerName').textContent = customerName;
    document.getElementById('deleteModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function confirmDelete() {
    if (pendingDeleteId !== null) {
        window.location.href = "<?php echo base_url('index.php/test/delete_customer/'); ?>" + pendingDeleteId;
    }
}

function cancelDelete() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    pendingDeleteId = null;
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    
    if (confirmBtn) confirmBtn.addEventListener('click', confirmDelete);
    if (cancelBtn) cancelBtn.addEventListener('click', cancelDelete);
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            cancelDelete();
        }
    });
    
    // Close on outside click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cancelDelete();
            }
        });
    }
});
</script>






</body>
</html>
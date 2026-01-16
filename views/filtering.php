<?php
// application/views/filtering.php
defined('BASEPATH') OR exit('No direct script access allowed');

$current_country = $current_filters['country_id'] ?? '';
$current_status = $current_filters['account_status'] ?? '';
$current_search = $current_filters['search_text'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Data Table</title>
    <link rel="stylesheet" type="text/css"
     href="<?php echo base_url('assets/css/displayData.css')?>" ></link>
<script>
setTimeout(function() {
    const flashes = document.querySelectorAll('.flash-message');
    flashes.forEach(flash => {
        flash.style.transition = 'opacity 0.5s ease-out';
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 500);
    });
}, 5000); // Auto-dismiss after 5 seconds
</script>

    
</head>
<body>
<div class="container">
  
    <h2>Customer Records</h2>
    <!-- <form action="<?php //echo base_url('index.php/test/displayData'); ?>" method="GET" id="filterForm"> -->
<form action="<?php echo base_url('index.php/test/displayData'); ?>" method="GET" id="filterForm">
<div class="filter-controls">
    
    <!-- 1. ID Filter (NEW) -->
    <div class="filter-group">
        <label for="filter_id">Customer ID:</label>
        <input type="number" id="filter_id" name="filter_id" min="1" 
               placeholder="ID" value="<?php echo $current_id ?? ''; ?>" style="width: 80px;">
    </div>

    <!-- 2. Country Filter -->
    <div class="filter-group">
        <label for="filter_country">Country:</label>
        <select id="filter_country" name="filter_country">
            <option value="">All Countries</option>
            <option value="1" <?php echo ($current_country == '1' ? 'selected' : ''); ?>>USA</option>
            <option value="2" <?php echo ($current_country == '2' ? 'selected' : ''); ?>>Canada</option>
            <option value="3" <?php echo ($current_country == '3' ? 'selected' : ''); ?>>UK</option>
        </select>
    </div>

    <!-- 3. Account Status Filter -->
    <div class="filter-group">
        <label for="filter_status">Status:</label>
        <select id="filter_status" name="filter_status">
            <option value="">All Statuses</option>
            <option value="Active" <?php echo ($current_status == 'Active' ? 'selected' : ''); ?>>Active</option>
            <option value="Inactive" <?php echo ($current_status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
    </div>

    <!-- 4. Access Level Filter -->
    <div class="filter-group">
        <label for="filter_access">Access Level:</label>
        <select id="filter_access" name="filter_access">
            <option value="">All Levels</option>
            <option value="admin" <?php echo ($current_access == 'admin' ? 'selected' : ''); ?>>Admin</option>
            <option value="employee" <?php echo ($current_access == 'employee' ? 'selected' : ''); ?>>Employee</option>
            <option value="sales" <?php echo ($current_access == 'sales' ? 'selected' : ''); ?>>Sales</option>
        </select>
    </div>

    <!-- 5. Gender Filter -->
    <div class="filter-group">
        <label for="filter_gender">Gender:</label>
        <select id="filter_gender" name="filter_gender">
            <option value="">All Genders</option>
            <option value="Male" <?php echo ($current_gender == 'Male' ? 'selected' : ''); ?>>Male</option>
            <option value="Female" <?php echo ($current_gender == 'Female' ? 'selected' : ''); ?>>Female</option>
        </select>
    </div>

    <!-- 6. Age Range Filter -->
    <div class="filter-group" style="flex-direction: row; gap: 5px; align-items: end;">
        <div>
            <label for="filter_age_min">Age:</label>
            <input type="number" id="filter_age_min" name="filter_age_min" min="18" max="65" 
                   placeholder="Min" value="<?php echo $current_age_min ?? ''; ?>" style="width: 55px;">
        </div>
        <span style="font-weight: bold;">-</span>
        <div>
            <label for="filter_age_max" style="visibility: hidden;">Max</label>
            <input type="number" id="filter_age_max" name="filter_age_max" min="18" max="65" 
                   placeholder="Max" value="<?php echo $current_age_max ?? ''; ?>" style="width: 55px;">
        </div>
    </div>

    <!-- 7. Membership From Date -->
    <div class="filter-group">
        <label for="filter_from_date">From Date:</label>
        <input type="date" id="filter_from_date" name="filter_from_date" 
               value="<?php echo $current_from_date ?? ''; ?>">
    </div>

    <!-- 8. Membership To Date -->
    <div class="filter-group">
        <label for="filter_to_date">To Date:</label>
        <input type="date" id="filter_to_date" name="filter_to_date" 
               value="<?php echo $current_to_date ?? ''; ?>">
    </div>

    <!-- 9. Phone Number Filter -->
    <div class="filter-group">
        <label for="filter_phone">Phone:</label>
        <input type="tel" id="filter_phone" name="filter_phone" maxlength="10" 
               placeholder="e.g., 9876543210" value="<?php echo html_escape($current_phone ?? ''); ?>">
    </div>

    <!-- 10. Product Interest Filter (NEW - Multi-select) -->
    <div class="filter-group">
        <label>Products:</label>
        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 14px;">
            <label><input type="checkbox" name="product_interest[]" value="Product A" 
                          <?php echo (in_array('Product A', $current_products ?? []) ? 'checked' : ''); ?>> Product A</label>
            <label><input type="checkbox" name="product_interest[]" value="Product B" 
                          <?php echo (in_array('Product B', $current_products ?? []) ? 'checked' : ''); ?>> Product B</label>
            <label><input type="checkbox" name="product_interest[]" value="Service C" 
                          <?php echo (in_array('Service C', $current_products ?? []) ? 'checked' : ''); ?>> Service C</label>
        </div>
    </div>

    <!-- 11. Search by Name/Email -->
    <div class="filter-group" style="flex-grow: 2;">
        <label for="search_text">Name/Email:</label>
        <input type="text" id="search_text" name="search_text" 
               placeholder="Search..." value="<?php echo html_escape($current_search ?? ''); ?>">
    </div>

    <!-- 12. Buttons -->
    <div class="filter-group" style="flex-basis: 180px; display: flex; flex-direction: column; gap: 8px;">
        <a href="<?php echo base_url('index.php/test/displayData'); ?>" class="btn-reset">Reset</a>
        <button type="submit" class="btn-apply">Apply Filters</button>
    </div>

</div>
</form>

    </form>
    
    <table class="data-table" id="customerTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Status</th>
                <th>Country ID</th>
                <th>Access Level</th>
                <th>Gender</th>
                <th>Product Interests</th>
                 <th>Membership (From Date)</th>
                <th>Membership (To Date)</th>
                <th><span class="action-label">Actions</span></th>
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
                        <td><?php if($customer->country_id == 1){
                            echo "   USA";
                        }  else if($customer->country_id == 2){
                            echo "   Canada";
                        }
                        else{ echo "   UK";}?>
                            
                        </td>
                        <td><?php echo $customer->access_level; ?></td>
                        <td><?php echo $customer->gender; ?></td>
                      <td><?php echo implode(', ', json_decode($customer->product_interest, true) ?: ['None']); ?></td>

                        <td><?php echo $customer->membership_from; ?></td>
                        <td><?php echo $customer->membership_to; ?></td>
                        
                        <td class="action-btns" style="width: 170px;">
                            <a href="<?php echo base_url('/index.php/test/edit_customer/' . $customer->id); ?>" class="btn-edit" title="Edit">
                                ✏️ Edit
                            </a>
                            
                            <a href="<?php echo base_url('/index.php/test/delete_customer/' . $customer->id); ?>" class="btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this customer?');" title="Delete">
                                🗑️ Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No customer data found matching the criteria.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
 

<?php if ($show_pagination): ?>
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
        <?php echo $total_customers; ?> customers 
        (Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>)
    </div>
</div>
<?php endif; ?>

<?php if ($has_filters): ?>
    <div class="filter-badge">
        Filters Applied (<?php echo count(array_filter($current_filters)); ?>)
    </div>
<?php endif; ?>

<!-- Flash Messages - ADD THIS -->
<div class="flash-messages">
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
</div>


</body>
</html>



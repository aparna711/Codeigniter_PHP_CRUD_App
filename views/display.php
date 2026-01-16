<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Make sure these keys match your GET parameter names
$current_gender           = $current_filters['filter_gender']        ?? '';
$current_access_level     = $current_filters['filter_access_level']  ?? '';
$current_id               = $current_filters['filter_id']            ?? '';
$current_age              = $current_filters['filter_age']           ?? '';
$current_membership_from  = $current_filters['membership_from']      ?? '';
$current_membership_to    = $current_filters['membership_to']        ?? '';
$current_country          = $current_filters['filter_country']       ?? '';
$current_status           = $current_filters['filter_status']        ?? '';
$current_search           = $current_filters['search_text']          ?? '';
$current_phone            = $current_filters['filter_phone']         ?? '';
$current_product_interest = $current_filters['product_interest']     ?? []; // must be array

// Ensure total_count is set
$total_count = $total_count ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Data Table</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/newdesign.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/download.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/delete_pop_up.css'); ?>">

    <!-- Font Awesome (single include only) -->
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

    <!-- Flash Messages -->
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

        <!-- Register New User Button -->
        <a href="<?php echo base_url('index.php/test/crudApp'); ?>" class="btn-add-new" title="Register New User">
            ➕ Register New User
        </a>
    </div>

    <!-- Filter Form -->
    <form action="<?php echo base_url('index.php/test/displayData'); ?>" method="POST" id="filterForm">
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
                    <option value="Active"   <?php echo ($current_status == 'Active'   ? 'selected' : ''); ?>>Active</option>
                    <option value="Inactive" <?php echo ($current_status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>

            <div class="filter-group" style="flex-grow: 2;">
                <label for="search_text">Search by Name/Email:</label>
                <input type="text" id="search_text" name="search_text"
                       placeholder="Search..." value="<?php echo html_escape($current_search); ?>">
            </div>
        </div>

        <div class="filter-controls">
            <!-- ID Filter -->
            <div class="filter-group">
                <label for="filter_id">ID:</label>
                <input type="text" id="filter_id" name="filter_id"
                       placeholder="Enter ID..." value="<?php echo html_escape($current_id); ?>">
            </div>

            <!-- Gender Filter -->
            <div class="filter-group">
                <label>Gender:</label>
                <div class="radio-group">
                    <label><input type="radio" name="filter_gender" value=""       <?php echo ($current_gender === ''       ? 'checked' : ''); ?>> All</label>
                    <label><input type="radio" name="filter_gender" value="Male"   <?php echo ($current_gender === 'Male'   ? 'checked' : ''); ?>> Male</label>
                    <label><input type="radio" name="filter_gender" value="Female" <?php echo ($current_gender === 'Female' ? 'checked' : ''); ?>> Female</label>
                </div>
            </div>

            <!-- Age Filter -->
            <div class="filter-group">
                <label for="filter_age">Age:</label>
                <input type="number" id="filter_age" name="filter_age" min="18" max="100"
                       placeholder="e.g., 25" value="<?php echo html_escape($current_age); ?>">
            </div>

            <!-- Phone Filter -->
            <div class="filter-group">
                <label for="filter_phone">Phone:</label>
                <input type="tel" id="filter_phone" name="filter_phone" maxlength="15"
                       placeholder="e.g., 9876543210" value="<?php echo html_escape($current_phone); ?>">
            </div>

            <!-- Membership Date Range -->
            <div class="filter-group">
                <label for="membership_from">Membership From:</label>
                <input type="date" id="membership_from" name="membership_from"
                       value="<?php echo html_escape($current_membership_from); ?>">
            </div>

            <div class="filter-group">
                <label for="membership_to">Membership To:</label>
                <input type="date" id="membership_to" name="membership_to"
                       value="<?php echo html_escape($current_membership_to); ?>">
            </div>

            <!-- Access Level -->
            <div class="filter-group">
                <label for="filter_access_level">Access Level:</label>
                <select id="filter_access_level" name="filter_access_level">
                    <option value="">All Levels</option>
                    <option value="Admin"    <?php echo ($current_access_level == 'Admin'    ? 'selected' : ''); ?>>Admin</option>
                    <option value="Employee" <?php echo ($current_access_level == 'Employee' ? 'selected' : ''); ?>>Employee</option>
                    <option value="Sales"    <?php echo ($current_access_level == 'Sales'    ? 'selected' : ''); ?>>Sales</option>
                </select>
            </div>

            <!-- Product Interest -->
            <div class="filter-group">
                <label>Product Interest:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="product_interest[]" value="Product A"
                        <?php echo (in_array('Product A', $current_product_interest) ? 'checked' : ''); ?>> Product A</label>
                    <label><input type="checkbox" name="product_interest[]" value="Product B"
                        <?php echo (in_array('Product B', $current_product_interest) ? 'checked' : ''); ?>> Product B</label>
                    <label><input type="checkbox" name="product_interest[]" value="Service C"
                        <?php echo (in_array('Service C', $current_product_interest) ? 'checked' : ''); ?>> Service C</label>
                </div>
            </div>

            <!-- Apply / Reset Buttons -->
            <div class="filter-group" style="flex-basis: 180px; display: flex; flex-direction: column; gap: 8px;">
                <button type="submit" class="btn-apply">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>

                <button type="button" onclick="resetFilters()" class="btn-reset">
                    <i class="fas fa-times-circle"></i> Reset
                </button>
            </div>
<div>
            <!-- CSV Import -->
            <div class="filter-group">
                <!-- <div style="position: relative; display: inline-block;"> -->
                    <a href="#" class="btn-apply import-btn" onclick="document.getElementById('csv-import').click(); return false;">
                        <i class="fas fa-file-upload"></i> 
                        <span class="import-text">Import CSV</span>
                    </a>
                    <input type="file" id="csv-import" accept=".csv" style="display:none;">
                    
                    <!-- Filename display -->
                    <div id="filename-display" style="margin-top: 5px; font-size: 12px; color: #666; display: none;">
                        <i class="fas fa-file-csv"></i> 
                        <span id="selected-filename"></span>
                        <button type="button" id="upload-btn" class="btn-apply" style="padding: 2px 8px; font-size: 12px; margin-left: 10px;">
                            <i class="fas fa-upload"></i> Upload
                        </button>
                        <button type="button" id="clear-btn" style="padding: 2px 8px; font-size: 12px; margin-left: 5px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- Export CSV -->
            <div class="filter-group">
                <a href="<?php echo site_url('test/export_csv?' . http_build_query($current_filters)); ?>" 
                   class="btn-apply" 
                   onclick="return confirm('Download <?php echo $total_count; ?> records as CSV?')">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Total Records Display -->
        <div style="background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px;">
            Total Records Found: <strong><?php echo $total_count; ?></strong> |
            Total Pages: <strong><?php echo isset($total_pages) ? $total_pages : 0; ?></strong>
        </div>
    </form>

    <table class="data-table" id="customerTable">
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
                        <td><?php echo html_escape($customer->id); ?></td>
                        <td><?php echo html_escape($customer->first_name . ' ' . $customer->last_name); ?></td>
                        <td><?php echo html_escape($customer->email); ?></td>
                        <td><?php echo html_escape($customer->phone); ?></td>
                        <td><?php echo html_escape($customer->age); ?></td>
                        <td><?php echo html_escape($customer->account_status); ?></td>
                        <td>
                            <?php
                                if ($customer->country_id == 1) echo 'USA';
                                elseif ($customer->country_id == 2) echo 'Canada';
                                else echo 'UK';
                            ?>
                        </td>
                        <td><?php echo html_escape($customer->access_level); ?></td>
                        <td><?php echo html_escape($customer->gender); ?></td>
                        <td>
                            <?php
                                $interests = json_decode($customer->product_interest, true);
                                if (!empty($interests) && is_array($interests)) {
                                    echo html_escape(implode(', ', $interests));
                                } else {
                                    echo 'None';
                                }
                            ?>
                        </td>
                        <td><?php echo html_escape($customer->membership_from); ?></td>
                        <td><?php echo html_escape($customer->membership_to); ?></td>
                        <td class="action-btns">
                            <a href="<?php echo base_url('index.php/test/edit_customer/' . $customer->id); ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?php echo base_url('index.php/test/delete_customer/' . $customer->id); ?>"
                               class="btn-delete"
                               onclick="showDeleteConfirm(<?php echo (int)$customer->id; ?>, '<?php echo htmlspecialchars($customer->first_name, ENT_QUOTES, 'UTF-8'); ?>'); return false;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="13" class="text-center">No customers found matching criteria.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
    // Build query string safely
    $query = '';
    if (!empty($_SERVER['QUERY_STRING'])) {
        $query = '?' . $_SERVER['QUERY_STRING'];
    }
    ?>

    <?php if (!empty($show_pagination) && $show_pagination && isset($total_pages) && $total_pages > 1): ?>
    <div class="pagination-container">
        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <?php
                $prev_query = $query ? $query . '&page=' . ($current_page - 1) : '?page=' . ($current_page - 1);
                ?>
                <a href="<?php echo base_url('index.php/test/displayData') . $prev_query; ?>">← Prev</a>
            <?php endif; ?>

            <?php
            $start = max(1, $current_page - 2);
            $end   = min($total_pages, $current_page + 2);
            ?>

            <?php if ($start > 1): ?>
                <?php $first_query = $query ? $query . '&page=1' : '?page=1'; ?>
                <a href="<?php echo base_url('index.php/test/displayData') . $first_query; ?>">1</a>
                <?php if ($start > 2): ?><span>...</span><?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <?php 
                $page_query = $query ? $query . '&page=' . $i : '?page=' . $i;
                ?>
                <?php if ($i == $current_page): ?>
                    <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="<?php echo base_url('index.php/test/displayData') . $page_query; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($end < $total_pages): ?>
                <?php if ($end < $total_pages - 1): ?><span>...</span><?php endif; ?>
                <?php $last_query = $query ? $query . '&page=' . $total_pages : '?page=' . $total_pages; ?>
                <a href="<?php echo base_url('index.php/test/displayData') . $last_query; ?>"><?php echo $total_pages; ?></a>
            <?php endif; ?>

            <?php if ($current_page < $total_pages): ?>
                <?php
                $next_query = $query ? $query . '&page=' . ($current_page + 1) : '?page=' . ($current_page + 1);
                ?>
                <a href="<?php echo base_url('index.php/test/displayData') . $next_query; ?>">Next →</a>
            <?php endif; ?>

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
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Delete Customer?</h3>
            <p>Are you sure you want to delete <strong id="customerName">Customer Name</strong>?</p>
            <p style="color: #999; font-size: 14px; margin-top: 10px;">
                This action cannot be undone.
            </p>
            <div>
                <button id="confirmDeleteBtn" class="delete-btn">
                    <i class="fas fa-trash"></i> Yes, Delete
                </button>
                <button id="cancelDeleteBtn" class="cancel-btn">
                    <i class="fas fa-times"></i> Cancel
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
        if (pendingDeleteId) {
            window.location.href = "<?php echo base_url('index.php/test/delete_customer/'); ?>" + pendingDeleteId;
        }
    }

    function cancelDelete() {
        document.getElementById('deleteModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        pendingDeleteId = null;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const cancelBtn = document.getElementById('cancelDeleteBtn');

        if (confirmBtn) confirmBtn.onclick = confirmDelete;
        if (cancelBtn) cancelBtn.onclick = cancelDelete;

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('deleteModal').style.display === 'flex') {
                cancelDelete();
            }
        });

        document.getElementById('deleteModal').onclick = function(e) {
            if (e.target.id === 'deleteModal') {
                cancelDelete();
            }
        };
    });

    // CSV Import Functionality
    (function() {
        let selectedFile = null;
        
        // File selection handler
        document.getElementById('csv-import').addEventListener('change', function(e) {
            selectedFile = e.target.files[0];
            
            if (selectedFile) {
                document.getElementById('selected-filename').textContent = selectedFile.name;
                document.getElementById('filename-display').style.display = 'block';
                document.querySelector('.import-text').textContent = 'Change File';
                document.querySelector('.import-btn').style.background = '#ffc107';
                
                // Validate CSV
                if (!selectedFile.name.toLowerCase().endsWith('.csv')) {
                    alert('Please select a CSV file');
                    clearFile();
                    return;
                }
                
                console.log('Selected:', selectedFile.name, '(' + (selectedFile.size/1024).toFixed(1) + 'KB)');
            }
        });
        
        // Upload handler
        document.getElementById('upload-btn').addEventListener('click', function() {
            if (!selectedFile) {
                alert('Please select a CSV file first');
                return;
            }
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            this.disabled = true;
            
            let formData = new FormData();
            formData.append('csv_file', selectedFile);
            
            // Preserve filters
            new URLSearchParams(window.location.search).forEach((value, key) => {
                if (value) formData.append(key, value);
            });
            
            fetch('<?php echo site_url('test/import_csv'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('✅ ' + data.message);
                    clearFile();
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Unknown error'));
                }
            })
            .catch(e => alert('❌ Upload failed: ' + e))
            .finally(() => {
                this.innerHTML = '<i class="fas fa-upload"></i> Upload';
                this.disabled = false;
            });
        });
        
        // Clear handler
        document.getElementById('clear-btn').addEventListener('click', clearFile);
        
        function clearFile() {
            selectedFile = null;
            document.getElementById('csv-import').value = '';
            document.getElementById('filename-display').style.display = 'none';
            document.querySelector('.import-text').textContent = 'Import CSV';
            document.querySelector('.import-btn').style.background = '';
        }
    })();
    </script>

</body>
</html>
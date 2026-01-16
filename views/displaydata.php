<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$current_product_interest = $current_filters['product_interest']     ?? [];

$total_count = $total_count ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Data Table</title>
    
    <link rel="stylesheet" href="<?php echo base_url('assets/css/newdesign.css'); ?>">
     <link rel="stylesheet" href="<?php echo base_url('assets/css/flash.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/download.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/delete_pop_up.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
      


    </style>
</head>
<body>
    <div class="container">
        <!-- PHP Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="flash-message flash-success">
                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-message flash-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- JavaScript Flash Messages -->
        <div id="flash-messages"></div>

        <!-- Import Modal -->
        <div id="import-modal">
            <div>
                <div id="modal-icon"></div>
                <h3 id="modal-title"></h3>
                <p id="modal-message"></p>
                <button id="modal-close">OK</button>
            </div>
        </div>

        <div class="header-section">
            <h2>Customer Records (<?php echo $total_count; ?> found)</h2>
            <a href="<?php echo base_url('index.php/test/crudApp'); ?>" class="btn-add-new">
               <i class="fas fa-plus-circle"></i> Register New User
            </a>
        </div>

        <!-- Filter Form -->
        <form action="<?php echo base_url('index.php/test/displayData'); ?>" method="POST" id="filterForm">
            <div class="filter-controls">
                <!-- Country, Status, Search -->
                <div class="filter-group">
                    <label for="filter_country">Country:</label>
                    <select id="filter_country" name="filter_country">
                        <option value="">All Countries</option>
                        <option value="1" <?php echo ($current_country == '1' ? 'selected' : ''); ?>>USA</option>
                        <option value="2" <?php echo ($current_country == '2' ? 'selected' : ''); ?>>Canada</option>
                        <option value="3" <?php echo ($current_country == '3' ? 'selected' : ''); ?>>UK</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter_status">Status:</label>
                    <select id="filter_status" name="filter_status">
                        <option value="">All Statuses</option>
                        <option value="Active" <?php echo ($current_status == 'Active' ? 'selected' : ''); ?>>Active</option>
                        <option value="Inactive" <?php echo ($current_status == 'Inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>

                <div class="filter-group" style="flex-grow: 2;">
                    <label for="search_text">Search:</label>
                    <input type="text" id="search_text" name="search_text" value="<?php echo html_escape($current_search); ?>" placeholder="Name/Email...">
                </div>

                <!-- ID, Gender, Age -->
                <div class="filter-group">
                    <label for="filter_id">ID:</label>
                    <input type="text" id="filter_id" name="filter_id" value="<?php echo html_escape($current_id); ?>" placeholder="ID">
                </div>

                <div class="filter-group">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="filter_gender" value="" <?php echo ($current_gender === '' ? 'checked' : ''); ?>> All</label>
                        <label><input type="radio" name="filter_gender" value="Male" <?php echo ($current_gender === 'Male' ? 'checked' : ''); ?>> Male</label>
                        <label><input type="radio" name="filter_gender" value="Female" <?php echo ($current_gender === 'Female' ? 'checked' : ''); ?>> Female</label>
                    </div>
                </div>

                <div class="filter-group">
                    <label for="filter_age">Age:</label>
                    <input type="number" id="filter_age" name="filter_age" min="18" max="100" value="<?php echo html_escape($current_age); ?>" placeholder="25">
                </div>

                <!-- Phone, Dates, Access -->
                <div class="filter-group">
                    <label for="filter_phone">Phone:</label>
                    <input type="tel" id="filter_phone" name="filter_phone" value="<?php echo html_escape($current_phone); ?>" maxlength="15">
                </div>

                <div class="filter-group">
                    <label for="membership_from">From:</label>
                    <input type="date" id="membership_from" name="membership_from" value="<?php echo html_escape($current_membership_from); ?>">
                </div>

                <div class="filter-group">
                    <label for="membership_to">To:</label>
                    <input type="date" id="membership_to" name="membership_to" value="<?php echo html_escape($current_membership_to); ?>">
                </div>

                <div class="filter-group">
                    <label for="filter_access_level">Access:</label>
                    <select id="filter_access_level" name="filter_access_level">
                        <option value="">All</option>
                        <option value="Admin" <?php echo ($current_access_level == 'Admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="Employee" <?php echo ($current_access_level == 'Employee' ? 'selected' : ''); ?>>Employee</option>
                        <option value="Sales" <?php echo ($current_access_level == 'Sales' ? 'selected' : ''); ?>>Sales</option>
                    </select>
                </div>

                <!-- Product Interest & Buttons -->
                <div class="filter-group">
                    <label>Interests:</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="product_interest[]" value="Product A" <?php echo (in_array('Product A', (array)$current_product_interest) ? 'checked' : ''); ?>> Product A</label>
                        <label><input type="checkbox" name="product_interest[]" value="Product B" <?php echo (in_array('Product B', (array)$current_product_interest) ? 'checked' : ''); ?>> Product B</label>
                        <label><input type="checkbox" name="product_interest[]" value="Service C" <?php echo (in_array('Service C', (array)$current_product_interest) ? 'checked' : ''); ?>> Service C</label>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-apply"><i class="fas fa-filter"></i> Apply</button>
                    <button type="button" onclick="resetFilters()" class="btn-reset"><i class="fas fa-times"></i> Reset</button>
                </div>
            </div>

            <!-- CSV Import/Export -->
            <div class="csv-actions" style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; display: inline-flex; gap: 15px; align-items: flex-start;">
                <div  class="import-section" style="position: relative; flex: 1;">
                    <a id="import" href="#" class="btn-apply import-btn" onclick="document.getElementById('csv-import').click(); return false;" style="display: block; padding: 12px 20px;">
                        <i id="import" class="fas fa-file-upload"></i> <span id="import" class="import-text">Import CSV</span>
                    </a>
                    <input type="file" id="csv-import" accept=".csv" style="display: none;">
                    
                    <div id="filename-display" style="margin-top: 8px; padding: 10px; background: #e9ecef; border-radius: 5px; display: none; font-size: 13px;">
                        <i class="fas fa-file-csv" style="color: #28a745;"></i>
                        <span id="selected-filename" style="margin-left: 8px;"></span>
                        <div style="margin-top: 8px; display: flex; gap: 8px;">
                            <button id="upload-btn" class="btn-apply" style="padding: 6px 16px; font-size: 12px;">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                            <button id="clear-btn" style="padding: 6px 16px; font-size: 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
  <!-- onclick="return confirm('Download <?php echo $total_count; ?> records as CSV?')" -->
                <a href="<?php echo site_url('test/export_csv?' . http_build_query($current_filters)); ?>" 
                   class="btn-apply" style="padding: 12px 20px; flex-shrink: 0;">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
            </div>
             <div class="csv-actions" style="margin: 15px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; display: inline-flex; gap: 15px; align-items: flex-start;">
                <p> Searching page <?php echo $current_page ?> of <?php echo $total_pages; ?> </p>
             </div>

        </form>

        <!-- Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Age</th>
                    <th>Status</th><th>Country</th><th>Access</th><th>Gender</th>
                    <th>Interests</th><th>From</th><th>To</th><th>Actions</th>
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
                            <td><?php echo html_escape($customer->age ?: '-'); ?></td>
                            <td><?php echo html_escape($customer->account_status ?: '-'); ?></td>
                            <td><?php echo ['','USA','Canada','UK'][$customer->country_id] ?: '-'; ?></td>
                            <td><?php echo html_escape($customer->access_level ?: '-'); ?></td>
                            <td><?php echo html_escape($customer->gender ?: '-'); ?></td>
                           <!--  <td>
                                <?php 
                               // $interests = $customer->product_interest ? json_decode($customer->product_interest, true) : [];
                              //  echo !empty($interests) && is_array($interests) ? html_escape(implode(', ', $interests)) : 'None';
                                ?>
                            </td> -->



                            <td>
                                <?php 
                                $interests = $customer->product_interest ? trim($customer->product_interest) : '';
                                
                                // Handle both formats
                                if (empty($interests) || $interests === 'None') {
                                    echo 'None';
                                } elseif (strpos($interests, '[') === 0 && strpos($interests, ']') !== false) {
                                    // JSON array format: ["Product A","Product B"]
                                    $decoded = json_decode($interests, true);
                                    echo !empty($decoded) && is_array($decoded) ? 
                                         html_escape(implode(', ', $decoded)) : 'None';
                                } else {
                                    // Comma-separated string format: Product A,Product B,Service C
                                    $items = array_map('trim', explode(',', $interests));
                                    $items = array_filter($items); // Remove empty items
                                    echo !empty($items) ? html_escape(implode(', ', $items)) : 'None';
                                }
                                ?>
                            </td>

                            <td><?php echo html_escape($customer->membership_from); ?></td>
                            <td><?php echo html_escape($customer->membership_to); ?></td>
                            <td>
                                <a href="<?php echo base_url('index.php/test/edit_customer/' . $customer->id); ?>" class="btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo base_url('index.php/test/delete_customer/' . $customer->id); ?>" 
                                   class="btn-delete" onclick="showDeleteConfirm(<?php echo (int)$customer->id; ?>, '<?php echo htmlspecialchars($customer->first_name, ENT_QUOTES); ?>'); return false;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="13" style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                        <div>No customers found matching your criteria</div>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if (!empty($show_pagination) && $show_pagination && isset($total_pages) && $total_pages > 1): ?>
        <div class="pagination-container">
            <div class="pagination">
                <?php 
                $query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                $current_page = $current_page ?? 1;
                ?>
                <?php if ($current_page > 1): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . ($current_page - 1)); ?>">← Prev</a>
                <?php endif; ?>

                <?php 
                $start = max(1, $current_page - 2);
                $end = min($total_pages, $current_page + 2);
                ?>

                <?php if ($start > 1): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=1'); ?>">1</a>
                    <?php if ($start > 2): ?><span>...</span><?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php $page_query = $query . ($query ? '&' : '?') . 'page=' . $i; ?>
                    <?php if ($i == $current_page): ?>
                        <span class="active"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="<?php echo base_url('index.php/test/displayData' . $page_query); ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?><span>...</span><?php endif; ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . $total_pages); ?>"><?php echo $total_pages; ?></a>
                <?php endif; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?php echo base_url('index.php/test/displayData' . $query . ($query ? '&' : '?') . 'page=' . ($current_page + 1)); ?>">Next →</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="delete-modal">
        <div class="delete-modal-content">
            <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #ff6b35;"></i>
            <h3>Delete Customer?</h3>
            <p>Are you sure you want to delete <strong id="customerName">Customer</strong>?</p>
            <p style="color: #999; font-size: 14px;">This action cannot be undone.</p>
            <div>
                <button id="confirmDeleteBtn" class="delete-btn">Yes, Delete</button>
                <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script>
    // Global functions
    function resetFilters() {
        document.getElementById('filterForm').reset();
        window.location.href = "<?php echo base_url('index.php/test/displayData'); ?>";
    }

    // Delete Modal
    let pendingDeleteId = null;
    function showDeleteConfirm(customerId, customerName) {
        pendingDeleteId = customerId;
        document.getElementById('customerName').textContent = customerName;
        document.getElementById('deleteModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    // CSV Import with Flash Messages + Modal (NO ALERTS!)
    (function() {
        let selectedFile = null;

        // Flash message helper
        function showFlash(type, message) {
            const container = document.getElementById('flash-messages');
            const flash = document.createElement('div');
            flash.className = `flash-message flash-${type}`;
            flash.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i> ${message}`;
            
            container.appendChild(flash);
            setTimeout(() => {
                flash.style.animation = 'slideOut 0.3s ease-in forwards';
                setTimeout(() => flash.remove(), 300);
            }, 5000);
        }

        // Modal helper
        function showModal(icon, title, message) {
            document.getElementById('modal-icon').innerHTML = `<i class="fas ${icon}"></i>`;
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-message').textContent = message;
            document.getElementById('import-modal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // File selection
        document.getElementById('csv-import').addEventListener('change', function(e) {
            selectedFile = e.target.files[0];
            if (selectedFile) {
                document.getElementById('selected-filename').textContent = selectedFile.name;
                document.getElementById('filename-display').style.display = 'block';
                document.querySelector('.import-text').textContent = 'Change File';
                document.querySelector('.import-btn').style.background = '#ffc107';

                if (!selectedFile.name.toLowerCase().endsWith('.csv')) {
                    showFlash('error', 'Please select a CSV file only');
                    clearFile();
                    return;
                }
                showFlash('success', `Selected: ${selectedFile.name}`);
            }
        });

        // Upload
        document.getElementById('upload-btn').addEventListener('click', function() {
            if (!selectedFile) {
                showFlash('error', 'Please select a CSV file first');
                return;
            }

            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            this.disabled = true;
            showFlash('info', 'Uploading your CSV file...');

            let formData = new FormData();
            formData.append('csv_file', selectedFile);
            new URLSearchParams(window.location.search).forEach((value, key) => {
                if (value) formData.append(key, value);
            });

            fetch('<?php echo site_url('test/import_csv'); ?>', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    showModal('fa-check-circle text-success', 'Success!', data.message);
                    clearFile();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showModal('fa-exclamation-circle text-danger', 'Failed!', data.message || 'Unknown error');
                }
            })
            .catch(e => showModal('fa-exclamation-triangle text-warning', 'Error!', 'Upload failed: ' + e.message))
            .finally(() => {
                this.innerHTML = '<i class="fas fa-upload"></i> Upload';
                this.disabled = false;
            });
        });

        // Clear
        document.getElementById('clear-btn').addEventListener('click', clearFile);
        document.getElementById('modal-close').addEventListener('click', () => {
            document.getElementById('import-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        function clearFile() {
            selectedFile = null;
            document.getElementById('csv-import').value = '';
            document.getElementById('filename-display').style.display = 'none';
            document.querySelector('.import-text').textContent = 'Import CSV';
            document.querySelector('.import-btn').style.background = '';
        }

        // Delete modal handlers
        document.getElementById('confirmDeleteBtn').onclick = function() {
            if (pendingDeleteId) window.location.href = "<?php echo base_url('index.php/test/delete_customer/'); ?>" + pendingDeleteId;
        };
        document.getElementById('cancelDeleteBtn').onclick = function() {
            document.getElementById('deleteModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        // Existing flash auto-hide
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(flash => {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            });
        }, 5000);
    })();
    </script>
</body>
</html>

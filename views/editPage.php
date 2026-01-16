<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer: <?php echo htmlspecialchars($customer->first_name ?? ''); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/editPage.css'); ?>">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const today = new Date().toISOString().split('T')[0];  // 2025-12-09
    const maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() + 1);
    const maxDateStr = maxDate.toISOString().split('T')[0];
    
    $('#from_membership_date').attr({'min': today, 'max': maxDateStr});
    $('#to_membership_date').attr({'min': today, 'max': maxDateStr});  // Single _
    
    $('#from_membership_date').change(function() {
        const fromDate = $(this).val();
        $('#to_membership_date').attr('min', fromDate);
    });
});
</script>

</head>
<body>
<div class="container">
    <h2 class="heading">Edit Customer</h2>
    
    <?php echo validation_errors('<div style="color:red; font-weight: bold;">', '</div>'); ?>

    <form action="<?php echo base_url('index.php/test/edit_customer/' . ($customer->id ?? '')); ?>" method="POST" id="customerRegistrationForm">
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer->id ?? ''); ?>">

        <fieldset>
            <legend>Primary Details</legend>
            
            <label for="first_name">Enter Your First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="20" required autocomplete="off"
                   value="<?php echo set_value('first_name', $customer->first_name ?? ''); ?>">
            <br><br>

            <label for="last_name">Enter Your Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="20" required autocomplete="off"
                   value="<?php echo set_value('last_name', $customer->last_name ?? ''); ?>">
            <br><br>

            <label for="email">Enter Your Email address:</label>
            <input type="email" id="email" name="email" maxlength="50" required autocomplete="off"
                   value="<?php echo set_value('email', $customer->email ?? ''); ?>">
            <br><br>

            <label for="phone">Enter Your Phone Number:</label>
            <input type="tel" id="phone" name="phone" maxlength="10" required autocomplete="off" placeholder="e.g., 9978675645"
                   value="<?php echo set_value('phone', $customer->phone ?? ''); ?>">
            <br><br>

            <label for="age">Enter Your Age:</label>
            <input type="number" id="age" name="age" min="18" max="65" required autocomplete="off"
                   value="<?php echo set_value('age', $customer->age ?? ''); ?>">
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Access, Status & Dates</legend>

            <label for="from_membership_date">Membership Start Date (From Date):</label>
            <input type="date" id="from_membership_date" name="from_date" required autocomplete="off"
                   value="<?php echo set_value('from_date', $customer->membership_from ?? ''); ?>">
            <br><br>
            
            <label for="to_membership_date">Membership End Date (To Date):</label>
            <input type="date" id="to_membership_date" name="to_date" required autocomplete="off"
                   value="<?php echo set_value('to_date', $customer->membership_to ?? ''); ?>">
            <br><br>

            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="">Select Country...</option>
                <option value="1" <?php echo set_select('country', '1', ($customer->country_id ?? '') == '1'); ?>>USA</option>
                <option value="2" <?php echo set_select('country', '2', ($customer->country_id ?? '') == '2'); ?>>Canada</option>
                <option value="3" <?php echo set_select('country', '3', ($customer->country_id ?? '') == '3'); ?>>UK</option>
            </select>
            <br><br>

            <label for="access_level">Level of Access/Status:</label>
            <select id="access_level" name="access_level" required>
                <option value="admin" <?php echo set_select('access_level', 'admin', ($customer->access_level ?? '') == 'admin'); ?>>Admin</option>
                <option value="employee" <?php echo set_select('access_level', 'employee', ($customer->access_level ?? '') == 'employee'); ?>>Employee</option>
                <option value="sales" <?php echo set_select('access_level', 'sales', ($customer->access_level ?? '') == 'sales'); ?>>Sales</option>
            </select>
            <br><br>
            
            <label>Account Status:</label>
            <input type="radio" id="status_active" name="account_status" value="Active" 
                   <?php echo set_radio('account_status', 'Active', ($customer->account_status ?? '') == 'Active'); ?>>
            <label for="status_active">Active</label>
            
            <input type="radio" id="status_inactive" name="account_status" value="Inactive"
                   <?php echo set_radio('account_status', 'Inactive', ($customer->account_status ?? '') == 'Inactive'); ?>>
            <label for="status_inactive">Inactive</label>
            <br><br>

            <label>Gender:</label>
            <input type="radio" id="gender_female" name="gender" value="Female"
                   <?php echo set_radio('gender', 'Female', ($customer->gender ?? '') == 'Female'); ?>>
            <label for="gender_female">Female</label>

            <input type="radio" id="gender_male" name="gender" value="Male"
                   <?php echo set_radio('gender', 'Male', ($customer->gender ?? '') == 'Male'); ?>>
            <label for="gender_male">Male</label>
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Product Interest</legend>
            
            <?php $interest_array = $customer->product_interest_array ?? []; ?>
            
            <input type="checkbox" id="interest_product_a" name="product_interest[]" value="Product A"
                   <?php echo set_checkbox('product_interest[]', 'Product A', in_array('Product A', $interest_array)); ?>>
            <label for="interest_product_a">Product A</label><br>

            <input type="checkbox" id="interest_product_b" name="product_interest[]" value="Product B"
                   <?php echo set_checkbox('product_interest[]', 'Product B', in_array('Product B', $interest_array)); ?>>
            <label for="interest_product_b">Product B</label><br>

            <input type="checkbox" id="interest_service_c" name="product_interest[]" value="Service C"
                   <?php echo set_checkbox('product_interest[]', 'Service C', in_array('Service C', $interest_array)); ?>>
            <label for="interest_service_c">Service C</label>
        </fieldset>
        
        <div class="form-actions">
            <button type="submit">Update Customer</button>
            <a href="<?php echo base_url('index.php/test/displayData'); ?>">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>

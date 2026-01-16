<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Customer Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" type="text/css"
     href="<?php echo base_url('assets/css/form.css')?>" ></link>


<script>
    $(document).ready(function() {
        const today = new Date().toISOString().split('T')[0];  // Today's date YYYY-MM-DD
        const maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() + 1);  // 1 year from today
        const maxDateStr = maxDate.toISOString().split('T')[0];
        
        // Set min/max dates
        $('#from_membership_date').attr('min', today).attr('max', maxDateStr);
        $('#to_membership_date').attr('min', today).attr('max', maxDateStr);
        
        // Ensure To Date >= From Date
        $('#from_membership_date').change(function() {
            const fromDate = $(this).val();
            $('#to_membership_date').attr('min', fromDate);
        });
    });
</script>



</head>
<body>
<div class="container">
    <h2 class="heading">Customer Registration</h2>
    
    <form action="http://localhost/codeigniter_project/index.php/test/submitForm" method="POST" id="customerRegistrationForm">
        
        <fieldset>
            <legend>Primary Details</legend>
            
            <label for="first_name">Enter Your First Name:</label>
            <input type="text" id="first_name" name="first_name" maxlength="20" required autocomplete="off">
            <br><br>

            <label for="last_name">Enter Your Last Name:</label>
            <input type="text" id="last_name" name="last_name" maxlength="20" required autocomplete="off">
            <br><br>

            <label for="email">Enter Your Email address:</label>
            <input type="email" id="email" name="email" maxlength="50" required autocomplete="off">
            <br><br>

            <label for="phone">Enter Your Phone Number:</label>
            <input type="tel" id="phone" name="phone" maxlength="10" required autocomplete="off" placeholder="e.g., 9978675645">
            <br><br>

            <label for="age">Enter Your Age:</label>
            <input type="number" id="age" name="age" min="18" max="65" required autocomplete="off">
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Access, Status & Dates</legend>

            <label for="from_membership_date">Membership Start Date (From Date):</label>
            <input type="date" id="from_membership_date" name="from_date" required autocomplete="off">
            <br><br>
            
            <label for="to_membership_date">Membership End Date (To Date):</label>
            <input type="date" id="to_membership_date" name="to_date" required autocomplete="off">
            <br><br>



            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="">Select Country...</option>
                <option value="1">USA</option>
                <option value="2">Canada</option>
                <option value="3">UK</option>
            </select>
            <br><br>

            <label for="access_level">Level of Access/Status:</label>
            <select id="access_level" name="access_level" required >
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="sales">Sales</option>
            </select>
            <br><br>
            
            <label>Account Status:</label>
            <input type="radio" id="status_active" name="account_status" value="Active" checked>
            <label for="status_active">Active</label>
            
            <input type="radio" id="status_inactive" name="account_status" value="Inactive">
            <label for="status_inactive">Inactive</label>
            <br><br>

            <label>Gender:</label>
            <input type="radio" id="gender_female" name="gender" value="Female">
            <label for="gender_female">Female</label>

            <input type="radio" id="gender_male" name="gender" value="Male">
            <label for="gender_male">Male</label>
            <br><br>
        </fieldset>

        <hr>

        <fieldset>
            <legend>Product Interest</legend>
            <input type="checkbox" id="interest_product_a" name="product_interest[]" value="Product A">
            <label for="interest_product_a">Product A</label>

            <input type="checkbox" id="interest_product_b" name="product_interest[]" value="Product B">
            <label for="interest_product_b">Product B</label>

            <input type="checkbox" id="interest_service_c" name="product_interest[]" value="Service C">
            <label for="interest_service_c">Service C</label>
        </fieldset>
        <br>
        <button type="submit">Register Customer</button>
    </form>
</div>
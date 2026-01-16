

<?php
// application/views/success_view.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Customer Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/success_view.css'); ?>">
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="success-container">
        <div class="success-icon">✅</div>
        
        <h1><?php echo $title; ?></h1>
        
        <div class="welcome-text">
            Hello, <strong><?php echo $first_name; ?>!</strong>
        </div>
        
        <p class="message"><?php echo $message; ?></p>
        
        <p style="color: #64748b; margin-bottom: 30px; font-size: 16px;">
            Thank you for registering with us. 🚀
        </p>
        
        <div class="action-buttons">
            <a href="<?php echo base_url('index.php/test/displayData'); ?>" class="btn btn-primary">
                📊 View All Customers
            </a>
            <a href="<?php echo base_url('index.php/test/crudApp'); ?>" class="btn btn-secondary">
                ➕ Add New Customer
            </a>
        </div>
    </div>
</body>
</html>
<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Customer Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding-top: 50px; }
        .success-box { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 20px; margin: 0 auto; width: 50%; border-radius: 5px; }
        h1 { color: #155724; }
    </style>
</head>
<body>

<div class="success-box">
    <h1><?php echo $title; ?>!</h1>

    <p>
        Hello, <?php echo $first_name; ?>.
    </p>

    <h2><?php echo $message; ?></h2>

    <p>Thank you for registering with us.</p>
     <a href="<?php echo base_url('index.php/test/displayData'); ?>">Display Data</a>
    
    <a href="<?php echo base_url('index.php/test/crudApp'); ?>">Go Back to Form</a>
</div>

</body>
</html> -->
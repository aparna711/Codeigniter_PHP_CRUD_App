<!-- <!DOCTYPE html>
<html>
<head>
	<title>Success View</title>
</head>
<body>
	<h1>Sucessful </h1>

</body>
</html> -->

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
        Hello, **<?php echo $first_name; ?>**.
    </p>

    <h2><?php echo $message; ?></h2>

    <p>Thank you for registering with us.</p>
     <a href="<?php echo base_url('/test/crudApp'); ?>">Go back to Form</a> 
    <a href="<?php echo base_url('/test/displayData'); ?>">Display Inserted Data</a>
</div>

</body>
</html>
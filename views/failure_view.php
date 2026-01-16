<?php
// application/views/error_view.php
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
        .error-box { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 20px; margin: 0 auto; width: 50%; border-radius: 5px; }
        h1 { color: #721c24; }
    </style>
</head>
<body>

<div class="error-box">
    <h1><?php echo $title; ?>!</h1>

    <p>
        Error Details:
    </p>

    <h2><?php echo $message; ?></h2>

    <p>
        Please check your database configuration or contact the administrator.
    </p>
    
    <a href="<?php echo base_url('index.php/test/crudApp'); ?>">Try Registration Again</a>
</div>

</body>
</html>
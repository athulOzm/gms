<?php
//echo '<pre>';
//print_r($get_mail_information);
//echo '</pre>';
?>
<html>
    <!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Custom Mail</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <style type="text/css">
            body{
                width: 80%;
                margin: 0 auto;
            }
            .welcome_header{
                background: #96588A;
                height: 80px;
            }
            .welcome_header h3{
                text-align: center;
                color: #fff;
                padding: 25px 0px;
                font-size: 25px;
            }
            .welcome_description{
                min-height: 100px;
                text-align: justify;
                margin: 20px 0px;
            }
            .welcome_description p{
                font-size: 16px;
            }
            .order_date{

            }
            .order_no{
                float: right;
            }
            .order_info{

            }
            table {
                border-collapse: collapse;
            }
            table, td, th {
                border: 1px solid black;
            }
            .payment{
                margin-bottom: 270px;
            }
            .payment_info h4, .payment_status h4{
                background: #DDDDDD;
                height: 30px;
                padding: 8px 0 0 15px;
                width: 78%;
            }
            .order_info table{
                width: 90%;
            }
            .payment_info table,.payment_status table{
                width: 80%;
            }
            .order_info thead, .payment_info thead,.payment_status thead{
                background: #DDDDDD;
            }
            .order_info tr,.payment_info tr, .payment_status tr{
                height: 40px;
            }
            .order_info th{
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="welcome_header">
                    <h3 class="text-center">Have a good day!</h3>
                </div>
            </div>
            <div class="row">
                <div class="welcome_description">
                    Dear <strong>
                        <?php
                        if ($customer_name) {
                            echo $customer_name;
                        }
                        ?>
                    </strong>
                    <p><?php echo nl2br($get_mail_information->message); ?></p>
<!--                    <p>Please click the url, for login your dashboard!</p>
                    <a href="<?php echo base_url(); ?>b-level/">Click Here, For Login.</a>-->
                </div>
            </div>
            <div class="row">
                <div class="welcome_footer">
                    <p>
                        Regards,<br>
                        <a href="https://www.bdtask.com/">
                            BDtask
                        </a><br>
                        Supports<br>
                        Mobile: +88-01817-584639<br>
                    </p>
                </div>
            </div>
        </div>
    </body>

</html>


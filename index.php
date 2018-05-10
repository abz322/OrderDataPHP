<!DOCTYPE html>
<html>
<head>
    <style>
        th {text-align:center}
        .ema {text-align: left}
        .orn {text-align:center; width: 50px;}
        .orv {text-align: right; width: 50px;}
        table, th, td, tr {border: solid; border-collapse: collapse; margin-right: auto; margin-left: auto; height: 30px;}
    </style>
</head>
    <body>
        <?php
        require_once 'class_Order.php';

        //Calls in the orderdata file that gets separated by new lines and placed into an array
        $orderData = file_get_contents('orderdata');
        $rows = explode("\n", $orderData);
        array_shift($rows);
        $i  = 0;

        //This Regular Expression follows the pattern email_address:number_of_orders:total_order_value and retrieves such data from the lines array
        $pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-\.]+\.([a-z]{2,3}\s*)(?:\.[a-z]{2})?+:[0-9\s*]+:[-+]?([\d*\s*]+[.])?\d+/i';
        foreach($rows as $row => $data)
        {
            if (preg_match($pattern, $data)) {
                //Once a match has been found the order data is exploded, separated by ':' and '@', then placed in its corresponding tags
                $matchedOrder = explode(':', $data);
                $info[$row]['email_address'] = str_replace(' ', '', $matchedOrder[0]);
                $info[$row]['number_of_orders'] = (int)$matchedOrder[1];
                $info[$row]['total_order_value'] = (float)$matchedOrder[2];
                $matchedOrder = explode('@', $info[$row]['email_address']);
                $info[$row]['domain'] = $matchedOrder[1];

                //A new instance of the order class is called and the processed information is stored in its relevant class properties for each match
                $customer[$i] = new c_order\class_Order();
                $customer[$i]->setOrder($info[$row]['domain'],$info[$row]['email_address'],$info[$row]['number_of_orders'],$info[$row]['total_order_value']);

                $i++;
            }
        }
        sort($customer);
        //This loop is used to print the out the  sorted orders in a table format
        echo '<table>';
        foreach ($customer as $obj => $val)
        {
            //This if statement is used to set an order header if one is not available
            if($tblDomain == '' || $val->getDomain() != $tblDomain){
                $tblDomain = $val->getDomain();
                echo '<tr><th colspan="3">'.$tblDomain.'</th></tr>'.'<tr><td class="ema">'.$val->getEmail().'</td><td class="orn">'.$val->getOrderNumber().'</td><td class="orv">'.$val->getOrderValue().'</td></tr>';
            }
            else if ($val->getDomain() == $tblDomain){
                echo '<tr><td class="ema">'.$val->getEmail().'</td><td class="orn">'.$val->getOrderNumber().'</td><td class="orv">'.$val->getOrderValue().'</td></tr>';
            }
        }
        echo '</table>';
        ?>
    </body>
</html>
<html>
<?php
    session_start();
    if (isset($_SESSION['user'])) {
        //print_r($_SESSION);
    }
?>

<?php
    error_reporting(1);
    require_once("secure_connect.php");
    $user = "root";
    $pass = "root";
	$orders = array();
	$id = "";
	$orderItemID = "";
	$itemID = "";
	$orderId = "";
	$priceOrder = "";
	$amountOrder = "";
	$itemID = "";
	$originalQty ="";
	$pID = "";

       	if($stmt = $mysqli -> prepare("SELECT id from order_item")){
	       	$stmt -> execute();
	       	$stmt -> bind_result($orderID);
	       	while($stmt->fetch()){
				array_push($orders, $orderID);
	       	}
       	}

    for($x=0; $x<count($orders); $x++){
       	$id = $orders[$x];
    	$selected_order = $_POST[$id];

    	if($selected_order == 'Confirm'){
    		if($stmt = $mysqli -> prepare("SELECT * FROM order_item WHERE id = ?")){
    			$stmt -> bind_param("s", $id);
    			$stmt -> execute();
    			$stmt -> bind_result($oiID, $item_id, $order_id, $qty, $price);
    			while($stmt->fetch()){
    				//echo $price;
    				$priceOrder = $price;
    				$amountOrder = $qty;
    				$orderId = $order_id;
    				$orderItemID = $oiID;
    				$itemID = $item_id;
    				//echo "<br>";
    			}
    		}
    		//Get the remaining qty of items
    		if($stmt = $mysqli -> prepare("SELECT qty FROM inventory.item WHERE id = ?")){
    			$stmt -> bind_param("i", $itemID);
    			$stmt -> execute();
    			$stmt -> bind_result($original_qty);
    			while($stmt->fetch()){
    				$originalQty = $original_qty;
    			}
    			//echo $originalQty;
    			//echo "<br>";
    			
    		}
    			else{
    				echo "fail ";
    		}
    		//Get the remaining balance
    		if($stmt = $mysqli -> prepare("SELECT project_id from inventory.ORDER where id=?")){
	       		$stmt -> bind_param("i", $orderId);
	       		$stmt -> execute();
	       		$stmt -> bind_result($project_id);
	       		while($stmt->fetch()){
	       			$pID = $project_id;
	       		}
	       		//echo $pID;
	       		//echo " ";
	       		//echo "<br>";
       		}
       		else{
    			echo "fail1";
    		}

       		if($stmt = $mysqli -> prepare("SELECT balance from inventory.project where id=?")){
       			$stmt -> bind_param("i", $pID);
       			$stmt -> execute();
       			$stmt -> bind_result($balance);
       			while($stmt -> fetch()){
       				$userBalance = $balance;
       			}
       			//echo $userBalance;
       			//echo " ";
       			//echo "<br>";
       		}
       		else{
    			echo "fail2 ";
    		}

       		//check and subtract balance
       		$remainingBalance = $userBalance - ($amountOrder * $priceOrder);
       		$newAmount = $originalQty - $amountOrder;
       		if($remainingBalance >= 0){
       			if($newAmount >= 0){
		       		if($stmt = $mysqli -> prepare("UPDATE inventory.project SET balance=? WHERE id=?")){
		       			//echo $remainingBalance;
		       			//echo " ";
		       			//echo "<br>";
		       			$stmt -> bind_param("ii", $remainingBalance, $pID);
		       			$stmt -> execute();
		       		}
		       		else{
		    			echo "fail3 ";
		    		}

		       		//check and update qty of items

		    		if($stmt = $mysqli -> prepare("UPDATE inventory.item SET qty = ? WHERE id = ?")){
		    			//echo $newAmount;
		    			//echo " ";
		    			//echo "<br>";
		    			$stmt -> bind_param("ii", $newAmount, $itemID);
		    			$stmt -> execute();
		    		}
		    		else{
		    			echo "fail4 ";
		    		}

		    		//remove order from the list
		    		if($stmt = $mysqli -> prepare("DELETE FROM order_item WHERE id = ?")){
		    			$stmt -> bind_param("s", $id);
		    			$stmt -> execute();
		    		}
		    		else{
		    			echo "fail5 ";
		    		}
		    		echo "order completed:";
		    		echo $oiID;
		    		echo "<br>";
		    	}
		    	// not enough items
		    	else{
		    		echo "fail on order:";
		    		echo $oiID;
		    		echo " ";
		    		echo "not enough items";
		    		echo "<br>";
		    	}
		    }
	    	//not enough money
	    	else{
	    		echo "fail on order:";
		    	echo $oiID;
		    	echo " ";
	    		echo "not enough money";
	    		echo "<br>";
	    	}
    	}
    }
    echo "redirecting automatically";
?>

<head>
<script>
setTimeout('Redirect()', 10000);

function Redirect() {
    window.location = "TA_page.php";
}
</script>
</head>
</html>
                       
</body>
</html>
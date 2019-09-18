<?php
session_start();
	$uids = $_SESSION['UID'];
?>


<?php
	$con = mysql_connect("localhost","root","");
	if($con==NULL){
		echo "Error establishing database connection.";
	}
	else{
		mysql_select_db("address-book");
	}
?>

<?php
	
	$id = trim($_POST['id']);
			
			
			$res = mysql_query("SELECT * FROM persons WHERE ID='$id' ");
			while($row = mysql_fetch_array($res)){
				
				$Name=$row['Name'];
				$Mobile=$row['Mobile'];
				$Email=$row['Email'];
				$Pa=$row['Permanant_Address'];
				$Ta=$row['Temporary_Address'];
				
				mysql_query("INSERT INTO recycle(Name,Mobile,Email,Permanant_Address,Temporary_Address) VALUES('$Name','$Mobile','$Email','$Pa','$Ta') ",$con);
				
				$row = mysql_fetch_array(mysql_query("SELECT MAX(ID) FROM recycle"));
	            $pids = $row[0];
			        mysql_query("INSERT INTO rmapping(uid,rid) VALUES('$uids','$pids') ",$con);
				
				
			}
			
			
			
	mysql_query("DELETE FROM mapping WHERE pid='$id' and uid='$uids' ",$con);
	mysql_query("DELETE FROM persons WHERE ID='$id' ",$con);
	
	
	if(mysql_error()==""){
		echo '<p style="color: #4F8A10;font-weight: bold;">Person Removed Successfully!</p>';
		
	}
	else{
		echo '<p style="color: #D8000C;font-weight: bold;">Something Went Wrong, Try Again.</p>';
	}
?>
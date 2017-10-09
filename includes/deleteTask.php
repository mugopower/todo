<?php 
	$taskId = strip_tags( $_POST['id'] );

	require("connect.php");
	$query = "DELETE FROM todo WHERE id='$taskId'";
	$data = $conn->query($query);
	if ($data->rowCount() > 0) {
		echo "deleted"; //To be returned as call back identifier for successful delete
	}
	$conn = NULL;
?>
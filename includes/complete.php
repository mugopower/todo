<?php 
	$post = strip_tags( $_POST['id'] );

	require("connect.php");
	if ($post == 'all') {

		$query = "UPDATE todo SET status = 'complete' WHERE status = 'pending'";
		$data = $conn->query($query);
		echo '<tbody id="to-dolist"><tr style="text-align: left"><th>To-do Task</th><th>Mark as comlete</th><th>Delete</th></tr><tr id="no-task"><td><i>There is nothing to dispaly </i></td></tr></tbody>';
	} else {
		$taskId = $post;
		$query = "UPDATE todo SET status = 'complete' WHERE id = '$taskId'";
		$data = $conn->query($query);
		if ($data->rowCount() > 0) {
 			echo "complete";
		}
	}
	$conn = NULL;
?>
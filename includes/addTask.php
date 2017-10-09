<?php 
	$task = strip_tags( $_POST['task'] );
	$date = date('Y-m-d');
	$time = date('H:i:s');
	$status = 'pending';

	require("connect.php");
	$query = "INSERT INTO todo (task, date, time, status) VALUES ('$task', '$date', '$time', '$status')";
    $conn->query($query);
	$sql = "SELECT * FROM todo WHERE task='$task' and status = '$status' and date='$date' and time='$time'";
	$data = $conn->query($sql);
	if ($data->rowCount() > 0) {

		foreach ($data as $row) {
			$taskId = $row['id'];
			$taskName = $row['task'];
		}
	}
	$conn = NULL;

	echo'<tr id="div'.$taskId.'">
					<td>'.$taskName.'</td>
					<td><img class="complete-task" src="images/mark.png" title="Mark as Complete" id="'.$taskId.'" /></td>
					<td><img id="'.$taskId.'" class="delete-task" src="images/delete.png" title="Delete"/></td>
					</tr>';
?>
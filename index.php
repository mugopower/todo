<html>
<head>
	<title>To-do List (XHR)</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<p><i>A Sample to-do list that create, delete, mark as complete and mark all as complete using</i> <b>XHR</b></p>
	<form class="add-new-task">
		<input id="all" type="button" name="all" value="Mark all as complete" />	
		<hr>

		<table class="inner">
			<tbody id="to-dolist">
				<tr style="text-align: left">
					<th>To-do Task</th>
					<th>Mark as comlete</th>
					<th>Delete</th>
				</tr>
			<?php 
				require("includes/connect.php");
				$query = "SELECT * FROM todo WHERE status = 'pending' ORDER BY date ASC, time ASC";
				$data = $conn->query($query);
				if ($data->rowCount() > 0) { 
				foreach ($data as $row) {
					$taskId = $row['id'];
					$taskName = $row['task'];

					echo'<tr id="div'.$taskId.'">
						<td>'.$taskName.'</td>
						<td><img class="complete-task" src="images/mark.png" title="Mark as Complete" id="'.$taskId.'" /></td>
						<td><img id="'.$taskId.'" class="delete-task" src="images/delete.png" title="Delete"/></td>
						</tr>';
				}
			echo '</tbody>';
			} else {
				?>
				<tr id="no-task"><td><i>There is nothing to dispaly </i></td></tr>
				<?php
			}
			?>		
		</table>

		<input class="todo-text" id="newTask" name="new-task" type="text" placeholder="Add new task here..." autocomplete="off" />
		<input type="submit" name="submit" value="Add Task"/>
	</form>
	</div>
</body>
	<!-- Sweetalert2 & JavaScript  files-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.css" rel="stylesheet"> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.js"></script> 
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
		
		addTask(); // Calls the addTask function
		deleteTask(); // Calls the deleteTask function
		completeTask(); // Calls the completeTask function

		function addTask() {

			$('.add-new-task').submit(function(){

				var toDo = $('#newTask').val();
				if(toDo != ''){
					$.post('includes/addTask.php', { task: toDo }, function( data ) {
						$('#no-task').remove();					
						$(data).appendTo('#to-dolist').hide().fadeIn();
						deleteTask();
						completeTask();
						$('#newTask').val('');	
					});
				swal({
				  title: 'Added!',
				  text: 'Task created successfully',
				  type: 'success',
				  confirmButtonText: 'Cool'
				})
				return false; // Prevent form from submitting twice
				} else {
					swal({
					  title: 'Empty Field!',
					  text: 'You can not submit blank text',
					  type: 'error',
					  confirmButtonText: 'Okay'
					})
					return false; // Prevent form from submitting twice
				}				
			});
		}

		function completeTask() {
			$('.complete-task').click(function(){ //This fun() will mark a single as complete
				var element = $(this);
				var taskId = $(this).attr('id');
				swal({
					  title: 'Complete?',
					  text: "Are you done with this task?",
					  type: 'question',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Complete'
				}).then(function () {
					$.post('includes/complete.php', { id: taskId }, function(data) {
						$('#div'+taskId).remove();
						if (data === "complete") {
							swal({
							  title: 'Completed!',
							  text: 'Task completed successfully',
							  type: 'success',
							})
						}	
					});					
				}, function (dismiss) {
				  if (dismiss === 'cancel') {
				   return false;
				  }
				})
			return false; // Prevent form from submitting twice
			});

			$('#all').click(function(){ //This fun() will mark all as complete
				var post = "all";
				$.post('includes/complete.php', { id: post }, function(data) {
					$('#to-dolist').remove();
					$(data).appendTo('.inner').hide().fadeIn();
					if (data === "complete") {
						swal({
						  title: 'Completed!',
						  text: 'All tasks were marked as complete successfully',
						  type: 'success',
						})
					}	
				});
			});
		}

		function deleteTask() {
			$('.delete-task').click(function(){
				var element = $(this);
				var taskId = $(this).attr('id');
				swal({
					  title: 'Are you sure?',
					  text: "This task will be deleted permanently!",
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'delete'
				}).then(function () {
					$.post('includes/deleteTask.php', { id: taskId }, function(resp) {
						if(resp === "deleted"){
							$('#div'+taskId).remove();
							swal(
							    'Deleted!',
							    'Your to-do task has been '+resp,
							    'success'
						 	)
						} 
						else {
							swal(
							    'Oppps!',
							    'Something went wrong.',
							    'error'
						 	)
						}
					});					
				}, function (dismiss) {
				  if (dismiss === 'cancel') {
				  		return false;
				  }
				})
			});
		}
	</script>

</html>
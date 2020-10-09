<?php
require 'database.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Speaker Portal</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
.right {
	background: #EC008C;
}
.left{
	background: #553483;
}
.message{
	color: #EC008C;
}
.connectedSortable {
	columns: 2;
	column-width: 200px;
	list-style-type: none;
	height: auto;
	margin-top: 100px;
	background-color: #ededed;
	padding-top: 10px;
	padding-left: 10px;
	padding-right: 10px;
}
.connectedSortable li{

	height: 40px;
	margin-bottom: 10px;
	font-size: 20px;
	color: white;
	text-align: center;
}

.btn-primary,
.btn-primary:hover,
.btn-primary:active,
.btn-primary:visited,
.btn-primary:focus {
	margin-bottom: 10px;
	font-size: 15px;
	font-weight: bold;
	background-color: #ec008c;
	border-color: white;
}
</style>
<body>
	<?php
	if (isset($_POST['update'])) {
		foreach($_POST['positions'] as $position) {
			$index = $position[0];
			$newPosition = $position[1];

			$con->query("UPDATE grab_and_take SET position = '$newPosition' WHERE id='$index'");

		}
		exit('success');

	}
	?>	
	<div class="content">
		<?php require 'partials/header.php' ?>
		<div class="container" >

			<div>
				<ul class="connectedSortable col-md-5 mx-auto">
					<?php
					$sql = $con->query("SELECT id, things, position FROM grab_and_take ORDER BY position");
					while($data = $sql->fetch_array()) {
						if ($data["position"]<7) {		
							echo '<li data-index="'.$data['id'].'" data-position="'.$data['position'].'" class="left">'.$data['things'].'</li>';
						}
						else {
							echo '<li data-index="'.$data['id'].'" data-position="'.$data['position'].'" class="right">'.$data['things'].'</li>';
						}
					}
					?>
				</ul>
			</div>
			<div class="text-center"><button onclick="saveNewPositions()" class="btn btn-primary ">SAVE</button></div>
			<div class="text-center"><p id="output" class="message"></p></div>
		</div>
	</div>
	<?php require 'partials/footer.php' ?>
	
	<script
	src="http://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script
	src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
	integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
	crossorigin="anonymous"></script>

	<script type="text/javascript">
	$(document).ready(function () {
		$('.connectedSortable').sortable({
			update: function (event, ui) {
				$(this).children().each(function (index) {
					if ($(this).attr('data-position') != (index+1)) {
						$(this).attr('data-position', (index+1)).addClass('updated');
					}
				});			
			}
		});
	});

	function saveNewPositions() {
		var positions = [];
		$('.updated').each(function () {
			positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
			$(this).removeClass('updated');
		});


		$.ajax({
			url: 'grab_and_take.php',
			method: 'POST',
			dataType: 'text',
			data: {
				update: 1,
				positions: positions
			}, success: function () {
				var message = "Your list has been succesful saved.";
				document.getElementById('output').innerHTML = message;
			}
		});
	}
	</script>
</body>
</html>
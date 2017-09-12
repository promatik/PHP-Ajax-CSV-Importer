<?php

// Set fields
$fields = ['id', 'a', 'b', 'c'];


if(isset($_POST['row'])) {
	$mysqli = new mysqli('127.0.0.1', 'root', '', 'test');
	$row = json_decode($_POST['row']);

	// Set fields
	$values = [];
	foreach ($fields as $key => $value)
		$values[$value] = $row[$key];
	extract($values);

	// --------------------
	// Perform any operation here (ex: Database updates)
	// All the variables were extracted, so you can access them directly $id, $a, $b, $c
	// Ex: $id > 1, $a > "A1"
	var_dump($values);
	die();

	$result = $mysqli->query("UPDATE test SET data = $a WHERE id = $id");

	// --------------------
	if (!$result) {
		echo "Sorry, the connection to the database could not be established.";
		exit;
	}

	$result->free();
	$mysqli->close();

	die($id);
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>CSV Importer</title>

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<script>
			$(document).ready(function() {
				$.ajax({
					type: "GET",
					url: "data.csv",
					dataType: "text",
					success: function(data) {processData(data);}
				 });
			});

			// Parse CSV
			function processData(allText) {
				var list = [], row = 0, col = 0, char;
				for (var i = 0, length = allText.length; i < length; i++) {
					char = allText[i];
					switch(char) {
						case '\t':
							col++;
							break;
						case '\r':
						case '\n':
							if(allText[i+1] == '\n')
								i++;
							col = 0;
							row++;
							break;
						case '"':
							break;
						default:
							if(list[row] == undefined)
								list[row] = [];

							list[row][col] == undefined ? 
								list[row][col] = char :
								list[row][col] += char;
							break;
					}
				}

				function postCSVLine(row = 1) {
					$.post("", {row: JSON.stringify(list[row])})
						.done(function(data) {
							$(".console").scrollTop($("pre").append("<p>" + data + "</p>").height());
							$(".progress-bar").width( 100 * row / (list.length-1) + "%" );
							$("#results").text(row + " / " + (list.length-1));
							if(row < list.length-1)
								postCSVLine(row + 1);
						});
				}

				$("#results").text("0 / " + (list.length-1));
				postCSVLine();
			}
		</script>
		<style>
			body {
				background-color: #EEE;
			}
			.container {
				background-color: #FFF;
				max-width: 800px;
				padding: 20px 40px;
				margin: 40px auto;
				border-radius: 2px;
				box-shadow: 0px 1px 4px rgba(0,0,0,0.1);
			}
			.console {
				background-color: rgba(15, 15, 15, 0.9);
				padding: 10px;
				height: 320px;
				overflow-y: scroll;
			}
			pre {
				background-color: transparent;
				border: 0;
				color: #0b0;
			}
			.progress-bar {
				transition: initial;
				width:0%
			}
		</style>
	</head>
	<body>
		<section class="container">
			<div class="panel-heading">CSV Ajax Importer</div>
			<div class="panel-body">
				<p id="results">0 / 0</p>
				<div class="progress">
					<div class="progress-bar" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</section>
		<section class="console container">
			<pre></pre>
		</section>
		</div>
	</body>
</html>

<html>
	<head>
		<title>Adapt</title>
		<script src="pipes.js"></script>
	</head>

	<body>
		<table>
			<tr>
				<td colspan="3">
					<h3>Home</h3>
				</td>
				<td id="home-divider" rowspan="2">
					<div><hr height="100%" width="5px"></div>
				</td>
				<td rowspan="2">
					<div id="page-inside">
						<pipe ajax="init.php" insert="page-inside">
					</div>
				</td>
			</tr>
			<tr>
				<td rowspan="2">
					<div id="navbar">
					<!-- Menu contents always here-->
						<pipe ajax="navbar.php" insert="navbar">
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>
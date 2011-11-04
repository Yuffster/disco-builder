<!DOCTYPE HTML>
<html>

	<head>
		<title>Disco Map Editor</title>
		<link rel="stylesheet" href="styles/main.css" />
		<link rel="stylesheet" href="styles/tiles/tiles.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
	</head>

	<body>

<header>
	<navigation>
		<ul>
			<li><a href="?action=map&zone=1">Map</a></li>
			<li><a href="?action=npcs&zone=1">NPCs</a></li>
			<li><a href="?action=items&zone=1">Items</a></li>
		</ul>
	</navigation>
</header>

<div id="content">
	<?= yield(); ?>
</div>
<footer>
	<p>&copy; 2010 Michelle Steigerwalt.</p>
</footer>

</body>
</html>

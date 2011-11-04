<!DOCTYPE HTML>
<html>

	<head>
		<title>Disco Map Editor &mdash; Installation</title>
		<link rel="stylesheet" href="styles/main.css" />
	</head>

	<body>

	<header>
		<p>Installation</p>
	</header>

	<div id="install">

		<? if (!$_POST): ?>

		<h1>Disco Map Editor &mdash; Installation</h1>

		<p>Thank you for downloading the Disco Map Editor!</p>

		<p>Currently, this application supports the following output formats:</p>

		<ul>
			<li>DikiMUD/CircleMUD + derivations</li>
			<li>JSON</li>
		</ul>

		<p>
			<b>Note:</b> DiscoMUD format can be obtained by running the generated
			CircleMUD files through the DiscoMUD/CircleMUD converter script,
			written in Ruby and available
			<a href="http://github.com/Yuffster/disco-converter-circle">here</a>.
		</p>

		<h2>Let&rsquo;s Install!</h2>

		<? $showForm = true; ?>

	<? else: ?>

		<?
		try {
			include("src/create_tables.php"); 
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		?>

		<?if ($error):?>

			<h1 class="error">Installation Error</h1>

			<p class="error"><?=$error?></p>

			<?$showForm=true;?>

		<?else:?>

			<h1>Installation Complete</h1>


		<?endif;?>

	<? endif; ?>

	<? if ($showForm) : ?>

		<form action="" method="post">

			<fieldset class="standalone">

				<legend>MySQL Configuration</legend>

				<div class="info">
					<p>
						This application uses a MySQL database.  In order to
						install, you must provide valid connection information.
					</p>
					<p>
						For more information on how to create and use MySQL
						databases, contact your server administrator, hosting
						company, or friend who knows a lot about computers.
					</p>
				</div>
				<? $fill = ($_POST) ? $_POST : Array('prefix'=>'disco_'); ?>
				<? $form = Array(
						'Server Location'=>'server',
						'Username'=>'user',
						'Password'=>'password',
						'Database'=>'database',
						'Table Prefix'=>'prefix'
					);
					foreach ($form as $label=>$name):
				?>
					<label for="<?=$label?>"><?=$label?>: </label>
					<input type="text" name="<?=$name?>" value="<?=@$p[$name]?>" />
				<?endforeach;?>	
			</fieldset>

			<button type="submit" class="ok">
				<span>Finish Installation</span>
			</button>

		</form>

	<? endif; ?>

	</div>

	<footer>
		<p>&copy; 2010 Michelle Steigerwalt.</p>
	</footer>

	</body>

</html>

<? if(isset($index)): ?>

	<h2>Zones</h2>
	<ul>
	<?foreach ($index as $item):?>
		
		<li><a href="index.php?action=map&zone=<?=$item->id?>"><?=$item->name?></a></li>
		
	<?endforeach;?>
	</ul>
	
<? die(); endif; ?>

<? $level = (isset($_GET['level'])) ? $_GET['level'] : 0; ?>
<h2><?=$zone->name?> (<?= ($level==0) ? "Ground Level" : "Level $level";?>)</h2>
<div id="mapPane">

	<?= $zone->outputMap($level); ?>

</div>

<div id="editor">

</div>

<script type="text/javascript">
$$('td').addEvent('click', function(e) {
	$$('td.active').removeClass('active');
	this.addClass('active');
	var editLink = this.getElement('.edit-link').get('href');
	var req  = new Request.HTML({url:editLink, update:$('editor')}).send();
});
$('editor').addEvent('submit', function(e) {
	e.stop();
	this.addClass('loading');
	var form = this.getElements('form');
	form.set('send', {onComplete:function(response) {
		$('editor').set('html', response).removeClass('loading');
	}}).send();
});
</script>

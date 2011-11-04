<? $room_id = $_GET['id']; $zone_id = $_GET['zone']; ?>
<? if ($room_id) {
	$mode = "edit";
	$room = Room::find($room_id);
	if (!$room) throw new Exception("Can't find room for ID $room_id.");
} elseif($_GET['coords'] && $_POST) {
   	list($x,$y,$z) = explode(',', $_GET['coords']);
   	$room = Room::createByCoords($zone_id, $x,$y,$z);
} elseif (!isset($_GET['coords'])) {
	throw new Exception("Need coordinates or a room ID to continue.");
}
?>
<? if ($_POST): ?>
	<?foreach ($_POST as $k=>$v) $room->$k = $v; ?>
	<? $room->save(); ?>
	Successfully saved room.
<? endif; ?>

<? $roomy = ($room_id) ? "id=$room->id" : "coords=$_GET[coords]"; ?>
<form class="compact" method="post" action="?action=room&<?=$roomy?>&zone=<?=$zone_id?>">

	<fieldset>
		<legend>Basic Data</legend>
		<label for="short">Room Title</label>
		<input type="text" name="short" value="<?=$room->short?>">
		<label for="long">Long Description</label>
		<textarea name="long"><?=$room->long?></textarea>
		<label for="type">Type</label>
		<select name="type">
			<? $s = 'selected="true"'; $v=$room->type; ?>
			<option value="0" <?=($v==0)?$s:''?>>outside</option>
			<option value="1" <?=($v==1)?$s:''?>>inside</option>
			<option value="2" <?=($v==2)?$s:''?>>water</option>
		</select>
	</fieldset>

	<fieldset class="exits">

		<legend>Exits</legend>

		<?$exits = Array(
			'n' =>'north', 's' =>'south', 'e' =>'east', 'w' =>'west',
			'u' =>'up', 'd' =>'down'
		); ?>
		<?foreach ($exits as $k=>$v): ?>
			<label for="exit_<?=$k?>"><?=$v?></label>
			<?$prop = "exit_$k"; $val = $room->$prop; $s = 'selected="true"'; ?>
			<select name="exit_<?=$k?>">
				<option value="0" <?=($val==0)?$s:''?>>blocked (not an exit)</option>
				<option value="1" <?=($val==1)?$s:''?>>open</option>
				<option value="2" <?=($val==2)?$s:''?>>door</option>
			</select>
		<?endforeach;?>
	</fieldset>

	<button type="submit" class="ok">
		<span><?= ($mode=="edit") ? "Save Changes" : "Create Room"?></span>
	</button>
	<button type="submit" class="delete"><span>Delete Room</span></button>

</form>

<?php

class Room extends DataModel {

	protected $fields = Array(
		'zone_id', 'x', 'y', 'z', 'short', 'long', 'type',
		'exit_n', 'exit_s', 'exit_w', 'exit_e', 'exit_u', 'exit_d',
		'exit_ne', 'exit_se', 'exit_sw', 'exit_nw'
	);

	protected $table = 'room';

	protected function fill($arr) {
		return new Room($arr);
	}

	public function find($arr) {
		if (is_numeric($arr)) $arr = Array('id'=>$arr);
		$data = Database::selectFirst('room', $arr);
		if (!$data) return false;
		return self::fill($data);
	}

	public function getByCoords($zone, $x,$y,$z=0) {
		if (!$zone) throw new Exception("No zone ID provided!");
		$arr = Array('x'=>$x, 'y'=>$y, 'z'=>$z, 'area_id'=>$zone);
		return Database::selectFirst('room', $arr);
	}

	public function createByCoords($zone, $x,$y,$z=0) {
		$arr = Array('area_id'=>$zone, 'x'=>$x, 'y'=>$y, 'z'=>$z);
		$room = self::getByCoords($zone, $x,$y,$z);
		if (!$room) {
			$new_room = new Room($arr);
			$new_room->save();
			$room = self::find($arr);
			if(!$room) throw new Exception("Failed to create room.");
		} return $room;
	}

	public function findAll($arr) {
		$data = Database::select('room', $arr);
		if (!$data) return false;
		$objs = Array();
		foreach ($data as $r) $objs[] = self::fill($r);
		return $objs;
	}

	public function getTypeName() {
		$types = Array('outside', 'inside', 'water');
		return $types[$this->properties['type']];
	}

	protected function getExits() {
		$exits = Array('n','s','e','w','u','d');
		$types = Array('wall', 'open', 'door');
		$retrn = Array();
		foreach ($exits as $e) { 
			$key = "exit_$e";
			$retrn[$e] = $types[$this->$key];
		}
		return $retrn;
	}

}

?>

<?php

class Zone extends DataModel {

	protected $table = 'area';
	protected $fields = Array('name', 'size_x', 'size_y');
	protected $rooms = Array();

	public function outputMap($z=0) {
	
		$rows = $this->size_y;
		$cols = $this->size_x;

		$this->getRooms();

		$y = 1;
		$str = "<table id='map'>";
		while ($y<=$rows) {
			$str .= "<tr>";
			$x = 1;
			while ($x<=$cols) {	
				$room = $this->getRoom($x,$y,$z);
				$link = "?action=room&zone=$this->id";
				if ($room) {
					$class = $room->typeName." ";
					foreach ($room->exits as $dir=>$type) {
						$class .= $type."-".$dir." ";
					}
					$link .= "&id=$room->id";
					$title = "[$room->x,$room->y] $room->short";
				} else { 
					$class = 'empty';
					$link .= "&coords=$x,$y,$z";
				}
				$str .= "<td id='$x-$y-$z'><div title=\"$title\" class='tile $class'>";
				$str .= '<a class="edit-link" href="'.$link.'">x</a>';
				$str .= "</div></td>";
				$x++;
			}
			$str .= "</tr>";
			$y++;
		}
		$str .="</table>";
		return $str;
		
	}

	protected function getRooms() {
		$rooms = Room::findAll(Array('area_id'=>$this->id));
		if (!$rooms) return;
		foreach ($rooms as $room) { 
			$this->addRoom($room);
		}
	}

	protected function getRoom($x,$y,$z=0) {
		if (!isset($this->rooms[$x])) return false;
		if (!isset($this->rooms[$x][$y])) return false;
		if (!isset($this->rooms[$x][$y][$z])) return false;
		return $this->rooms[$x][$y][$z];
	}

	protected function addRoom($room) {
		$x = $room->x; $y = $room->y; $z = $room->z;
		if (!is_array($this->rooms[$x])) $this->rooms[$x] = Array();
		if (!is_array($this->rooms[$x][$y])) $this->rooms[$x][$y] = Array();
		$this->rooms[$x][$y][$z] = $room;
	}

	protected function fill($arr) {
		return new Zone($arr);
	}

	public function find($arr) {
		if (is_numeric($arr)) $data = Database::selectFirst('area', Array('id'=>$arr));
		$data = Database::selectFirst('area', $arr);
		if (!$data) return false;
		return self::fill($data);
	}
	
	public function findAll($arr) {
		$data = Database::select('area', $arr);
		if (!$data) return false;
		$objs = Array();
		foreach ($data as $r) $objs[] = self::fill($r);
		return $objs;
	}

}

?>

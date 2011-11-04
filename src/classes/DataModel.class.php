<?

class DataModel {

	protected $id = false;
	protected $table = null;
	protected $properties;
	protected $fields;

	private   $db;

	public function __construct($properties) {
		$this->db = Database::init();	
		$this->properties = $properties;
		if ($this->properties['id']) {
			$this->id = $this->properties['id'];
			unset($this->properties['id']);
		}
	}

	public function __set($k, $v) {
		if (in_array($k, $this->fields)) $this->properties[$k] = $v;
		else throw new Exception("Trying to set nonexistent key $k.");
	}

	public function __get($k) {
		$getMeth = "get$k";
		if ($k=='id') return $this->id;
		if (method_exists($this, $getMeth)) return $this->$getMeth();
		if (isset($this->properties[$k])) return $this->properties[$k];
	}
	
	public function find() { }

	public function findAll() { }

	public function save() {
		if (!$this->id) { $this->db->insert($this->table, $this->properties); }
		else { $this->db->update($this->table, $this->properties, $this->id); }
	}

}

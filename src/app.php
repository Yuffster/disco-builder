<?

function __autoload($class) {
	include("classes/$class.class.php");
};

include('config.php');

/**
 * The yield function determines what our handler should be, then gets all
 * the relevant contextual variables and finally loads the handler file.
 * 
 * When an AJAX request is made, only the handler file is included.  When a
 * page is loaded normally, the handler file is included as part of the main
 * template.
 *
 * This method may also be used to insert submodules.
 */
function yield($action=null) {	

	$zone_id = (isset($_GET['zone'])) ? $_GET['zone'] : '';

	if ($zone_id) $zone = Zone::find($zone_id);
	else $index = Zone::findAll();
	
	if (!$action) {
		$action = (isset($_GET['action'])) ? $_GET['action'] : 'index';
	}

	if ($zone_id && !$zone) {
		return "Zone not found: ".$zone_id;
	}

	include("handlers/$action.php");

}

$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

//If we're making an AJAX request, we only want to include our specific module.
//Otherwise, we'll include the template and put the module within it.
if (!$ajax) include('handlers/main.php');
else yield();

?>

<?

namespace Reservat;

class OverrideFactory {

	protected static $_defaults = ["OpeningTimes\Overrides\On"];
	protected $_overrides = [];

	public function __construct(){
		foreach(self::$_defaults as $default){

			if(is_string($default) and !class_exists($default)){
				throw new \InvalidArgumentException("Class {$default} does not exist!");
			} elseif(!in_array('OpeningTimes\Overrides\OverrideInterface', class_implements($default))) {
				throw new \InvalidArgumentException("{$default} does not comply with OpeningTimes\Overrides\OverrideInterface");
			}

			$this->_overrides[$default] = is_string($default) ? new $default() : get_class($default);
		}

	}

	public static function add(){
		// TODO: If we require to add more custom overrides
	}

	public function apply($days, $overrides){
		$calculatedHours = [];
		foreach($this->_overrides as $override){
			$calculatedHours = $override->apply($days, $overrides);
		}
		return $calculatedHours;
	}

}
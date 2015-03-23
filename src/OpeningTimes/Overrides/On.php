<?

namespace OpeningTimes\Overrides;

use OpeningTimes\Overrides\OverrideInterface;

class On extends CoreOverride implements OverrideInterface {

	protected $_typeId = 'on';

	public function getTypeId() {
		return $this->_typeId;
	}

	public function apply($days, $overrides) {

		// get all user over-rides of type 'On'
		$overrides = $this->filterOverrideItems($overrides);

		foreach($days as &$day){
			foreach($overrides as $override){
				if($day['date']->format('m-d-Y') == $override['date']){
					$day['hours'] = $override['data'];
				}
			}
		}

		return $days;

	}

	
}
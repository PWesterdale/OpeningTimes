<?

namespace Reservat\Overrides;

class CoreOverride {

	public function filterOverrideItems($overrides) {

		$object = $this;

		return array_filter($overrides, function ($override) use ($object) {
            return $override['type'] === $object->getTypeId();
        });

	}

}
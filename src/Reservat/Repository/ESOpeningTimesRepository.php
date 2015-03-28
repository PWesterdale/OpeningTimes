<?

namespace Reservat\Repository;

use Reservat\Core\Interfaces\RepositoryInterface;
use Elasticsearch\Client;

class ESOpeningTimesRepository implements RepositoryInterface
{
	protected $client = null;

	public function __construct(Client $client){
		$this->client = $client;
	}

	public function getById($id)
	{

	}

	public function getAll()
	{

	}
}
<?php
namespace App\Traits;

trait QueryFilters
{
	private $query;
	private $paginate;
	private $per_page = 10;
	private $orderBy; //Order by from request
	private $order;
	public function filters($query, $filters, $orderBy = [], $queryType = 'all')
	{
		$this->filter($query, $filters);
		$this->order($this->query, $orderBy);
		$this->get($this->query, $queryType);
		return $this->query;
	}

	public function filter($query, $filters)
	{
		$this->query = $query;
		$this->paginate = $filters['paginate'] ?? false;
		$this->orderBy = $filters['orderBy'] ?? false;
		$this->order = $filters['order'] ?? false;
		$this->per_page = $this->getFiltersPagesize($filters);
		$filters = $this->cleanFilters($filters);

		//set filters
		foreach ($filters as $key => $value) {
			if($value == "null") {
				$this->query = $this->query->orWhere($key, null);
			} else {
				switch (gettype($value)) {
					case 'integer':
							$this->query = $this->query->orWhere($key, $value);
						break;
					case 'string':
							$this->query = $this->query->orWhere($key, "like", "%".$value."%");
						break;
				}
			}
		}
		return $this->query;
	}

	/**
	 * [order Para el ordenado tiene prioridad más alta el ordenado mandado por el cliente.
	 * Si el recurso tiene un ordenado establecido se puede reemplazar]
	 * @param  [type] $query      [description]
	 * @param  array  $orderArray [description]
	 * @return [type]             [description]
	 */
	public function order($query, $orderArray = [])
	{
		$this->query = $query;
		if($this->orderBy) {
			$this->query = $this->query->orderBy($this->orderBy, $this->order);
		}
		else {
			//Set data order using order array
			foreach ($orderArray as $key => $value) {
				$this->query = $this->query->orderBy($key, $value);
			}
		}
		return $this->query;
	}

	public function get($query, $queryType = 'all')
	{
		$this->query = $query;
		switch ($queryType) {
			case 'all':
				//Set pagination
				if($this->paginate)
					$this->query = $this->query->paginate($this->per_page);
				else
					$this->query = $this->query->get();
				break;
			case 'first':
				$this->query = $this->query->first();
				break;
			default:
				// code...
				break;
		}
		return $this->query;
	}

	public function getFiltersPagesize($filters)
	{
		$p = $filters['per_page'] ?? $this->per_page;
		if(isset($p)) {
			$p = ($p > 0 && $p <= 50) ? $p : $this->per_page;
		}
		return $p;
	}

	public function cleanFilters($filters, $revoveWords = null)
	{
		$words = $revoveWords ?? ['paginate', 'per_page', 'page', 'orderBy', 'order'];
		foreach ($words as $key => $word) {
			unset($filters[$word]);
		}

		return $filters;
	}
}
<?php

namespace App\Response;

use \Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse
{
	public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
	{
		$headers['Content-Type'] = $headers['Content-Type'] ?? 'application/json';

		parent::__construct($data, $status, $headers, $json);
	}
}

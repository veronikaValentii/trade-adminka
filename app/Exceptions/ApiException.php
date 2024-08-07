<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{

    /**
     * ApiException constructor.

     * @param array $additionResponse
     * @param int $httpCode
     */
    public function __construct(private readonly array $additionResponse = [], private readonly int $httpCode = 500)
    {
        parent::__construct( $additionResponse['message'] ?? '', $httpCode);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function render() : JsonResponse
    {
        return ApiResponse::sendResponse(
            $this->additionResponse,
            $this->httpCode
        );
    }

}

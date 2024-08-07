<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * @param Validator $validator
     *
     * @throws ApiException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = [];

        foreach ($validator->errors()->toArray() as $key => $error) {
            $this->insertElement($errors, $key, $error);
        }
        throw new ApiException(
            ['fields' => $errors],
            422);
    }

    /**
     * @param array $array
     * @param string $path
     * @param mixed $value
     * @return void
     */
    protected function insertElement(array &$array, string $path, mixed $value): void
    {
        $keys = explode('.', $path);
        $current = &$array;
        foreach ($keys as $key) {
            if (! isset($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }

        $current = $value;
    }


    /**
     * @throws ApiException
     */
    protected function failedAuthorization()
    {
        throw new ApiException(httpCode: 403);
    }
}

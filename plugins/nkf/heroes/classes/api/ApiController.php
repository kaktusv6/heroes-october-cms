<?php declare(strict_types=1);

namespace Nkf\Heroes\Classes\Api;

use Illuminate\Http\JsonResponse;
use Nkf\Heroes\Api\ApiException;
use Nkf\Heroes\Classes\Formatter;
use Validator;

abstract class ApiController
{
    public function responseJson($data): JsonResponse
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        return response()->json(['errors' => [], 'data' => $data]);
    }

    public function getJsonData()
    {
        return json_decode(request()->getContent(), true);
    }

    public function getValidateJsonData($rules)
    {
        $data = $this->getJsonData();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ApiException($validator->messages()->first());
        }
        return $data;
    }

    public function responseFormatList($list, Formatter $formatter): JsonResponse
    {
        return $this->responseJson($formatter->formatList($list));
    }

    public function responseFormatData($data, Formatter $formatter): JsonResponse
    {
        return $this->responseJson($formatter->format($data));
    }

    public function getToken(): ?string
    {
        return request()->bearerToken();
    }
}

<?php

namespace App\Traits;

trait GeneralTrait
{
    public function returnError($status_code = 500, $message = 'something went wrong, caught yah!')
    {
        return response()->json(
            [
                'status' => false,
                'status_code' => $status_code,
                'message' => $message,
            ],
            $status_code,
        );
    }

    public function returnData($data, $status_code = \Illuminate\Http\Response::HTTP_OK, $msg = '', $pagination = false, $collectionToPaginate = null)
    {
        if ($pagination && !$data->isEmpty()) {
            $collection = $this->paginate($data, null);
            return response()->json(
                [
                    'status' => "Success",
                    'status_code' => $status_code,
                    'message' => $msg,
                    'data' => $collection,
                    'pagination' => collect($collection)
                        ->forget('data')
                        ->forget('next_page_url')
                        ->forget('prev_page_url')
                        ->forget('path')
                        ->forget('links')
                        ->forget('last_page_url')
                        ->forget('first_page_url')
                ],
                $status_code
            );
        } else {
            if ($collectionToPaginate != null) {
                $collection = $this->paginate($collectionToPaginate, null);
                return response()->json(
                    [
                        'status' => "Success",
                        'status_code' => $status_code,
                        'message' => $msg,
                        'data' => $data,
                        'pagination' => collect($collection)
                            ->forget('data')
                            ->forget('next_page_url')
                            ->forget('prev_page_url')
                            ->forget('path')
                            ->forget('links')
                            ->forget('last_page_url')
                            ->forget('first_page_url')
                    ],
                    $status_code
                );
            } else {
                return response()->json(
                    [
                        'status' => "Success",
                        'status_code' => $status_code,
                        'message' => $msg,
                        'data' => [
                            'data' => $data
                        ],
                    ],
                    $status_code
                );
            }
        }
    }

}

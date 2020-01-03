<?php
namespace BodeLocke\Rotessa;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Request
{
    public function __construct()
    {
        $this->client = new Client();
    }

    private function getEndPoint($case, $id = null)
    {
        $uri = config('rotessa.uri');

        switch ($case) {
            case 'create_customer':
                return $uri . '/customers.json';
                break;
            case 'customer':
                return $uri . '/customers/' . $id . '.json';
                break;
            case 'update_customer':
                return $uri . '/customers/update_via_post.json';
                break;
            case 'all_customers':
                return $uri . '/customers.json';
                break;
            case 'create_transaction':
                return $uri . '/transaction_schedules.json';
                break;
            case 'transaction':
                return $uri . '/transaction_schedules/' . $id . '.json';
                break;
            case 'update_transaction':
                return $uri . '/transaction_schedules/' . $id . '.json';
                break;
            case 'delete_transaction':
                return $uri . '/transaction_schedules/' . $id . '.json';
                break;
            // case 'report':
            //     return $uri . '/transaction_report';
            //     break;
        }
    }

    private function getHeaders()
    {
        return  [
            "Content-Type"  => "application/json",
            "Authorization" => "Token token=" . config('rotessa.key')
        ];
    }

    public function get($type, $id)
    {
        try {
            return  $this->response(
                        $this->client->get(
                            $this->getEndPoint($type, $id),
                            ['headers' => $this->getHeaders()]
                        )
                    );
        } catch (RequestException $e) {
            return $this->getErrors($e);
        }
    }

    public function post($type, $data)
    {
        try {
            return  $this->response(
                        $this->client->post(
                            $this->getEndPoint($type, null),
                            ['json' => $data, 'headers' => $this->getHeaders()]
                        )
                    );
        } catch (RequestException $e) {
            return $this->getErrors($e);
        }
    }

    public function patch($type, $data)
    {
        try {
            return  $this->response(
                        $this->client->patch(
                            $this->getEndPoint($type, $data['transaction_id']),
                            ['json' => $data, 'headers' => $this->getHeaders()]
                        )
                    );
        } catch (RequestException $e) {
            return $this->getErrors($e);
        }
    }

    public function delete($type, $id)
    {
        try {
            return  $this->response(
                        $this->client->delete(
                            $this->getEndPoint($type, $id),
                            ['headers' => $this->getHeaders()]
                        )
                    );
        } catch (RequestException $e) {
            return $this->getErrors($e);
        }
    }


    private function response($response)
    {
        $data = json_decode($response->getBody()->getContents());
        if($data == null){
            return ['success' => 'Transaction deleted'];
        }
        if (is_countable($data) && count($data) > 0) {
            $data = collect($data)->map(function ($d) {
                return collect($d)->toArray();
            })->toArray();
        } else {
            $data = collect($data)->map(function ($d) {
                if (is_object($d)) {
                    return collect($d)->toArray();
                } else {
                    return $d;
                }
            })->toArray();
        }
        return $data;
    }

    private function getErrors($e)
    {
        if ($e->hasResponse()) {
            $error = $e->getResponse();
            return [
                'error_code' => $error->getStatusCode(),
                'message'    => $error->getReasonPhrase()
            ];
        } else {
            return [
                'error_code' => 'unknow error'
            ];
        }
    }

}

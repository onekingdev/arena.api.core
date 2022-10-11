<?php


namespace App\Services\Soundblock;

use GuzzleHttp\{Client, Exception\RequestException};
use App\Contracts\Soundblock\Ledger as LedgerContract;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;

class Ledger implements LedgerContract {

    const TABLE_LIST_URI = "/tables";

    const GET_TABLE_DOCUMENTS = "/table/%s/documents";

    const TABLE_DOCUMENT_URI = "/table/%s/document/%s";

    const DOCUMENT_URI = "/table/%s/document";

    const TABLE_URI = "/table/%s";

    const PING_URI = "/ping";

    /**
     * @var Client
     */
    private Client $http;

    private string $host;

    public function __construct($host, $token) {
        $this->host = $host;

        $this->http = new Client([
            "base_uri" => $host,
            "headers" => ["X-AUTH-TOKEN" => $token]
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getTablesList(): array {
        try{
            $response = $this->http->get(self::TABLE_LIST_URI);

            return json_decode($response->getBody()->getContents(), true);
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @param array|null $fields
     * @return array
     * @throws \Exception
     */
    public function getTableDocuments(string $tableName, ?array $fields = null): array {
        try{
            $response = $this->http->get(sprintf(self::GET_TABLE_DOCUMENTS, $tableName), [
                "query" => ["fields" => is_array($fields) ? implode(",", $fields) : '']
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @param string $id
     * @param array|null $fields
     * @return array
     * @throws \Exception
     */
    public function getDocument(string $tableName, string $id, ?array $fields = null): array {
        try{
            $response = $this->http->get(sprintf(self::TABLE_DOCUMENT_URI, $tableName, $id), [
                "query" => ["fields" => is_array($fields) ? implode(",", $fields) : '']
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function insertDocument(string $tableName, array $data): array {
        try{
            $response = $this->http->post(sprintf(self::DOCUMENT_URI, $tableName), [
                "json" => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch(RequestException $clientException) {

            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @param string $id
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function updateDocument(string $tableName, string $id, array $data): array {
        try{
            $response = $this->http->put(sprintf(self::TABLE_DOCUMENT_URI, $tableName, $id), [
                "json" => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @param array|null $indexes
     * @return bool
     * @throws \Exception
     */
    public function createTable(string $tableName, ?array $indexes = null): bool {
        try{
            $response = $this->http->post(sprintf(self::TABLE_URI, $tableName), [
                "json" => $indexes
            ]);

            return true;
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }

    /**
     * @param string $tableName
     * @return bool
     * @throws \Exception
     */
    public function deleteTable(string $tableName): bool {
        try{
            $response = $this->http->delete(sprintf(self::TABLE_URI, $tableName));

            return true;
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteAllTables(): bool {
        try{
            $response = $this->http->delete(self::TABLE_LIST_URI);

            return true;
        } catch(RequestException $clientException) {
            $this->parseError($clientException);
        }
    }


    /**
     * @param RequestException $exception
     * @throws \Exception
     */
    private function parseError(RequestException $exception) {
        switch($exception->getCode()) {
            case 0:
                throw new LedgerMicroserviceException($exception->getMessage(), 503, $exception);
                break;
            case 404:
                throw new LedgerMicroserviceException("Not Found", 404, $exception);
                break;
            case 400:
                throw new LedgerMicroserviceException($exception->getResponse()->getBody()->getContents(), 400, $exception);
                break;
            default:
                throw new \Exception("Something Went Wrong.", 400, $exception);
                break;
        }
    }

    public function ping(): bool {
        try{
            $this->http->get(self::PING_URI);

            return true;
        } catch(RequestException $clientException) {
            return false;
        }
    }

    public function getHost(): string {
        return $this->host;
    }
}

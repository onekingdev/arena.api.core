<?php


namespace App\Exceptions\Core\Disaster;

use GuzzleHttp\Client;
use Throwable;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

abstract class DisasterExceptions extends \Exception {
    const AWS_METADATA_ID = "http://169.254.169.254/latest/meta-data/instance-id";

    /**
     * @var bool
     * */
    protected bool $isHttp = false;
    /**
     * @var bool
     * */
    protected bool $isCommand = false;
    /**
     * @var string|null
     * */
    protected $command;
    /**
     * @var string|null
     * */
    protected $endpoint;
    /**
     * @var string|null
     * */
    protected $httpMethod;
    /**
     * @var array|null
     * */
    protected $requestData;
    /**
     * @var User|null
     * */
    protected $user;
    /**
     * @var Client
     */
    private Client $httpClient;

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);

        if ($_SERVER["SCRIPT_NAME"] == "artisan") {
            $this->isCommand = true;

            $this->command = implode(" ", array_merge(["php"], $_SERVER["argv"]));
        } else {
            $this->isHttp = true;

            $this->endpoint = request()->fullUrl();
            $this->httpMethod = request()->method();
            $this->requestData = request()->all();
        }

        if (Auth::check()) {
            $this->user = Auth::user();
        }

        $this->httpClient = new Client();
    }

    public function getDetails(): array {
        $arrDetails = [
            "message"       => $this->getMessage(),
            "trace"         => $this->getTrace(),
            "traceAsString" => $this->getTraceAsString(),
            "code"          => $this->getCode(),
        ];

        if ($this->isHttp()) {
            $arrDetails["endpoint"] = $this->getEndpoint();
            $arrDetails["method"] = $this->getHttpMethod();
            $arrDetails["request"] = $this->getRequestData();
        } else if ($this->isCommand()) {
            $arrDetails["command"] = $this->getCommand();
        }

        return $arrDetails;
    }

    public function isHttp(): bool {
        return $this->isHttp;
    }

    /**
     * @return string|null
     */
    public function getEndpoint(): ?string {
        return $this->endpoint;
    }

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string {
        return $this->httpMethod;
    }

    /**
     * @return array|null
     */
    public function getRequestData(): ?array {
        return $this->requestData;
    }

    public function isCommand(): bool {
        return $this->isCommand;
    }

    /**
     * @return string|null
     */
    public function getCommand(): ?string {
        return $this->command;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getInstanceId(): ?string {
        if (app()->environment("testing", "local")) {
            return null;
        }

        $response = $this->httpClient->get(self::AWS_METADATA_ID);

        return $response->getBody()->getContents();
    }
}

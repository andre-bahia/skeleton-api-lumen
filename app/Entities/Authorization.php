<?php 

namespace App\Entities;

use Carbon\Carbon;

class Authorization 
{
    protected $token;

    protected $payload;

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        if (!$this->token) {
            throw new \Exception("Token is empty");
        }

        return $this->token;
    }

    public function getPayload()
    {
        if (!$this->payload) {
            $this->payload = \Auth::setToken($this->getToken())->getPayload();
        }

        return $this->payload;
    }

    public function getExpiredAt()
    {
        return Carbon::createFromTimestamp($this->getPayload()->get('exp'))->toDateTimeString();
    }

    public function getRefreshTtl()
    {
        return Carbon::createFromTimestamp($this->getPayload()->get('iat'))
                        ->addMinutes(config('jwt.refresh_ttl'))
                        ->toDateTimeString();
    }

    public function toArray()
    {
        return [
            "access_token" => $this->getToken(),
            "token_type" => "bearer",
            "expired_at" => $this->getExpiredAt(),
            "refresh_expired_at" => $this->getRefreshTtl() 
        ];
    }
}
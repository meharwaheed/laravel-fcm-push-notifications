<?php

namespace Waheed\LaravelFcmPushNotifications\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Waheed\LaravelFcmPushNotifications\Exceptions\InvalidTokenException;

class FcmMessage
{
    const PRIORITY = 'normal';

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $body;

    /**
     * @var string
     */
    private string $icon;

    /**
     * @var string
     */
    private string $image;

    /**
     * @var string
     */
    private string $sound;

    /**
     * @var string
     */
    private string $callToAction;

    /**
     * @var array
     */
    private array $additionalData;

    /**
     * @var string
     */
    public string $authenticationKey;

    /**
     * @var string
     */
    private string $priority = self::PRIORITY;

    /**
     * @var array
     */
    private array $fromArr;

    /**
     * @var array
     */
    private array $fromRaw;

    /**
     * Attach Message Title
     * @param $title
     * @return FcmMessage
     */
    public function withTitle($title): FcmMessage
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Attach Message Body
     * @param $body
     * @return FcmMessage
     */
    public function withBody($body): FcmMessage
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Attach Message Icon
     * @param $icon
     * @return FcmMessage
     */
    public function withIcon($icon): FcmMessage
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Attach Message Image
     * @param $image
     * @return FcmMessage
     */
    public function withImage($image): FcmMessage
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Attach Message Sound
     * @param $sound
     * @return FcmMessage
     */
    public function withSound($sound): FcmMessage
    {
        $this->sound = $sound;
        return $this;
    }

    /**
     * Attach Message Action
     * @param $callToAction
     * @return FcmMessage
     */
    public function withAction($callToAction): FcmMessage
    {
        $this->callToAction = $callToAction;
        return $this;
    }

    /**
     * Attach Message AdditionalData
     * @param $additionalData
     * @return FcmMessage
     */
    public function withAdditionalData($additionalData): FcmMessage
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    /**
     * @param $authenticationKey
     * @return $this
     */
    public function withAuthenticationKey($authenticationKey)
    {
        $this->authenticationKey = $authenticationKey;

        return $this;
    }

    /**
     * Attach Message Priority
     * @param $priority
     * @return FcmMessage
     */
    public function withPriority($priority): FcmMessage
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Attach Message FromArray
     * @param $fromArr
     * @return FcmMessage
     */
    public function fromArray($fromArr): FcmMessage
    {
        $this->fromArr = $fromArr;
        return $this;
    }

    public function fromRaw($fromRaw)
    {
        $this->fromRaw = $fromRaw;

        return $this;
    }

    public function sendNotification($tokens)
    {
        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'notification' => ($this->fromArr) ? $this->fromArr : [
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
                'icon' => $this->icon,
                'sound' => $this->sound,
                'click_action' => $this->callToAction
            ],
            // 'data' => $this->additionalData,
            'priority' => $this->priority
        );

        return $this->sendRequest($fields);
    }

    public function sendMessage($tokens)
    {
        $data = ($this->fromArr) ? $this->fromRaw : [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $data = $this->additionalData ? array_merge($data, $this->additionalData) : $data;

        $fields = array(
            'registration_ids' => $this->validateToken($tokens),
            'data' => $data,
        );

        return $this->sendRequest($fields);
    }

    public function send()
    {
        return $this->sendRequest($this->fromRaw);
    }

    private function sendRequest($fields)
    {
        $authenticationKey = isset($this->authenticationKey) ? $this->authenticationKey:config('larafcm.server_key');

        return Http::withHeaders([
            'Authorization' => 'key=' . $authenticationKey
        ])->post(config('larafcm.server_url') ?? 'https://fcm.googleapis.com/fcm/send', $fields);
    }

    /**
     * @throws InvalidTokenException
     */
    private function validateToken($tokens)
    {
        if (is_array($tokens)) {
            return $tokens;
        }

        if (is_string($tokens)) {
            return explode(',', $tokens);
        }

        throw new InvalidTokenException('Please pass tokens as array [token1, token2] or as string (use comma as separator if multiple passed).');
    }
}

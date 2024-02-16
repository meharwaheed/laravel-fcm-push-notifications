<?php

namespace Waheed\LaravelFcmPushNotifications\Messages;

use Waheed\LaravelFcmPushNotifications\Facades\LaraFcm;

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
    private string $priority = self::PRIORITY;

    /**
     * @var array
     */
    private array $fromArr;

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


    public function asNotification($deviceTokens)
    {
        if ($this->fromArr) {
            return LaraFcm::fromArray($this->fromArr)
                ->sendNotification($deviceTokens);
        }

        return LaraFcm::withTitle($this->title)
            ->withBody($this->body)
            ->withClickAction($this->callToAction)
            ->withImage($this->image)
            ->withIcon($this->icon)
            ->withSound($this->sound)
            ->withPriority($this->priority)
            ->withAdditionalData($this->additionalData)
            ->sendNotification($deviceTokens);
    }

    public function asMessage($deviceTokens)
    {
        if ($this->fromArr) {
            return LaraFcm::fromArray($this->fromArr)->sendMessage($deviceTokens);
        }

        return LaraFcm::withTitle($this->title)
            ->withBody($this->body)
            ->withAdditionalData($this->additionalData)
            ->sendMessage($deviceTokens);
    }
}

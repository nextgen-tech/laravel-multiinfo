<?php

declare(strict_types=1);

namespace NGT\Laravel\MultiInfo;

use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use InvalidArgumentException;
use LogicException;
use NGT\MultiInfo\Contracts\SendableRequest;
use NGT\MultiInfo\Handler;
use NGT\MultiInfo\Requests\SendSmsLongRequest;
use NGT\MultiInfo\Responses\ErrorResponse;
use Throwable;

class MultiInfoChannel
{
    public const CHANNEL_NAME = 'multiinfo';

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected Container $container;

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected Dispatcher $eventDispatcher;

    /**
     * The communication handler instance.
     *
     * @var \NGT\MultiInfo\Handler
     */
    protected Handler $handler;

    /**
     * The notification channel constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Contracts\Events\Dispatcher   $eventDispatcher
     * @param \NGT\MultiInfo\Handler                    $handler
     */
    public function __construct(
        Container $container,
        Dispatcher $eventDispatcher,
        Handler $handler
    ) {
        $this->container       = $container;
        $this->eventDispatcher = $eventDispatcher;
        $this->handler         = $handler;
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return bool
     */
    public function send($notifiable, Notification $notification): bool
    {
        try {
            $request     = $this->buildRequest($notification->toMultiInfo($notifiable)); // @phpstan-ignore-line
            $destination = $notifiable->routeNotificationFor(static::CHANNEL_NAME, $notification);

            if (empty($destination)) {
                throw new LogicException('Cannot send message without destination.');
            }

            $request->setDestination($destination);

            $response = $this->handler->handle($request);

            if ($response instanceof ErrorResponse) {
                throw new Exception($response->getMessage(), $response->getCode());
            }
        } catch (Throwable $e) {
            $this->eventDispatcher->dispatch(
                new NotificationFailed($notifiable, $notification, static::CHANNEL_NAME, [
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage(),
                ])
            );

            return false;
        }

        return true;
    }

    /**
     * Build MultiInfo request.
     *
     * @param mixed $request
     *
     * @return \NGT\MultiInfo\Contracts\SendableRequest
     */
    protected function buildRequest($request): SendableRequest
    {
        if ($request instanceof SendableRequest) {
            return $request;
        }

        $content = $this->getMessageContent($request);
        $origin  = $this->getMessageOrigin($request);

        if ($content === null) {
            throw new LogicException('Cannot send message without content.');
        }

        $request = $this->makeRequest();
        $request->setContent($content);

        if (!empty($origin)) {
            $request->setOrigin($origin);
        }

        return $request;
    }

    /**
     * Get the content of message.
     *
     * @param mixed $request
     *
     * @return string|null
     */
    protected function getMessageContent($request): ?string
    {
        if ($request instanceof MultiInfoMessage) {
            return $request->content;
        } elseif (is_string($request)) {
            return $request;
        }

        throw new InvalidArgumentException(sprintf(
            'Cannot get content from %s.',
            gettype($request)
        ));
    }

    /**
     * Get the origin of message.
     *
     * @param mixed $request
     *
     * @return string|null
     */
    protected function getMessageOrigin($request): ?string
    {
        if ($request instanceof MultiInfoMessage) {
            return $request->origin;
        }

        return null;
    }

    /**
     * Make request.
     *
     * @return \NGT\MultiInfo\Contracts\SendableRequest
     */
    protected function makeRequest(): SendableRequest
    {
        return $this->container->make(SendSmsLongRequest::class);
    }
}

<?php

declare(strict_types=1);

namespace NGT\Laravel\MultiInfo;

class MultiInfoMessage
{
    /**
     * The content of the message.
     *
     * @var string|null
     */
    public ?string $content = null;

    /**
     * The origin of the message.
     *
     * @var string|null
     */
    public ?string $origin = null;

    /**
     * Set the content of the message.
     *
     * @param string $content
     *
     * @return self
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the origin of the message.
     *
     * @param string $origin
     *
     * @return self
     */
    public function origin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }
}

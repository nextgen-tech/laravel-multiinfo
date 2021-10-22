# Laravel MultiInfo

MultiInfo integration for Laravel.

## Installation

```bash
composer require nextgen-tech/laravel-multiinfo
```

## Configuration

```
MULTIINFO_CONNECTION=                    # Connection type (http is the only one supported)
MULTIINFO_API_VERSION=                   # API version (api1 or api2)
MULTIINFO_CERTIFICATE_PUBLIC_KEY_PATH=   # Path to certificate public key
MULTIINFO_CERTIFICATE_PRIVATE_KEY_PATH=  # Path to certificate private key
MULTIINFO_CERTIFICATE_PASSWORD=          # Certificate password
MULTIINFO_CREDENTIALS_LOGIN=             # Service login
MULTIINFO_CREDENTIALS_PASSWORD=          # Service password
MULTIINFO_CREDENTIALS_SERVICE_ID=        # Service ID
```

Certificate needs to be in PEM format. You can convert P12 to PEM using this two scripts:

```sh
openssl pkcs12 -in "/path/to/cert.p12" -out public_key.pem -nocerts -nodes
openssl pkcs12 -in "/path/to/cert.p12" -out private_key.pem -clcerts -nokeys
```

## Usage

Via notification channel:

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Model
{
    use Notifiable;

    ...

    public function routeNotificationForMultiinfo(?Notification $notification): string
    {
        return $this->phone;
    }

    ...
}

// app/Notifications/ExampleNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NGT\Laravel\MultiInfo\MultiInfoMessage;

class ExampleNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['multiinfo'];
    }

    public function toMultIinfo($notifiable): MultiInfoMessage
    {
        return (new MultiInfoMessage())
            ->content('test message');
    }
}
```

Or directly via handler:

```php
use NGT\MultiInfo\Handler;
use NGT\MultiInfo\Requests\SendSmsRequest;

$handler = app(Handler::class);

$request = app(SendSmsRequest::class)
    ->setDestination('123123123')
    ->setContent('test message');

/** @var \NGT\MultiInfo\Responses\SendSmsResponse */
$response = $handler->handle($request);
```
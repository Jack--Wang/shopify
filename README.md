```php

$shopify = new NickyWoolf\Shopify\Shopify('example.myshopify.com');

$authorizeUrl = $shopify->authorize('client_id', 'scope', 'redirect_uri', 'nonce');

header("Location: {$authorizationUrl}");

```

```php

$shopify = new NickyWoolf\Shopify\Shopify('example.myshopify.com');

$response = $shopify->post('oauth/access_token', [
    'client_id' => 'your_client_id',
    'client_secret' => 'your_client_secret',
    'code' => $_GET['code'],
]);

$response->json();

```

```php

[
    'access_token' => 'VALID-ACCESS-TOKEN',
    'scope' => 'scope',
]

```


```php

$shopify = new NickyWoolf\Shopify\Shopify('example.myshopify.com', 'VALID-ACCESS-TOKEN');

$product = $shopify->get('products/1234567890.json')->json();

```

```php

[
    'product' => [
        'id' => 1234567890,
        'title' => 'Example Product',
        ...
    ],
]

```

```php

$product = $shopify->get('products/1234567890.json')->extract('product');

```

```php

[
    'id' => 1234567890,
    'title' => 'Example Product',
     ...
]

```
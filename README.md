Redirect the user to Shopify to get permission to access their shop's data.

```php

$shopify = new NickyWoolf\Shopify\Shopify('example.myshopify.com');

$authorizeUrl = $shopify->authorize('client_id', 'scope', 'redirect_uri');

header("Location: {$authorizationUrl}");

```

After the user allows access Shopify redirects them back to your whitelisted "redirect_uri." You can whitelist urls
in the app settings in your partner account.

Perform checks to make sure request came from Shopify. Finally, request an access token for the user.

```php

$request= new NickyWoolf\Shopify\Request('your_client_secret');

if (! $request->verify($_GET)) {
    // abort!
}

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

Make authorized requests with a valid access token.


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

Example of extracting the resource from the response.

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

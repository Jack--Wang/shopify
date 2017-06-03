```php

$shopify = new GroundRule\Shopify\Shopify('example.myshopify.com', 'VALID-ACCESS-TOKEN');

$product = $shopify->get('products/1234567890.json')->json();

// [
//     'product' => [
//         'id' => 123,
//         'title' => 'Example Product',
//         ...
//     ],
// ]

$product = $shopify->get('products/1234567890.json')->extract('product');

// [
//     'id' => 123,
//     'title' => 'Example Product',
//      ...
// ]

```
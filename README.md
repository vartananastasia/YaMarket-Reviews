# Ya Metrika for reviews

Uses:

``GuzzleHttp/6.2.1`` - http://docs.guzzlephp.org/en/stable/overview.html#installation
``curl/7.51.0`` 
``PHP/5.6.29``

1) Init new client ```$client = new Client('key_value', 11111)```
2) Get reviews by pages for id=11111 ```$client->get_reviews($page_number)```
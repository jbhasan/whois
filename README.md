# Domain Whois Information

You can get domain whois information

## Installation

You can install the package via composer:

```shell
composer require sayeed/whois
```

After installation need to publish vendor

```shell
php artisan vendor:publish --provider="Sayeed\Whois\WhoisServiceProvider"
```

## Uses

```
$whois = Whois::lookup('securesslcheck.com');

// output
^ array:8 [▼
  "tld" => "COM"
  "domain" => "SECURESSLCHECK.COM"
  "created" => "2025-03-07 06:49:26"
  "updated" => "2025-03-08 08:52:28"
  "expiry" => "2026-03-07 06:49:26"
  "registrar" => "Dynadot Inc"
  "status" => "ACTIVE"
  "name_server" => array:2 [▼
    0 => "NS1.DYNA-NS.NET"
    1 => "NS2.DYNA-NS.NET"
  ]
]
```

## Credits

- [Md. Hasan Sayeed](https://github.com/jbhasan)

Thank you for using it.

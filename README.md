# Posterboy

Posterboy was designed to be a lightweight package to make posting to webhook endpoints easy and painless.

## Installation

composer.json
```
"require": {
    ...
    "tmyers273/posterboy": "dev-master"
}
```

```
"repositories: [
    ...
    {
        "type": "vcs",
        "url":  "git@github.com:tmyers273/posterboy.git"
    }
]
```

config/app.php
```
tmyers273\posterboy\PosterboyServiceProvider::class,
```



```
php artisan vendor:publish
```


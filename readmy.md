# Eloquent Table

Komponent do prostego tworzenia tabelek.

* [Instalacja](#Instalacja_7)
    - [composer](#installation)
    - [laravel](#installation)
    - [publikwanie plików](#installation)
* [Stosowanie](#Stosowanie)
    - [Kontroler](#installation)
    - [Model](#installation)
    - [Widok](#installation)
* [Komponent bazowy](#Komponent_bazowy_38)

## Instalacja

Composer

```
"repositories": [ {
        "type": "vcs",
        "url": "https://piotr_theis@bitbucket.org/etdcms/repository.git"
    } , {
        "type": "vcs",
        "url": "https://piotr_theis@bitbucket.org/etdcms/eloquenttable.git"
    }.
    ...
"require": {
        "php": ">=7.0",
        "laravel/framework": "5.2.*",
        "tysdever/eloquenttable": "dev-master",
        ...
```

Laravel

config/app.php
```
'providers' => [
    ...
    Tysdever\EloquentTable\EloquentTableServiceProvider::class,
```



# Komponent bazowy

https://github.com/stevebauman/eloquent-table
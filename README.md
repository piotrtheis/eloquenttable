# Eloquent Table

Komponent do prostego tworzenia tabelek.

* [Instalacja](#markdown-header-instalacja)
    - [composer](#markdown-header-composer)
    - [laravel](#markdown-header-bazowy-laravel)
    - [publikwanie plików](#markdown-header-publikacja-plikow)
* [Stosowanie](#markdown-header-stosowanie)
    - [Kontroler](#markdown-header-kontroler)
    - [Model](#markdown-header-model)
    - [Widok](#markdown-header-widok)
* [Komponent bazowy](#markdown-header-bazowy)

## Instalacja

##### Composer

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

##### Laravel

config/app.php
```
'providers' => [
    ...
    Tysdever\EloquentTable\EloquentTableServiceProvider::class,
```



##### Publikacja plików


###### Skrypty

Do prawidłowego działania trzeba jeszcze dodać opublikowane skrypty js.

```
$ php artisan vendor:publish --provider="Tysdever\EloquentTable\EloquentTableServiceProvider" --tag="js"
```
To polecenie opublikuje skrypt eloquenttable.js w katalogu /resources/assets/vendor/tysdever/eloquenttable który trzeba dodać do gulpfile.js, jeżeli w gulpfile.js znajduje się taki wpis
```
'vendor/tysdever/**/*.js'
```
to możesz olać dodawanie skryptu. Jedne co musisz zrobić to odpalić w konsoli kompilator gupl-a

```
$ gulp
```


###### Widoki

Jeżeli z niewyjaśnionych przyczyn zajdzie potrzeba edycji widoków to możesz opublikować widoki poleceniem
```
$ php artisan vendor:publish --provider="Tysdever\EloquentTable\EloquentTableServiceProvider" --tag="views"
```
To polecenie opublikuje widoki w katalogu /resources/views/vendor/tysdever/eloquenttable, od tej pory możesz się cieszyć elastycznością Laravela.


###### i18n

To samo co wyżej, zmień tylko tag na lang. Publikacja w katalogu /lang/vendor/tysdever/eloquenttable.


###### Config

Tu już chyba za wiele nie muszę tłumaczyć, ale zapisuję co by było wiadomo że się da.


## Stosowanie

##### Kontroler

##### Model

##### Widok


## Komponent bazowy

https://github.com/stevebauman/eloquent-table
Phones book
==================================

#### Intro:

Projektas sukurtas naudojantis "Ubuntu 18.04.3", jam paleisti reikalingas sukonfiguruotas docker'is. <br />
Docker'io parsisiuntimo nuoroda [čia](https://docs.docker.com/install/linux/docker-ce/ubuntu/).<br /> Įdiegus reikia pasidaryti, kad docker'į būtų galima naudoti be root teisių, nuoroda [čia](https://docs.docker.com/install/linux/linux-postinstall/#manage-docker-as-a-non-root-user). 
 
#### Paleidimas:

Instrukcija:

* Pasileidžiame docker'į: (Nueiname į projekto folder'į ir paleidžiame komandą)

``` docker-compose up -d ```

* Atsidarome php konteinerį:

``` docker-compose exec php-fpm bash```

* Update'inam projektą: (per php konteinerio bash komandų eilutę)

``` composer update```

* Įsirašome duomenų bazės migracijas: (per php konteinerio bash komandų eilutę)

``` bin/console d:m:m ```

* Užkrauname fixtūras: (per php konteinerio bash komandų eilutę)

``` bin/console doctrine:fixtures:load```

* Projektas paleistas ir jį galima pasiekti adresu:

```http://127.0.0.1:8000/```

#### Testai:

Instrukcija:

* Atsidarome php konteinerį:

``` docker-compose exec php-fpm bash```

* Testų paleidimas: (per php konteinerio bash komandų eilutę)

``` ./vendor/bin/simple-phpunit```

#### Projekto paleidimas/išjungimas:

* Projektas paleidžiamas su komanda:

``` docker-compose up -d ```

* Projektas išjungiamas su komanda:

``` composer-docker down  ```

#### Prisijungimai:

Login Auth prisijungimai:

Email: test0@test.lt Pass: test0 <br />
Email: test1@test.lt Pass: test1 <br />
Email: test2@test.lt Pass: test2 <br />
Email: test3@test.lt Pass: test3 <br />

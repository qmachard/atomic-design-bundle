# Contributing

## Install the testing application

### Requirements

* Symfony CLI ≥ 4.18
* PHP ≥ 7.3
* Composer ≥ 1.10
* Node ≥ 12.5
* Yarn ≥ 1.21

### Installation

* Clone the repos

```shell script
$ git clone https://github.com/qmachard/atomic-design-bundle
$ cd atomic-design-bundle
```

* Go to the testing application

```shell script
$ cd tests/app
```

* Install dependencies with composer

```shell script
$ composer install
```

* Build assets

```shell script
$ yarn install
$ yarn build
```

### Getting Started

* Start the server with Symfony CLI

```shell script
$ symfony server:start
```

* You can go to http://127.0.0.1:8000
*  You can find Atomic Design Playground on http://127.0.0.1:8000/_atomic-design

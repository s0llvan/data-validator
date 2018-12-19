# DataValidator

Validation tool for data

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

* PHP >= 5.4
* Composer

### Installing

Just clone repository

```
git clone https://github.com/s0llvan/data-validator
```

## Running the tests

```
vendor/bin/phpunit
```

## Built With

* [Composer](https://getcomposer.org/doc/) - Package manager

## Deployment

```
composer require s0llvan/data-validator
```

## Example

**HTML**
```
<form method="post">
  <input type="text name="register[username]">
  <input type="email" name="register[email]">
  <input type="password name="register[password]">
  <input type="submit">
</form>
```

**PHP**
```
<?php

$customMessages = [
  'register[username].required' => 'Username required',
  'register[username].alpha_numeric' => 'Username can only contains numeric and alpha characters',
  'register[email].required' => 'E-mail adress required',
  'register[email].mail' => 'E-mail invalid',
  'register[password].required' => 'Password required',
  'register[password].min_length' => 'Password minimum length need to be 8',
  'register[password].contains' => 'Password need contains numeric and alpha characters',
];

$rules = [
  'register[username]' => 'required|alpha_numeric',
  'register[email]' => 'required|mail',
  'register[password]' => 'required|min_length:8|contains:alpha,numeric'
];

$validator = new S0llvan\DataValidator\DataValidator($_POST, $rules, $customMessages);

if($validator->isSubmit()) {
  if($validator->isValid()) {
    echo 'Registration success !';
  } else {
    echo 'Error: ' . $validator->first();
  }
}
```

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/s0llvan/data-validator/tags). 

## Authors

* **s0llvan** - *Initial work* - [s0llvan](https://github.com/s0llvan)

See also the list of [contributors](https://github.com/s0llvan/data-validator/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

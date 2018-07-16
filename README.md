# VCard PHP library

[![Latest Stable Version](https://img.shields.io/badge/packagist-v1.0.2-blue.svg)](https://packagist.org/packages/rogersxd/vcard)
[![License](http://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/rogersxd/vcard/master/LICENSE)
[![Build Status](https://scrutinizer-ci.com/g/rogersxd/vcard/badges/build.png?b=master)](https://scrutinizer-ci.com/g/rogersxd/vcard/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rogersxd/vcard/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rogersxd/vcard/?branch=master)


VCard PHP library. Only VCF files.

## Usage

### Installation

```bash
composer require rogersxd/vcard
```
> This will install the latest version of vcard with [Composer](https://getcomposer.org)

### Example

``` php
use Rogersxd\VCard\VCard;

$vcard = new VCard();

$vcard->addPhoto(__DIR__ .'/images/rogerscorrea.jpg');

$lastName = 'Corrêa';
$firstName = 'Rogers';
$additional = '';
$prefix = '';
$suffix = '';
$fullName = true;

$vcard->addnames(
        $lastName, 
        $firstName, 
        $additional, 
        $prefix, 
        $suffix,
        $fullName
);

$vcard->addPhone('+5551999999999', 'CELL');

$vcard->addPhone('+555133333333', 'HOME');

$vcard->addJobtitle('Banking');

$vcard->addRole('Developer');

$vcard->addEmail('rogersgbc@gmail.com');

$vcard->addCompany('XYZ');

$vcard->addUrl('http://rogerscorrea.wordpress.com');

$vcard->addUrl('https://github.com/rogersxd');

$vcard->addNote('CUSTOM-NOTE: TEST VCARD');

$vcard->addBirthday('YYYY-MM-DD');

$name = '';
$extended = '';
$street = 'Francisco Martins, 123';
$city = 'Porto Alegre';
$region = 'RS';
$zip = '91712-150';
$country = 'BR';
$type = 'HOME';

$vcard->addAddress(
    $name,
    $extended,
    $street,
    $city,
    $region,
    $zip,
    $country,
    $type
);

$socialProfile1 = 'https://facebook.com/';
$typeSocialProfile1 = 'facebook';

$socialProfile2 = 'https://instagram.com/';
$typeSocialProfile2 = 'instagram';

$socialProfile3 = 'https://twitter.com/';
$typeSocialProfile3 = 'twitter';

$socialProfile4 = 'https://linkedin.com/';
$typeSocialProfile4 = 'linkedin';

$vcard->addSocialProfile(
    $socialProfile1,
    $typeSocialProfile1
);

$vcard->addSocialProfile(
    $socialProfile2,
    $typeSocialProfile2
);

$vcard->addSocialProfile(
    $socialProfile3,
    $typeSocialProfile3
);

$vcard->addSocialProfile(
    $socialProfile4,
    $typeSocialProfile4
);

$vcard->addCustom('X-CUSTOM(CHARSET=UTF-8,ENCODING=QUOTED-PRINTABLE,Custom1)','1');

$vcard->setSavePath(__DIR__. '/vcf/');

$vcard->save();

```


## Documentation

The class is well documented inline.

## Contributing

Contributions are **welcome** and will be fully **credited**.

### Pull Requests

> To add or update code

- **Coding Syntax** - Please keep the code syntax consistent with the rest of the package.
- **Add unit tests!** - Your patch won't be accepted if it doesn't have tests.
- **Document any change in behavior** - Make sure the README and any other relevant documentation are kept up-to-date.
- **Consider our release cycle** - We try to follow [semver](http://semver.org/). Randomly breaking public APIs is not an option.
- **Create topic branches** - Don't ask us to pull from your master branch.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

### Issues

> For bug reporting or code discussions.

More info on how to work with GitHub on help.github.com.

## Credits

- [Rogers Corrêa](https://github.com/rogersxd)
- [All Contributors](https://github.com/rogersxd/vcard/contributors)

## License

The module is licensed under [MIT](./LICENSE.md). In short, this license allows you to do everything as long as the copyright statement stays present.

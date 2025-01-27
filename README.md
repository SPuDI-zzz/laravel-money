# 💵 Money for Laravel PHP
[![Latest Stable Version](https://img.shields.io/packagist/v/postscripton/laravel-money.svg)](https://packagist.org/packages/postscripton/laravel-money)
[![Total Downloads](https://img.shields.io/packagist/dt/postscripton/laravel-money.svg)](https://packagist.org/packages/postscripton/laravel-money)
[![License](https://img.shields.io/packagist/l/postscripton/laravel-money)](https://packagist.org/packages/postscripton/laravel-money)

This package provides a convenient way to convert numbers from a database like (`'balance': 123450`) into money strings for humans.

## Requirements
+ PHP 7.4+

## Installation
### via composer
```console
composer require postscripton/laravel-money 
```
### Publishing
Publish the config file through:
```console
php artisan vendor:publish --provider=PostScription\Money\MoneyServiceProvider
```
or
```console
php artisan vendor:publish --tag=money
```

After all, the config file at `config/money.php` should be modified for your own purposes. 

## Usage

### 🧰 Creating
In order to use this package, you need to create a Money object:

```php
use PostScripton\Money\Money;

$money = new Money(1234);
$money = Money::make(1234);
```

You can add following parameters for both object and static variants:
```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$money = new Money(1234, Currency::code('RUB'));
$money = new Money(1234, new MoneySettings);
$money = new Money(1234, Currency::code('RUB'), new MoneySettings);

// NOT: new Money(1234, new MoneySettings, Currency::code('RUB'))
```

### 🖨️ Output
After creating and manipulating with the Money object, you'd like to print the money out to somewhere.

You can use one of the following ways:
```php
use PostScripton\Money\Money;

$money = new Money(1234);

// Use toString()
$string = $money->toString();           // "$ 123.4"

// Explicitly assign object to string
$string = "Your balance is {$money}";   // "Your balance is $ 123.4"
```
In Blade:
```html
<p>Balance: {{ $money }}</p>
```

### ⚙️ Settings
If you want to customize settings for your Money object, you need to specify settings for it.

To set setting:
```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

// Set #1
$money = new Money(1234, new MoneySettings);

// Set #2
$money = new Money(1234);
$settings = new MoneySettings;
$money->settings = $settings;

// Set #3
$money = new Money(1234); // Every Money object has settings by default even if it is not provided
```

To get settings:
```php
use PostScripton\Money\Money;

$money = new Money(1234);
$money->settings;
```

❗ **NOTE**
All the settings that are not provided or not changed will have default values, which were configured in the config file.

---

Following settings are provided:

#### Decimals
You may get or specify number of decimals `123.(4)`:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234, $settings);

$money->settings->getDecimals();    // 1
$money->toString();                 // "$ 123.4"

$money->settings->setDecimals(2); 

$money->settings->getDecimals();    // 2
$money->toString();                 // "$ 12.34" 
```

---

#### Thousands separator
You may get or specify a separator between thousands `1( )000( )000`:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(10000000, $settings);

$money->settings->getThousandsSeparator();  // " "
$money->toString();                         // "$ 1 000 000"

$money->settings->setThousandsSeparator("'"); 

$money->settings->getThousandsSeparator();  // "'"
$money->toString();                         // "$ 1'000'000"
```

---

#### Decimal separator
You may get or specify a separator for decimals `123(.)4`:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234, $settings);

$money->settings->getDecimalSeparator();    // "."
$money->toString();                         // "$ 123.4"

$money->settings->setDecimalSeparator(","); 

$money->settings->getDecimalSeparator();    // ","
$money->toString();                         // "$ 123,4"
```

---

#### Ends with Zero
You may get or specify whether money ends with 0 or not `100(.0)`:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1000, $settings);

$money->settings->endsWith0();  // false
$money->toString();             // "$ 100"

$money->settings->setEndsWith0(true); 

$money->settings->endsWith0();  // true
$money->toString();             // "$ 100.0"
```

---

#### Space between currency and number
You may get or specify whether there is a space between currency and number `$( )123.4`:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234, $settings);

$money->settings->hasSpaceBetween();    // true
$money->toString();                     // "$ 100"

$money->settings->setHasSpaceBetween(false);

$money->settings->hasSpaceBetween();    // false
$money->toString();                     // "$100"
```

---

#### Currency
You may get or specify currency for money `($) 123.4`:

```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234, $settings);

$money->settings->getCurrency();                // PostScripton\Money\Currency class
$money->settings->getCurrency()->getSymbol();   // "$"
$money->toString();                             // "$ 123.4"

$money->settings->setCurrency(Currency::code('RUB'));

$money->settings->getCurrency();                // PostScripton\Money\Currency class
$money->settings->getCurrency()->getSymbol();   // "₽"
$money->toString();                             // "123.4 ₽"
```

---

#### Origin number
You may get or specify origin number whether it is integer or float.
Means in which way numbers are stored in a database:

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234, $settings);

$money->settings->getOrigin();  // 0 (MoneySettings::ORIGIN_INT)
$money->toString();             // "$ 123.4"
```

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = new MoneySettings;
$money = new Money(1234.567, $settings);

$money->settings->setOrigin(MoneySettings::ORIGIN_FLOAT);

$money->settings->getOrigin();  // 1 (MoneySettings::ORIGIN_FLOAT)
$money->toString();             // "$ 1234.6"
```

❗ If origin is set as **integer**, then the number divides on computed value to get a number with right amount of decimals.

❗ If origin is set as **float**, then the numbers leaves the same but removes unnecessary decimal digits.

---

### 💲 Currencies
Along with Money, as you have already noticed, Currencies are also provided. In many methods you have to pass a Currency object.

In order to get a specific currency:

```php
use PostScripton\Money\Currency;

$usd = Currency::code('USD');
```

❗ Only international codes such as “USD”, “EUR”, “RUB” and so on should be used as a code.

---

You can also get or change some data from Currency object:

#### Information

```php
use PostScripton\Money\Currency;

$usd = Currency::code('USD');
$usd->getCode();        // USD
$usd->getSymbol();      // "$"
$usd->getPosition();    // 0 (Currency::POS_START)
```

---

#### Position
You may specify the position of the currency on display.
Use following constants:

```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;

$money = new Money(1234);

$money->settings->getCurrency()->getPosition(); // 0 (Currency::POS_START)
$money->toString();                             // "$ 123.4"

$money->settings->getCurrency()->setPosition(Currency::POS_END);

$money->settings->getCurrency()->getPosition(); // 1 (Currency::POS_END)
$money->toString();                             // "123.4 $"
```

---

### 💵 Money
Here we are, prepared and ready to create our own Money objects.

There are separation into static methods and object ones.

Let's start with static:

---

#### Available static methods

##### `Money::make()`
creates a Money object

```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;

// Default currency: USD

Money::make(0);                               // "$ 0"
Money::make(1230);                            // "$ 123"
Money::make(1234);                            // "$ 123.4"
Money::make(12345);                           // "$ 1 234.5"

Money::make(12345, Currency::code('RUB'));    // "1 234.5 ₽"
```

Method `make()` is a synonym of an object's constructor.
All the ways to pass parameters have already been discussed at the beginning.

---

##### `Money::purify()`
gives you formatted number from Money object

```php
use PostScripton\Money\Money;

$money = Money::make(12345);    // "$ 1 234.5"
Money::purify($money);          // "1 234.5"
```

---

##### `Money::integer()`
converts Money object back into integer or float according to origin settings

```php
use PostScripton\Money\Money;

$money = Money::make(12345);    // "$ 1 234.5"
Money::integer($money);         // 12345
```

---

##### `Money::convert()`
converts money from one currency to another

```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;

$coeff = 75.32;
$rub = Money::make(10000, Currency::code('RUB'));                       // "1 000 ₽"

$usd = Money::convertOffline($rub, Currency::code('USD'), 1 / $coeff);  // "$ 13.3"
$rub = Money::convertOffline($usd, Currency::code('RUB'), $coeff / 1);  // "1 000 ₽"
```

---

##### `Money::correctInput()`
corrects an `<input type="number" />`'s value to the correct one

```php
use PostScripton\Money\Money;

// Number of digits after decimal: 2

$input_value = "1234.567890";       // value that comes from <input> tag
Money::correctInput($input_value);  // "1234.56"
```
It simply adjusts a number string to the expected number string with default settings applied

---

#### Available object's methods

##### `getNumber()`
gives you the formatted number

```php
use PostScripton\Money\Money;

$money = new Money(12345);
$money->getNumber(); // "1 234.5"
```

---

##### `getPureNumber()`
gives you pure number for calculating

```php
use PostScripton\Money\Money;

$money = new Money(132.76686139139672);
$money->getPureNumber(); // 132.76686139139672
```

---

##### `convertOfflineInto()`
converts Money object into the chosen currency

```php
use PostScripton\Money\Currency;
use PostScripton\Money\Money;

$coeff = 75.32;
$rub = new Money(10000, Currency::code('RUB'));

$usd = $rub->convertOfflineInto(Currency::code('USD'), 1 / $coeff);
$usd->getPureNumber(); // 132.76686139139672
// gives you the same object, not cloned but changed
```

---

##### `toInteger()`
converts the number into integer according to origin settings whether it is integer or float

```php
use PostScripton\Money\Money;
use PostScripton\Money\MoneySettings;

$settings = (new MoneySettings())
    ->setOrigin(MoneySettings::ORIGIN_FLOAT);

$int = new Money(1234.5);
$float = new Money(1234.5, $settings);

$int->toInteger();      // 12345
$float->toInteger();    // 12345
```

---

##### `toString()`
represents Money object as a string. The ways to convert into a string have already been mentioned at the beginning

```php
use PostScripton\Money\Money;

$money = new Money(1234);
$money->toString(); // "$ 123.4"
```

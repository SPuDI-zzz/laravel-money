<?php

namespace PostScripton\Money;

interface MoneyInterface
{
    // ========== STATIC ========== //

    /**
     * Sets default settings for any Money object
     * @param MoneySettings $setting
     */
    public static function set(MoneySettings $setting): void;

    /**
     * Returns just a formatted number <p>
     * For example, "$ 1 234.56" -> "1234.56" </p>
     * @param Money $money <p>
     * Money object: "1 234.56 ₽" </p>
     * @return string <p>
     * Formatted number: "1 234.56" </p>
     */
    public static function purify(Money $money): string;

    /**
     * Returns converted the money's value into integer for storing in database
     * @param Money $money <p>
     * Money object: 1234.567 (set 2 decimals) </p>
     * @return int <p>
     * Integer: 123456 </p>
     */
    public static function integer(Money $money): int;

    /**
     * Converts from one currency to another
     * @param Money $money <p>
     * Money object </p>
     * @param Currency $into <p>
     * Currency to be converted into </p>
     * @param float $coeff
     * <p>Coefficient between one currency and another</p>
     * <p>USD -> RUB = 75.79 / 1</p>
     * <p>RUB -> USD = 1 / 75.79</p>
     * @return Money Денежная строка со знаком валюты
     */
    public static function convertOffline(Money $money, Currency $into, float $coeff): Money;

    /**
     * Corrects input &lt;input type="number" /&gt; using default settings
     * @param string $input <p>
     * Input string: "1234.567890" </p>
     * @return string <p>
     * Corrected string: "1234.5" </p>
     */
    public static function correctInput(string $input): string;

    /**
     * Returns the default divisor
     * @return int
     */
    public static function getDefaultDivisor(): int;

    /**
     * Returns the default number of decimals
     * @return int
     */
    public static function getDefaultDecimals(): int;

    /**
     * Returns the default thousand separator
     * @return string
     */
    public static function getDefaultThousandsSeparator(): string;

    /**
     * Returns the default decimal separator
     * @return string
     */
    public static function getDefaultDecimalSeparator(): string;

    /**
     * Returns whether money ends with 0 or not
     * @return bool
     */
    public static function getDefaultEndsWith0(): bool;

    /**
     * Returns whether there is a space between currency sign and number
     * @return bool
     */
    public static function getDefaultSpaceBetween(): bool;

    /**
     * Returns the default currency
     * @return Currency
     */
    public static function getDefaultCurrency(): Currency;

    /**
     * Returns the default origin. Whether it is integer or float
     * @return int
     */
    public static function getDefaultOrigin(): int;

    // ========== OBJECT ========== //

    /**
     * Returns a formatted number <p>
     * For example, "$ 1 234.5" -> "1 234.5" </p>
     * @return string
     */
    public function getNumber(): string;

    /**
     * Returns a pure number that uses for calculations. Not usually used <p>
     * For example, you see "13.3" but within it looks like 13.276686139139672 </p>
     * @return float
     */
    public function getPureNumber(): float;

    /**
     * Converts money into another currency using coefficient between currencies
     * <p>USD -> RUB = 75.79 / 1</p>
     * <p>RUB -> USD = 1 / 75.79</p>
     * @param Currency $currency <p>
     * Currency you want to convert into </p>
     * @param float $coeff <p>
     * Coefficient between the money's currency and the chosen one
     * @return Money
     */
    public function convertOfflineInto(Currency $currency, float $coeff): Money;

    /**
     * Converts the money into integer for storing in database <p>
     * For example, "1 234.5" -> 12345 </p>
     * @return int
     */
    public function toInteger(): int;

    /**
     * Returns the money string applying all the settings <p>
     * You may not use it if you explicitly assign the object to a string </p>
     * @return string <p>
     * "$ 1 234.5" </p>
     */
    public function toString(): string;
}
<?php

if (! function_exists('getAmountInWords')) {
    function getAmountInWords(float $amount, ?string $locale = null)
    {
        $currency_decimals = 2;
        $currency_fraction = 'ct.';
        $currency_code = 'USD';

        $amount    = number_format($amount, $currency_decimals, '.', '');
        $formatter = new NumberFormatter($locale ?? App::getLocale(), NumberFormatter::SPELLOUT);

        $value = explode('.', $amount);

        $integer_value  = (int) $value[0] !== 0 ? $formatter->format($value[0]) : 0;
        $fraction_value = isset($value[1]) ? $formatter->format($value[1]) : 0;

        if ($currency_decimals <= 0) {
            return sprintf('%s %s', ucfirst($integer_value), strtoupper($currency_code));
        }

        return sprintf(
            trans('invoices::invoice.amount_in_words_format'),
            ucfirst($integer_value),
            strtoupper($currency_code),
            $fraction_value,
            $currency_fraction
        );
    }
}

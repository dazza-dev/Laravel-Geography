<?php

namespace DazzaDev\Geography\Traits;

use DazzaDev\Geography\Exceptions\InvalidCodeException;
use Illuminate\Support\Str;

trait LocaleTrait
{
    /**
     * Default locale setting
     */
    protected $defaultLocale = 'en';

    /**
     * Current locale setting
     */
    protected $locale = 'en';

    /**
     * Supported locales
     */
    protected $supported_locales = [
        'en',
        'es',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLocale(config('app.locale'));
    }

    /**
     * Set Locale
     */
    public function setLocale(string $locale): void
    {
        $locale = str_replace('_', '-', strtolower($locale));
        if (Str::startsWith($locale, 'en')) {
            $locale = 'en';
        }
        if (! in_array($locale, $this->supported_locales)) {
            $locale = 'en';
        }
        $this->locale = $locale;
    }

    /**
     * Get locale
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Get localized instance
     */
    protected function getLocalized(): mixed
    {
        return $this->locales()->whereLocale($this->locale)->first();
    }

    /**
     * Get localized attribute of instance
     */
    protected function getLocalizedAttribute(string $localizedAttribute, string $defaultAttribute): string
    {
        if ($this->locale == $this->defaultLocale) {
            return $this->{$defaultAttribute};
        }
        $localized = $this->getLocalized();

        return ! is_null($localized) ? $localized->{$localizedAttribute} : $this->{$defaultAttribute};
    }

    /**
     * Get localized name of instance
     */
    public function getLocalNameAttribute(): string
    {
        return $this->getLocalizedAttribute('name', 'name');
    }

    /**
     * Get localized Full Name of instance
     */
    public function getLocalFullNameAttribute(): string
    {
        return $this->getLocalizedAttribute('full_name', 'full_name');
    }

    /**
     * Get alias of locale
     */
    public function getLocalAliasAttribute(): string
    {
        return $this->getLocalizedAttribute('alias', 'name');
    }

    /**
     * Get abbreviation of locale
     */
    public function getLocalAbbrAttribute(): string
    {
        return $this->getLocalizedAttribute('abbr', 'name');
    }

    /**
     * Get instance by code like country code etc.
     */
    public static function getByCode(string $code): mixed
    {
        $code = strtolower($code);
        $column = mb_strlen($code) == 3 ? 'code_alpha3' : 'code';
        $item = self::where($column, $code)->first();
        if (is_null($item)) {
            throw new InvalidCodeException("{$code} does not exist");
        }

        return $item;
    }
}

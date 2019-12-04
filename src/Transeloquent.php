<?php
/**
 * Copyright (c) Muara Invoasi Bangsa 2019.
 *
 * Every code write on this page is belonging to MIB, don't copy or modify this page without permission from MIB.
 * more information please contact email below
 *
 *  frankyso.mail@gmail.com
 *  ijalnasution107@gmail.com
 *  wahyueko17@gmail.com
 */

namespace konnco\Transeloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

trait Transeloquent
{
    /**
     * Current model locale.
     *
     * @var null
     */
    protected $currentLocale = null;

    /**
     * Transeloquent variable container.
     *
     * @var array
     */
    protected $transeloquent = [
        'attributes'   => [],
        'translations' => [],
    ];

    /**
     * Booting process to registering eloquent events.
     */
    public static function bootTranseloquent(): void
    {
        static::saving(function (Model $model) {
            return $model->saveTranslations();
        });
        static::deleting(function (Model $model) {
            return $model->deleteTranslations();
        });

        static::retrieved(function (Model $model) {
            $translated = [];
            $translate = $model->transeloquent($model->getCurrentLocale())->get();
            $translate->each(function ($field) use (&$translated) {
                $translated[$field->key] = $field->value;
            });

            $model->setRawTranslatedAttributes($translated);
            $model->getAvailableTranslations();
        });
    }

    /**
     * fetch Available Translations.
     */
    public function getAvailableTranslations()
    {
        return collect($this->transeloquent()->select('locale')->groupBy('locale')->get()->toArray())->values();
    }

    /**
     * set Default Locale.
     *
     * @param $lang
     */
    public function setLocale($lang)
    {
        $this->currentLocale = $lang;
    }

    /**
     * Setting Raw Translation attributes.
     *
     * @param array $translates
     */
    public function setRawTranslatedAttributes($translates = [])
    {
        $this->transeloquent['attributes'] = $translates;
    }

    /**
     * Get current locale.
     *
     * @return string
     */
    private function getCurrentLocale()
    {
        return $this->currentLocale ?? App::getLocale();
    }

    /**
     * Get default locale.
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getDefaultLocale()
    {
        return config('app.transeloquent.model_locale');
    }

    public function transeloquent($locale = null)
    {
        $transeloquentObject = $this->morphMany(\App\Transeloquent::class, 'translatable');
        if ($locale != null) {
            $transeloquentObject->where('locale', $locale);
        }

        return $transeloquentObject;
    }

    /**
     * Override parents functions to get single attributes.
     *
     * @param $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        $defaultLocale = $this->getDefaultLocale();
        $currentLocale = $this->getCurrentLocale();

        if ($defaultLocale == $currentLocale) {
            return parent::getAttribute($key);
        } else {
            return @$this->transeloquent['attributes'][$key] ?? parent::getAttribute($key);
        }
    }

    /**
     * Check Translation Exists.
     *
     * @param $lang
     */
    public function translationExist($lang)
    {
        return array_search($lang, $this->transeloquent['translations']) >= 0;
    }

    /**
     * Set Excluded these Fields from Translate.
     *
     * @return \Illuminate\Support\Collection
     */
    public function translateExcept()
    {
        $attributes = collect($this->attributesToArray());
        foreach (array_merge($this->translateExcept ?? [], ['id', 'created_at', 'updated_at']) as $value) {
            $filtered = $attributes->forget($value);
        }

        return $filtered;
    }

    /**
     * Set Only these Fields to Translate.
     *
     * @return \Illuminate\Support\Collection
     */
    public function translateOnlyAttributes()
    {
        $attributes = collect($this->attributesToArray());
        foreach ($this->translateOnly ?? [] as $value) {
            $filtered = $attributes->only($value);
        }

        return $filtered;
    }

    /**
     * Saving Translation.
     *
     * @return bool
     */
    public function saveTranslations()
    {
        $defaultLocale = $this->getDefaultLocale();
        $currentLocale = $this->getCurrentLocale();

        if ($defaultLocale != $currentLocale) {
            $attributes = isset($this->translateOnly) ? $this->translateOnlyAttributes() : $this->translateExcept();

            foreach ($attributes as $key => $attribute) {
                if ($attribute != null) {
                    $translate = $this->transeloquent($this->getCurrentLocale())->where('key', $key)->first();
                    if ($translate == null) {
                        $translate = new \App\Transeloquent();
                    }
                    $translate->locale = $this->getCurrentLocale();
                    $translate->key = $key;
                    $translate->value = $attribute;
                    $translate->save();
                    $this->transeloquent($this->getCurrentLocale())->save($translate);
                }
            }

            $this->setRawAttributes($this->getOriginal());
        }

        return true;
    }

    /**
     * Delete Translation.
     *
     * @return mixed
     */
    public function deleteTranslations()
    {
        if (!$this->isSoftDelete()) {
            return $this->transeloquent()->delete();
        }
    }

    /**
     * Checking Model is softdeleting or not.
     *
     * @return bool
     */
    public function isSoftDelete()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this)) && !$this->forceDeleting;
    }
}

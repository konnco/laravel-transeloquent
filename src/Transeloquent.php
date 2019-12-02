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
    protected $translatedAttributes = [];

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
            $translate = $model->transeloquent()->get();
            $translate->each(function ($field) use (&$translated) {
                $translated[$field->key] = $field->value;
            });

            $model->setTranslatedAttributes($translated);
        });
    }

    public function setTranslatedAttributes($translates = [])
    {
        $this->translatedAttributes = $translates;
    }

    public function currentLocale()
    {
        return App::getLocale();
    }

    public function defaultLocale()
    {
        return config('app.transeloquent.model_locale');
    }

    public function transeloquent()
    {
        return $this->morphMany(\App\Transeloquent::class, "translatable")->where('locale', $this->currentLocale());
    }

    public function getAttribute($key)
    {
        $defaultLocale = $this->defaultLocale();
        $currentLocale = $this->currentLocale();

        if ($defaultLocale == $currentLocale) {
            return parent::getAttribute($key);
        } else {
            return @$this->translatedAttributes[$key] ?? parent::getAttribute($key);
        }
    }


    public function saveTranslations()
    {
        $defaultLocale = $this->defaultLocale();
        $currentLocale = $this->currentLocale();

        if ($defaultLocale != $currentLocale) {
            $attributes = collect($this->attributesToArray());
            foreach (array_merge($this->transeloquentExcluded ?? [], ['id', 'created_at', 'updated_at']) as $value) {
                $attributes->forget($value);
            };

            foreach ($attributes as $key => $attribute) {
                if ($attribute != null) {

                    $translate = $this->transeloquent()->where('key', $key)->first();
                    if ($translate == null) {
                        $translate = new \App\Transeloquent();
                    }
                    $translate->locale = $this->currentLocale();
                    $translate->key = $key;
                    $translate->value = $attribute;
                    $translate->save();
                    $this->transeloquent()->save($translate);
                }
            }

            $this->setRawAttributes($this->getOriginal());
        }
        return true;
    }

    public function deleteTranslations()
    {
        if(!$this->isSoftDelete()){
            return $this->transeloquent()->delete();
        }
    }

    public function isSoftDelete()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this)) && !$this->forceDeleting;
    }
}

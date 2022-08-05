<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Throwable;

trait ApiToken
{
    /** Generate API Token for the Model
     *  Then save it to api_token column or update it if api_token is blank
     */
    protected static function bootApiToken()
    {
        static::creating(function ($model) {
            try {
                $model->api_token = hash('sha256', Str::random(80));
            } catch (Throwable $e) {
                abort(500, $e->getMessage());
            }
        });

        static::updating(function ($model) {
            try {
                isset($model->api_token) ?: $model->api_token = hash('sha256', Str::random(80));
            } catch (Throwable $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}

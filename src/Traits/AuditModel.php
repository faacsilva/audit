<?php

namespace Faacsilva\Audit\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AuditModel
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->created_by = (Auth::user()) ? Auth::user()->id : 1 ;
            $model->created_from = request()->ip();

            static::writeLog($model, 'create');
        });

        static::updating(function($model)
        {
            $model->updated_by = (Auth::user()) ? Auth::user()->id : 1 ;
            $model->updated_from = request()->ip();

            static::writeLog($model, 'update');
        });

        static::deleting(function($model)
        {
            $model->deleted_by = (Auth::user()) ? Auth::user()->id : 1 ;
            $model->deleted_from = request()->ip();
            $model->save();

            static::writeLog($model, 'delete');
        });
    }

    protected static function writeLog($model, $event)
    {
        Activity::save(self::message($model, $event), [
            'event' => $event,
            'origin' => strtolower(class_basename(get_class($model)))
        ]);
    }

    protected static function message($model, $event)
    {
        $terminations = [
            'create' => 'was created',
            'update' => 'was updated',
            'delete' => 'was deleted',
        ];

        if (!array_key_exists($event, $terminations)) {
            return class_basename(get_class($model))." '{$model->{$model->label}}' {$event}.";
        }

        return class_basename(get_class($model))." '{$model->{$model->label}}' {$terminations[$event]}.";
    }
}
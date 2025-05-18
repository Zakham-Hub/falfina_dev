<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ObservableServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $models = File::allFiles(app_path('Models'));
        foreach ($models as $model) {
            $modelClass = App::getNamespace().'Models\\'.$model->getFilenameWithoutExtension();
            $observerClass = App::getNamespace().'Observers\\'.$model->getFilenameWithoutExtension().'Observer';
            if (class_exists($observerClass)) {
                $modelClass::observe($observerClass);
            }
        }
    }
}

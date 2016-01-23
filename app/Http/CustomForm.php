<?php

namespace App\Http;

use App;
use Image;
use Illuminate\Html\FormBuilder;

trait CustomForm
{
    public function addCustomFormBuilders() {
        FormBuilder::macro('myInput', function($id, $name, $placeholder='', $primaryValue='', $secondaryValue='')
        {
            $value = $primaryValue!='' ? $primaryValue : $secondaryValue;
            return
                '<div class="form-group">'.
                    FormBuilder::label($id, $name, ['class' => 'col-sm-2 control-label form-label'])
                    .'<div class="col-sm-6">'.
                        FormBuilder::text($id, $value, ['class' => 'form-control', 'placeholder' => $placeholder])
                    .'</div>'
                .'</div>';
        });

        FormBuilder::macro('myCheckbox', function($id, $name, $checkBoxValue)
        {
            return FormBuilder::checkbox($id, $checkBoxValue, old($id, false), ['id' => $checkBoxValue])
            .FormBuilder::label('', $name, ['class' => 'control-label']);
        });

        FormBuilder::macro('myImageWithThumbnail', function($id)
        {
            return
            '<div class="col-sm-3">'.
                '<div class="embed-responsive embed-responsive-16by9">'.
                    '<img class="embed-responsive-item" id="' . $id . '-preview" src="/images/placeholder.jpg"/>'.
                '</div>'.
                FormBuilder::file($id, ['class' => 'form-control', 'accept' => 'image/*', 'id' => $id]).
            '</div>';
        });
    }

}

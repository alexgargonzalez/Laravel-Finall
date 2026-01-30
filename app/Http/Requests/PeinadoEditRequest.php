<?php

namespace App\Http\Requests;

class PeinadoEditRequest extends PeinadoCreateRequest {

    function rules(): array {
        $array = parent::rules();
        $array['name'] = 'unique:peinado,name,' . $this->peinado->id;
        return $array;
    }
}
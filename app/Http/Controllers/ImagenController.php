<?php

namespace App\Http\Controllers;

use App\Models\Peinado;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImagenController extends Controller {
    
    function imagen($id): BinaryFileResponse {
        $peinado = Peinado::find($id);
        if($peinado == null ||
                $peinado->image == null ||
                !file_exists(storage_path('app/private') . '/' . $peinado->image)) {
            return response()->file(base_path('public/assets/img/noimage.jpg'));
        }
        return response()->file(storage_path('app/private') . '/' . $peinado->image);
    }
}
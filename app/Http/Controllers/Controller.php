<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;       // Laravel 10+ mungkin tidak ada ini secara default lagi di sini
use Illuminate\Foundation\Validation\ValidatesRequests;     // Laravel 10+ mungkin tidak ada ini secara default lagi di sini
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController // <--- PASTIKAN MEWARISI "BaseController"
{
    // Laravel 10+ mungkin tidak ada "use AuthorizesRequests, ValidatesRequests;" di sini
    // tapi bisa jadi ada "use Illuminate\Foundation\Auth\Access\AuthorizesRequests;"
    // dan "use Illuminate\Foundation\Validation\ValidatesRequests;" di bagian atas dan `use AuthorizesRequests, ValidatesRequests;` di sini.
    // Intinya, pastikan `class Controller extends BaseController` ada.
    use AuthorizesRequests, ValidatesRequests; // Baris ini mungkin berbeda sedikit tergantung versi Laravel, tapi yang penting `extends BaseController`.
}
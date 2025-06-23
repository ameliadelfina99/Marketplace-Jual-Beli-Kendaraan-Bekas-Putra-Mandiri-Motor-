<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;


class PageController extends Controller
{
    public function sendContactForm(Request $request)
{
    // 1. Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|min:10',
    ]);

    // 2. Tentukan email penerima
    // TODO: Ganti dengan alamat email perusahaan Anda yang sesungguhnya
    $recipientEmail = 'ameliadelfina99@gmail.com';

    // 3. Kirim email
    Mail::to($recipientEmail)->send(new ContactFormMail(
        $validated['name'],
        $validated['email'],
        $validated['message']
    ));

    // 4. Kembali ke halaman kontak dengan pesan sukses
    return back()->with('success', 'Terima kasih! Pesan Anda telah berhasil terkirim.');
}
    // Method untuk menampilkan halaman "Tentang Kami"
    public function about()
    {
        return view('pages.about');
    }

    // Method untuk menampilkan halaman "Kontak"
    public function contact()
    {
        
        return view('pages.contact');
    }
}
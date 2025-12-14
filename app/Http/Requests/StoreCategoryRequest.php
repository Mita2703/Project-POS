<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Ubah dari false menjadi true. 
        // Ini mengizinkan semua pengguna yang telah terautentikasi (atau 
        // sesuai dengan logika otorisasi Anda) untuk membuat request ini.
        // Jika Anda menggunakan middleware auth, ini bisa diubah ke true.
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Nama Kategori: Wajib diisi, harus berupa string, maksimum 255 karakter, dan harus unik di tabel 'categories'
            'name' => [
                'required', 
                'string', 
                'max:255', 
                'unique:categories,name' // Pastikan tidak ada nama kategori yang sama
            ],
            
            // Deskripsi (Opsional): Boleh kosong (nullable), jika diisi harus berupa string
            'description' => [
                'nullable',
                'string',
            ],
            
            // Anda juga dapat menambahkan validasi untuk field lain jika kategori Anda memilikinya, 
            // misalnya 'price' jika kategorinya memiliki harga dasar (meskipun ini lebih umum di Product).
            // Contoh:
            // 'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}

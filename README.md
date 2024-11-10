# CodeIgniter Sistem Administrasi Toko

## Deskripsi Sistem
**Sistem Administrasi Toko** adalah platform yang dirancang dengan menggunakan **CodeIgniter (CI)** untuk mengelola data toko secara efisien dan terstruktur. Sistem ini mencakup berbagai fitur yang memudahkan pengguna dalam memanipulasi dan memantau data toko.

## Detail Sistem
- **AJAX CRUD**: Memungkinkan untuk memanipulasi data pada tabel tanpa memerlukan reload halaman web.
- **Filter Kolom**: Terdapat pilihan untuk kustomisasi filter kolom untuk pencarian data spesifik yang lebih efisien dan presisi.
- **Copy Datatable**: **Admin** bisa meng-copy datatable untuk di-paste-kan pada suatu dokumen.
- **Export Datatable**: **Admin** bisa mengekspor datatable ke dalam bentuk file **.csv**.
- **Print Datatable**: **Admin** bisa mencetak datatable dengan menggunakan **Print Button** ke dalam bentuk file **.pdf** ataupun kertas fisik melalui printer.

## Alur Sistem
- Login sebagai **Admin**.
- **Master**: Pada menu **Master**, terdapat banyak kategori yang nantinya bisa di-assign ke detail produk oleh **Admin**. **Admin** juga bisa memanipulasi data di menu **Master**. Di antara kategori tersebut adalah:
Brand, Warna, Satuan Unit, Promo, Supplier, Customer, Produk, Kantor, Outlet, dan lain sebagainya.
- **Transaksi**: Pada menu **Transaksi**, **Admin** dapat memonitoring **Pemesanan**, **Penjualan**, dan **Pembelian**.
- **Laporan**: Pada menu **Laporan**, Admin dapat melihat laporan **Rekap Penjualan** dan **Rekap Pembelian**.

## Live Demo
Untuk demo percobaan aplikasi **CodeIgniter Sistem Administrasi Toko**, bisa dilakukan pada
[URL Live Demo](https://toko.samreact.my.id/) ini.\
![Demo Administrasi Toko #01 GIF](https://github.com/samdhila/media/blob/main/codeigniter/ci01-optimized.gif)
![Demo Administrasi Toko #02 GIF](https://github.com/samdhila/media/blob/main/codeigniter/ci02-optimized.gif)

**Credential Admin (DEMO)**:\
admin\
password

## Setup Project

### Pre-requirements
**Important: Xampp with PHP 8.0**
```bash
  https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.30/xampp-windows-x64-8.0.30-0-VS16-installer.exe/
```

### Local Installation
Clone project **Sistem Administrasi Toko** pada directory **htdocs** **(C:\xampp\htdocs)**
```bash
  git clone https://github.com/samdhila/codeigniter_administrasi_toko.git
```

Jalankan **Xampp Control Panel** lalu start modul **Apache** dan **MySQL**.
```bash
  Xampp Control Panel
```

Buat database baru pada **PhpMyAdmin** dengan nama
```bash
  sopos_api
```

Import file database **sopos_api.sql** pada database yang baru saja dibuat pada **PhpMyAdmin**.
```bash
  sopos_api.sql
```

Buka URL localhost CodeIgniter (CI) pada web browser, lalu login sebagai **Admin**
```bash
  http://localhost/codeigniter_administrasi_toko/
```

## Simple Parking System

Sistem Parkir ini memiliki 2 role: admin dan petugas-parkir.
Petugas Parkir :
- Saat mobil masuk, petugas parkir menginput nomor polisi. 
- Jika mobil tidak pernah masuk atau sudah keluar, generate kode unik, catat nomor polisi dan waktu masuk.
- Saat mobil keluar, petugas parkir menginput kode unik. 
- Jika kode unik ditemukan, hitung biaya parkir dan catat waktu keluar.
- Biaya parkir flat Rp 3000/jam.

Admin :
- Admin dapat melihat laporan parkir dengan filter date range.
- Admin dapat mengexport laporan tersebut.

## Created By :
Octavian Panggestu

## Database :
MySQL

## User Login :
admin@admin.com \n
admin123

## Template :
AdminLTE 3

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

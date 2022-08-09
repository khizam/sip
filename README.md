# ![WebApp](https://github.com/khizam/sip/blob/main/readme/img/login.png)
# Inventory Produksi Barang JAVAGRI (Web APP)
<table>
<tr>
<td>
  Sebuah aplikasi pendataan gudang dari javagri untuk pencatatan mulai data bahan, data barang masuk bahan, data produksi hingga data terkait lainnya. Terdapat beberapa "peran" user dalam aplikasi seperti owner, lab, produksi hingga gudang. Dengan adanya sistem ini diharapkan dapat memudahkan setiap "peran" dalam industri tersebut dalam menyelesaikan setiap pekerjaannya masing-masing. Sistem ini juga dapat membantu memberitahukan pada antar "peran" ketika dibutuhkan dengan adanya notifikasi yang terdapat dalam aplikasi.
</td>
</tr>
</table>

Fitur Aplikasi:
-

## Demo
Here is a working live demo :  -


## [Instalasi](https://iharsh234.github.io/WebApp/) 
1. Download source code aplikasi melalui 'download' atau git clone github.
```
git clone https://github.com/khizam/sip.git
```
2. Kemudian siapkan sebuah tools Dependency Manager untuk PHP yaitu composer dan lakukan download source code dari library atau fm yang dibutuhkan aplikasi dengan cara. 
```
composer install
```
3. Kemudian sesuaikan *environment variable* pada file .env
4. Setelah persiapan sudah selesai, maka selanjutnya menyiapkan database dan pastikan tools mdb sudah disiapkan. maka selanjutnya lakukan *migration* dan masukkan data *dummy* dengan perintah *--seed*
```
php artisan migrate --seed
or
php artisan migrate
php artisan db:seed
```
5. Beberapa langkah sudah selesai disiapkan. selanjutnya karena aplikasi ini menggunakan websocket untuk push notifikasi maka kemudian setting kebutuhan *environment variable*-nya sesuaikan dengan host laravel websocket. Karena disini masih tahap pengembangan maka laravel-websocket masih digunakan pada sistem local
```
PUSHER_APP_ID=LARAVEL
PUSHER_APP_KEY=LARAVEL
PUSHER_APP_SECRET=SECRET
PUSHER_APP_CLUSTER=mt1
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
```
6. Tahapan pengaturan websocket sudah selesai. maka langkah selanjutnya yaitu menjalankan aplikasi dan host laravel websocket. dan aplikasi siap digunakan
```
php artisan serve
and
php artisan websockets:serve
```

### Teknologi
Berikut teknologi yang digunakan:
* [![Laravel 8][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![Adminlte][adminlte.io.com]][Adminlte-url]
* [![JQuery][JQuery.com]][JQuery-url]

### Library Pendukung Laravel
- [![laravel-websockets][https://beyondco.de/docs/laravel-websockets/getting-started/introduction]]
- [![laravel-permission][https://spatie.be/docs/laravel-permission/v5/basic-usage/basic-usage]]
- [![laravel-activitylog][https://spatie.be/docs/laravel-activitylog/v4/introduction]]
- [![laravel-datatables][https://yajrabox.com/docs/laravel-datatables/master/installation]]



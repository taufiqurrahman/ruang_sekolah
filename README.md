Projek ini menggunakan Laravel (PHP Framework) dan mysql sebagai database.

### Setting up
Install semua dependency yang dibutuhkan dengan command

```composer install```

Buat sebuah database baru di mysql misal dengan nama : **sekolah_db**

Ubah file ```.env.example``` menjadi ```.env```

Edit file ``` .env ``` sesuaikan dengan config database local anda misal :
```
  DB_DATABASE=sekolah_db
  DB_USERNAME=root
  DB_PASSWORD=root
```

Lakukan migrasi database dengan command :

``` php artisan migrate ```

Jalankan server dengan command 

``` $ php artisan serve ```

Selanjutnya adalah melakukan testing API dengan menggunakan Postman atau aplikasi lain yang sejenis

Ada beberapa endpoint yang dapat dicoba seperti : 

```
**register **
url : <domain>/api/register
method : POST
headers = {
  'Accept': 'application/json',
  'Content-Type': 'application/json'
};
body = json.encode({
    "username": "admin",
    "password": "12345678",
    "role": "admin",  <== [ admin, pengajar, murid ]
    "name": "admin"
});  
```

```
**Login **
url : <domain>/api/login
method : POST
headers = {
  'Accept': 'application/json',
  'Content-Type': 'application/json'
};
body = json.encode({
  "username": "admin",
  "password": "12345678"
});  
  ```
  
 ```
**Create Class **
url : <domain>/api/create_class
method : POST
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer 1|ZXJu6o93WEWTzD9UY3K6K31OjxjCgeqfVMTGXp3F',    <== token dari hasil login
  'Content-Type': 'application/json'
};
body = json.encode({
    "x": 4,
    "y": 5
});  
  ``` 
  
   ```
**Checkin **
url : <domain>/api/check_in
method : POST
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer 1|ZXJu6o93WEWTzD9UY3K6K31OjxjCgeqfVMTGXp3F',    <== token dari hasil login
  'Content-Type': 'application/json'
};
body = json.encode({
    "class_id": 3,
    "id_no": 1. <== mungkin diambil dari id_no user login saja
});  
  ``` 
  
```
**Checkout **
url : <domain>/api/check_out
method : POST
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer 1|ZXJu6o93WEWTzD9UY3K6K31OjxjCgeqfVMTGXp3F',    <== token dari hasil login
  'Content-Type': 'application/json'
};
body = json.encode({
    "class_id": 3,
    "id_no": 1. <== tidak dipakai, yang dipakai id user login
});  
  ``` 
  
  ``` 
  **Get Class List **
url : <domain>/api/class_list
method : GET
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer 1|ZXJu6o93WEWTzD9UY3K6K31OjxjCgeqfVMTGXp3F',    <== token dari hasil login
  'Content-Type': 'application/json'
};

  ``` 
  
 ``` 
  **Get Class By Id **
url : <domain>/api/class_list/{{class_id}}
method : GET
headers = {
  'Accept': 'application/json',
  'Authorization': 'Bearer 1|ZXJu6o93WEWTzD9UY3K6K31OjxjCgeqfVMTGXp3F',    <== token dari hasil login
  'Content-Type': 'application/json'
};

  ``` 
  
  
  Berikut postman collections lengkapnya :
  https://github.com/taufiqurrahman/ruang_sekolah/blob/master/ruangsekolah.postman_collection.json
  
  
  List Asumsi :
1. User (murid/pengajar) dapat checkin/checkout dengan menggunakan id_no user lain karena pada saat checkin/checkout user mengirim param id_no, menurut saya user cukup mengirim class_id saja sedangkan id_no dapat diambil dari data login user.
2. User (murid/pengajar) dapat checkin/checkout di beberapa kelas sekaligus karena tidak ada batasannya
3. Ada beberapa case yang belum dihandle misalnya user checkin/checkout lebih dari 1 kali pada kelas yang sama 
  
  
  

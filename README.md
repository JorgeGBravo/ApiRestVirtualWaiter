<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

post-> /users/registerUser

{
"name": "Jorge",
"surname": "Gonzalez",
"cif": "78623652N",
"address": "Victoria",
"province": "S/C de Tenerife",
"country": "Santa Cruz",
"zipcode": 40400,
"gender": "masculino",
"birthdate": "26/05/1977",
"phone": "+34658362145",
"email": "jdgbravo@gmail.com",
"isAdmin": 1
}



post-> /users/login

{
"email": "mail@gmail.com",
"password": "Password"
}

Respuesta
{
"access_token": "1|hd3hq6ywHWGIafphrmrQRmvHzWut56nRnfAAtVQG",
"token_type": "Bearer"
}


post -> /users/changePassword

{
"email": "mail@gmail.com",
"newPassword": "password"
}

post-> /user/registerCommerce

{
"tradeName": "TiendaPrueba",
"cif": "8888888N",
"address": "Victoria",
"province": "S/C de Tenerife",
"country": "Puerto de la Cruz",
"zipcode": "40400",
"phone": "+34628355406",
"email": "mail@gmail.com"
}


get-> /user/myCommerces
return:

[
{
"id": 1,
"idUser": 1,
"tradeName": "tiendaprueba",
"cif": "8888888n",
"address": "victoria",
"province": "s/c de tenerife",
"country": "Santa Cruz",
"zipcode": "38410",
"phone": "40400",
"email": "email@gmail.com",
"avatar": null,
"email_verified": null,
"status": 0,
"active": "1",
"rate": 100,
"type": 0,
"lastUserWhoModifiedTheField": 1,
"created_at": "2022-01-15T16:21:05.000000Z",
"updated_at": "2022-01-15T16:21:05.000000Z"
}
]

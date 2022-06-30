<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

##Requirement


- php > = 7.4
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- XML PHP Extension

## install

Clone from https://github.com/inspiration988/laravel-list-generator.git

`git clone https://github.com/inspiration988/laravel-list-generator.git`

Run composer install

`composer install`

## Database
you have to run migration
`php artisan migrate`

## fake data
`php artisan db:seed`

## Run API
In root directory run :
`php artisan serve`



## Apis

- list/generator POST : http://127.0.0.1:8000/api/v1/register
```{
    "list_name" : "customerList" ,
    "columns" :[ 
        {
        "type" : "text",
        "name" : "name" ,
        "caption" : "Customer Name"       
        } , 
        {
         "type" : "text",
         "name" : "description" 
        },
         {
         "type" : "integer",
         "name" : "id" ,
         "width" : 50
        },
         {
         "type" : "date",
         "name" : "created_at" ,
         "width" : 50 ,
	 "searchable" : 1
        }
    ],
    "conditions" : {
	"created_at" :
		{
            "between" :[ "2020-06-28" , "2023-06-03"]
        },
        "name" : 
            {"like" : "M"}
        ,
 	"id" : 
            {"=" : "15"}

    },
    "order" : {
		"name" : "asc" ,
		"id" : "desc"
	},
        "pagination" : {
                "pageSize" : 20,
                "pageNumber" : 0
        }

    
}
```



# Slug Api 📝  
Bu proje kullanıcının slug oluşturmasını ve yönetmesini sağlar.

## Kurulum 🚀  
Bu proje laravel 8.x versiyonunda ve php 8.1 ile geliştirilmiştir.

Kurulum için aşağıdaki adımları izleyiniz:

1. Repoyu bilgisayarınıza indirin
```
git clone https://github.com/onurNuray/slug-api.git
```
2. Dosyanın ana dizininde .env.example dosyasının formatında **.env** isimli bir dosya oluşturun.
3. **.env** dosyasında aşağıdaki alanları kendi çalışma ortamına göre yapılandırınız.
    
    **DB_HOST=** mysql databasenizin çalıştığı host

    **DB_PORT=** mysql databasenizin çalıştığı port

    **DB_DATABASE=** mysql databasenizin ismi

    **DB_USERNAME=** mysql databasenize bağlanmak için kullanıcı adı

    **DB_PASSWORD=** mysql databasenize bağlanmak için şifre

    **JWT_TOKEN=** random bir değer, şifreleme işlemleri için
4. Mysql veritabanınızda .env dostanızda belirttiğiniz isimde bir database oluşturun.
5. Php çalışma ortamanızda **php.ini** dosyanızda **extension=pdo_mysql** satırındaki markdown'u (;) kaldırın.
6. composer update komutu ile proje için gerekli paketlerin yüklenmesini sağlayın.
```
composer update
```
7. Migration'ı çalıştırın. Bu komut veritabanınızda ilgili tabloları oluşturacak.
```
php artisan migrate:fresh
```
8. Projeyi çalışma dizinizdeyken aşağıdaki kod ile ayağa kaldırın.
```
php artisan serve
```

## Postman

**Postman collection**'a postman klasörü altındaki json dosyasından ulaşılabilir.

Register ve login işlemleri dışındaki işlemler **Authorization** gerektirir. Login işleminde response datadaki token **bearer token** olarak eklenmelidir.

## Slug Yönlendirmesi

Slug yönlendirmesime için projenin çalıştığı host/{slug} şeklinde ulaşılabilir.

## Email Gönderimi

Her gün kullanıcının local saatine göre saat 10 da email gönderimi ile ilgili kodlar app/Console altındaki Commands/SendEmails.php ve kernel.php'den ulaşılabilir.
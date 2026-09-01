# BISHUDDHO Backend — Phase 1 (Catalog + Orders + Admin Panel)

এই ফাইলগুলো আপনার বিদ্যমান `backEnd` (Laravel + Sanctum) রিপোর ভেতরে বসাতে হবে।

## এতে যা আছে
- **Migrations**: categories, products, product_variants, product_images, delivery_zones, addresses, coupons, orders, order_items, order_status_histories
- **Models**: সব রিলেশন, অটো-স্লাগ/SKU জেনারেশন, স্টক হেল্পার মেথডসহ
- **Filament Admin প্যানেল**: Category, Product (variants + gallery images), Order (status track সহ), Coupon, Delivery Zone রিসোর্স + একটা ড্যাশবোর্ড স্ট্যাটস উইজেট
- বাংলা লেবেল সহ ফর্ম ও টেবিল (নেভিগেশন গ্রুপ: ক্যাটালগ / বিক্রয় / সেটিংস)

## ধাপে ধাপে ইন্সটল (Termux / লোকাল কম্পিউটার / Render shell)

**১. এই ফাইলগুলো কপি করুন**
ZIP থেকে extract করে নিচের ফোল্ডারগুলো আপনার Laravel প্রজেক্টের একই নামের ফোল্ডারে কপি/মার্জ করুন:
- `database/migrations/*` → আপনার `database/migrations/`
- `database/seeders/*` → আপনার `database/seeders/`
- `app/Models/*` → আপনার `app/Models/`
- `app/Filament/*` → আপনার `app/Filament/`

**২. Filament ইন্সটল করুন (যদি আগে না করা থাকে)**
```bash
composer require filament/filament:"^3.2" -W
php artisan filament:install --panels
```

**৩. মাইগ্রেশন রান করুন**
```bash
php artisan migrate
```

**৪. (ঐচ্ছিক) ডেলিভারি জোন সিড করুন**
```php
// database/seeders/DatabaseSeeder.php এর run() মেথডে যোগ করুন:
$this->call(DeliveryZoneSeeder::class);
```
```bash
php artisan db:seed --class=DeliveryZoneSeeder
```

**৫. অ্যাডমিন ইউজার বানান**
```bash
php artisan make:filament-user
```
এখানে নাম, ইমেইল ও পাসওয়ার্ড দিন — এটাই আপনার admin login হবে।

**৬. অ্যাডমিন প্যানেল চালু করুন**
```bash
php artisan serve
```
তারপর ব্রাউজারে যান: `http://localhost:8000/admin`

Render-এ ডিপ্লয় করা থাকলে: `https://আপনার-api-ডোমেইন/admin`

## যা এখনো বাকি (পরের ফেজ)
- Users/Roles/Permissions (spatie/laravel-permission দিয়ে Admin/Manager/Editor রোল)
- Reviews, Blog, Seasonal Campaign, Banner রিসোর্স
- পাবলিক REST API endpoints (`/api/products`, `/api/orders` ইত্যাদি) — এতক্ষণ শুধু admin প্যানেল বানানো হয়েছে, ফ্রন্টএন্ড এখনো এই ডাটার সাথে কানেক্ট না
- স্টক রিজার্ভেশন লজিক (checkout-এর সময় transaction দিয়ে stock deduct করা)
- ইনভয়েস PDF জেনারেশন

এগুলো নিয়ে পরের ধাপে কাজ করতে চাইলে বলবেন।

# BISHUDDHO — নতুন রিপো থেকে সম্পূর্ণ ফ্রেশ সেটআপ

## ⚠️ পুরোনো রিপো/কোড override করার নির্দেশনা
আগের `bishuddho-ecommerce` রিপোতে Next.js ফ্রন্টএন্ড আর Laravel ব্যাকএন্ড (Blade সহ) মিশে গিয়ে এলোমেলো হয়ে গিয়েছিল, আর একটা raw zip ফাইলও কমিট হয়ে গিয়েছিল। এই ZIP সেই সব **সম্পূর্ণ override করে** — নিচের ধাপ অনুযায়ী পুরোপুরি নতুন করে শুরু করুন:
1. চাইলে পুরোনো GitHub রিপোটা রাখুন (রেফারেন্সের জন্য) কিন্তু এখন থেকে **আর সেটাতে পুশ করবেন না**
2. GitHub-এ সম্পূর্ণ **নতুন, খালি রিপো** বানান (যেমন `bishuddho`)
3. নিচের ধাপ অনুসরণ করে এই ZIP-এর কোড দিয়েই সেই নতুন রিপো শুরু করুন — Next.js, আলাদা `backEnd` ফোল্ডার, বা পুরোনো zip ফাইল — কিছুই এখানে থাকবে না, এটা এখন একটাই পরিষ্কার Laravel প্রজেক্ট

## 🆕 নতুন যোগ হয়েছে: প্রতিটা অর্ডারের ইনভয়েস PDF ডাউনলোড
- **কাস্টমার**: অর্ডার সফল হওয়ার পেজ (`order-success`) এবং অর্ডার ট্র্যাকিং পেজ, দুই জায়গাতেই "📄 ইনভয়েস ডাউনলোড (PDF)" বাটন আছে
- **অ্যাডমিন**: Filament-এর অর্ডার লিস্টে প্রতিটা সারিতে একটা "ইনভয়েস" বাটন আছে, যেকোনো অর্ডারের PDF এক ক্লিকে ডাউনলোড করা যায়
- নিরাপত্তা: কাস্টমারের লিংকটা **signed URL** (স্বাক্ষরিত) — তাই কেউ অন্য কারো অর্ডার নম্বর অনুমান করে তার ইনভয়েস ডাউনলোড করতে পারবে না
- PDF-এ থাকে: BISHUDDHO ব্র্যান্ডিং, অর্ডার নম্বর, গ্রাহকের তথ্য, প্রতিটা পণ্যের লাইন-আইটেম, সাবটোটাল/ছাড়/ডেলিভারি/সর্বমোট
- এর জন্য নতুন প্যাকেজ লাগবে: `barryvdh/laravel-dompdf` (নিচের ধাপ ২-এ যোগ করা আছে)

এই ZIP-এ একটা পূর্ণাঙ্গ Laravel প্রজেক্টের **কাস্টম অংশ** আছে (models, migrations, Filament admin, controllers, views, routes, config)। Laravel ফ্রেমওয়ার্কের নিজের বেস ফাইল (vendor/, বুটস্ট্র্যাপ ইত্যাদি) `composer create-project` দিয়ে জেনারেট করাই সবচেয়ে নিরাপদ — তাহলে ফ্রেমওয়ার্ক ভার্সনের সাথে ১০০% মিলে যায়। নিচের ধাপগুলো অনুসরণ করুন।

> এই ধাপগুলো টার্মিনাল/SSH থেকে চালাতে হবে (কম্পিউটার, Termux, বা হোস্টিং-এর SSH এক্সেস দিয়ে) — pure মোবাইল ব্রাউজার দিয়ে এই অংশটা করা যায় না, কিন্তু GitHub-এ কোড আপলোড, Render/hosting কানেক্ট করা, Filament admin ব্যবহার করা — এসব সবই পরে মোবাইল থেকে করা যাবে।

## ধাপ ১ — ফ্রেশ Laravel প্রজেক্ট বানান
```bash
composer create-project laravel/laravel bishuddho
cd bishuddho
```

## ধাপ ২ — প্রয়োজনীয় প্যাকেজ ইন্সটল করুন
```bash
composer require filament/filament:"^3.2" -W
composer require spatie/laravel-permission
composer require league/flysystem-aws-s3-v3 "^3.0"
composer require barryvdh/laravel-dompdf

php artisan filament:install --panels
```

## ধাপ ৩ — এই ZIP-এর ফাইলগুলো বসান (ওভাররাইট করুন)
এই ZIP-এর নিচের ফোল্ডার/ফাইলগুলো আপনার নতুন `bishuddho/` প্রজেক্টের একই নামের জায়গায় কপি করে **রিপ্লেস** করুন:

```
app/            → app/
config/         → config/          (filesystems.php ওভাররাইট হবে — R2 ডিস্ক আছে)
database/       → database/        (migrations + seeders)
resources/      → resources/       (Blade ভিউ)
routes/         → routes/          (web.php, api.php, console.php — পুরোপুরি রিপ্লেস)
public/css/     → public/css/
.env.example    → .env.example
.gitignore      → .gitignore       (ইতিমধ্যে থাকলে না বদলালেও চলবে)
```

## ধাপ ৪ — `.env` সেটআপ করুন
```bash
cp .env.example .env
php artisan key:generate
```
`.env`-এ ডাটাবেস, Redis, Cloudflare R2-এর তথ্য বসান (লোকাল টেস্টের জন্য SQLite দিয়েও শুরু করতে পারেন — `DB_CONNECTION=sqlite` করে `database/database.sqlite` ফাইল বানিয়ে নিন)।

## ধাপ ৫ — মাইগ্রেট ও সিড করুন
```bash
php artisan migrate
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=DeliveryZoneSeeder
php artisan storage:link
```

## ধাপ ৬ — লোকালি চালিয়ে দেখুন
```bash
php artisan serve
```
`http://localhost:8000` — স্টোরফ্রন্ট
`http://localhost:8000/admin` — অ্যাডমিন প্যানেল (লগইন: `admin@bishuddho.com.bd` / `change-this-password` — **সাথে সাথে বদলে ফেলুন**)

`/admin` থেকে অন্তত ১-২টা ক্যাটাগরি ও কয়েকটা প্রোডাক্ট (ভ্যারিয়েন্ট সহ) যোগ করুন — নাহলে হোমপেজ খালি দেখাবে।

## ধাপ ৭ — নতুন GitHub রিপোতে পুশ করুন
```bash
git init
git add .
git commit -m "Initial commit — BISHUDDHO monolith"
git branch -M main
git remote add origin https://github.com/<আপনার-ইউজারনেম>/bishuddho.git
git push -u origin main
```

## ধাপ ৮ — প্রোডাকশনে ডিপ্লয় করুন
বিস্তারিত `docs/DEPLOYMENT-CLOUDFLARE.md`-তে আছে (সংক্ষেপে):
- **Render**-এ একটাই Web Service (Laravel পুরো অ্যাপ) + Postgres + Redis + Worker + Cron
- **Cloudflare**: শুধু DNS/CDN (ডোমেইন যোগ করুন) + R2 (ছবি স্টোরেজ) — আলাদা Pages ডিপ্লয় লাগবে না, কারণ এখন ফ্রন্টএন্ড আলাদা না
- বিকল্প: যেকোনো সাধারণ PHP 8.2+ সাপোর্টেড শেয়ার্ড হোস্টিং (cPanel), ডকুমেন্ট রুট `public/`-এ পয়েন্ট করে

## docs/ ফোল্ডারে আরও বিস্তারিত গাইড আছে
- `docs/README-BACKEND-SETUP.md` — Filament admin কী কী রিসোর্স আছে
- `docs/README-ROLES-SETUP.md` — Roles/Permissions বিস্তারিত
- `docs/README-API-SETUP.md` — পাবলিক API রেফারেন্স
- `docs/README-PHASE4-SETUP.md` — Reviews/Blog/Seasonal Campaign
- `docs/README-SIMPLE-MONOLITH.md` — এই মনোলিথ আর্কিটেকচারের ব্যাখ্যা
- `docs/DEPLOYMENT-CLOUDFLARE.md` — সম্পূর্ণ ডিপ্লয়মেন্ট গাইড

## এখনো যা বাকি (ঐচ্ছিক পরের ধাপ)
- bKash/Nagad পেমেন্ট গেটওয়ে ইন্টিগ্রেশন (এখন শুধু COD আসলে কাজ করে)
- কাস্টমার লগইন/অ্যাকাউন্ট পেজ (এখন গেস্ট চেকআউট)
- ইনভয়েস PDF জেনারেশন

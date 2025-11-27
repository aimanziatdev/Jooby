# دليل النشر - Deployment Guide

## خيارات النشر المجانية للـ Laravel

### 1. **Render.com** (الأفضل - مجاني تماماً) ⭐⭐⭐
- ✅ **مجاني تماماً** - لا حدود على عدد المشاريع
- ✅ يدعم PHP و Laravel مباشرة
- ✅ قاعدة بيانات PostgreSQL مجانية
- ✅ SSL مجاني
- ✅ يدعم File Storage (مهم للـ logos)
- ⚠️ **القيود:** ينام بعد 15 دقيقة من عدم الاستخدام (Free tier)
- **الخطوات:**
  1. اذهب إلى [render.com](https://render.com)
  2. سجل حساب جديد
  3. اختر "New Web Service"
  4. اربط GitHub repository
  5. استخدم `render.yaml` الموجود في المشروع
  6. أضف متغيرات البيئة (.env)

### 2. **Fly.io** (مجاني - سريع جداً) ⭐⭐
- ✅ **3 VMs مجانية** (3GB RAM لكل VM)
- ✅ سريع جداً - لا ينام
- ✅ يدعم Laravel بشكل ممتاز
- ✅ قاعدة بيانات مجانية (PostgreSQL)
- ⚠️ **القيود:** 3GB RAM لكل VM
- **الخطوات:**
  ```bash
  # Install flyctl
  # Windows: winget install flyctl
  # أو: https://fly.io/docs/hands-on/install-flyctl/
  
  flyctl auth login
  flyctl launch
  ```

### 3. **000webhost** (مجاني تماماً) ⭐
- ✅ **مجاني 100%** - لا حدود
- ✅ يدعم PHP/Laravel
- ✅ قاعدة بيانات MySQL مجانية
- ⚠️ **القيود:** إعلانات، أبطأ قليلاً
- **الموقع:** [000webhost.com](https://www.000webhost.com)

### 4. **InfinityFree** (مجاني تماماً) ⭐
- ✅ **مجاني 100%** - لا حدود
- ✅ يدعم PHP/Laravel
- ✅ قاعدة بيانات MySQL مجانية
- ✅ SSL مجاني
- ⚠️ **القيود:** إعلانات، أبطأ قليلاً
- **الموقع:** [infinityfree.net](https://www.infinityfree.net)

### 5. **Freehostia** (مجاني)
- ✅ **250MB storage** مجاني
- ✅ يدعم PHP/Laravel
- ✅ قاعدة بيانات MySQL
- **الموقع:** [freehostia.com](https://www.freehostia.com)

### 6. **Railway.app** (مشغول - لا ينصح به)
- ⚠️ **$5 مجانية شهرياً** - إذا استخدمته لمشروع آخر، لن يكفي
- سهل الاستخدام
- قاعدة بيانات مجانية

### 7. **Vercel** (غير مناسب)
⚠️ **مهم:** Vercel لا يدعم Laravel بشكل كامل. إذا أردت استخدام Vercel:
- تحتاج لفصل Frontend عن Backend
- Laravel كـ API فقط
- Frontend منفصل (Next.js/React/Vue)

---

## إعداد المشروع للنشر

### 1. تحديث `.env` للإنتاج:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (استخدم قاعدة بيانات من الخدمة)
DB_CONNECTION=pgsql  # أو mysql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

### 2. تشغيل الأوامر قبل النشر:
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

### 3. ملفات مهمة للنشر:
- ✅ `render.yaml` - لـ Render.com
- ✅ `railway.json` - لـ Railway
- ✅ `.gitignore` - تأكد أن `.env` غير موجود في Git

---

## النشر على Render.com (الأسهل والأفضل) ⭐

1. **سجل في [Render.com](https://render.com)**

2. **أنشئ Web Service:**
   - New → Web Service
   - اربط GitHub repo
   - Name: `jobby`
   - Environment: `PHP`
   - Build Command: `composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

3. **أنشئ PostgreSQL Database:**
   - New → PostgreSQL
   - اربطه بالـ Web Service

4. **أضف Environment Variables:**
   ```
   APP_NAME=Jobby
   APP_ENV=production
   APP_KEY=(generate with: php artisan key:generate)
   APP_DEBUG=false
   APP_URL=https://your-app.onrender.com
   
   DB_CONNECTION=pgsql
   DB_HOST=(from database)
   DB_PORT=5432
   DB_DATABASE=(from database)
   DB_USERNAME=(from database)
   DB_PASSWORD=(from database)
   
   FILESYSTEM_DISK=public
   ```

5. **Deploy!**

---

## النشر على Fly.io (سريع ولا ينام) ⭐

1. **ثبت flyctl:**
   ```bash
   # Windows
   winget install flyctl
   # أو من: https://fly.io/docs/hands-on/install-flyctl/
   ```

2. **سجل دخول:**
   ```bash
   flyctl auth login
   ```

3. **أنشئ المشروع:**
   ```bash
   flyctl launch
   # سيطلب منك:
   # - App name: jobby
   # - Region: اختر الأقرب (iad, ord, etc.)
   # - PostgreSQL: Yes
   ```

4. **أضف Environment Variables:**
   ```bash
   flyctl secrets set APP_KEY="$(php artisan key:generate --show)"
   flyctl secrets set APP_ENV=production
   flyctl secrets set APP_DEBUG=false
   ```

5. **Deploy:**
   ```bash
   flyctl deploy
   ```

---

## النشر على 000webhost (مجاني تماماً)

1. **سجل في [000webhost.com](https://www.000webhost.com)**

2. **أنشئ حساب جديد**

3. **ارفع الملفات عبر FTP:**
   - استخدم FileZilla أو أي FTP client
   - ارفع كل الملفات إلى `public_html`

4. **أنشئ قاعدة بيانات MySQL:**
   - من لوحة التحكم → MySQL Databases

5. **عدّل `.env`:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **شغل migrations:**
   - عبر SSH أو phpMyAdmin

---

## مقارنة سريعة:

| الخدمة | مجاني؟ | ينام؟ | سرعة | سهولة |
|--------|--------|-------|------|-------|
| **Render.com** | ✅ نعم | ⚠️ نعم (15 دقيقة) | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Fly.io** | ✅ نعم | ✅ لا | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **000webhost** | ✅ نعم | ⚠️ نعم | ⭐⭐ | ⭐⭐⭐ |
| **InfinityFree** | ✅ نعم | ⚠️ نعم | ⭐⭐ | ⭐⭐⭐ |

## ملاحظات مهمة:

⚠️ **لا تنشر `.env` على GitHub!**
- تأكد من وجود `.env` في `.gitignore`

⚠️ **Storage Link (للـ logos):**
```bash
php artisan storage:link
```
- على Render/Fly: سيتم تلقائياً
- على 000webhost: شغله يدوياً عبر SSH

⚠️ **Migrations:**
- Render/Fly: سيشغلون migrations تلقائياً
- أو شغل يدوياً: `php artisan migrate --force`

⚠️ **File Storage:**
- على Render/Fly: استخدم `public` disk (يعمل مباشرة)
- على 000webhost: تأكد من permissions على `storage/`

---

## التوصية النهائية:

**للمشاريع الصغيرة/التجريبية:**
- ✅ **Render.com** - الأسهل والأسرع في الإعداد

**للمشاريع التي تحتاج سرعة:**
- ✅ **Fly.io** - لا ينام، سريع جداً

**إذا كنت تريد مجاني 100% بدون قيود:**
- ✅ **000webhost** أو **InfinityFree** - لكن أبطأ قليلاً

---

## الدعم:
- Render: [docs.render.com](https://docs.render.com)
- Fly.io: [fly.io/docs](https://fly.io/docs)
- 000webhost: [000webhost.com/help](https://www.000webhost.com/help)


# نشر مجاني بدون بطاقة ائتمان 🆓

## أفضل البدائل المجانية 100% (بدون بطاقة ائتمان):

### 1. **000webhost** ⭐⭐⭐ (الأسهل)
- ✅ **مجاني 100%** - لا بطاقة ائتمان
- ✅ يدعم PHP/Laravel مباشرة
- ✅ قاعدة بيانات MySQL مجانية
- ✅ SSL مجاني
- ✅ 300MB storage
- ⚠️ **القيود:** إعلانات، أبطأ قليلاً
- **الموقع:** [000webhost.com](https://www.000webhost.com)

**الخطوات:**
1. سجل في [000webhost.com](https://www.000webhost.com)
2. اختر "Free Hosting"
3. أدخل اسم الموقع (مثلاً: jobby)
4. سجل حساب جديد
5. ارفع الملفات عبر FTP أو File Manager
6. أنشئ قاعدة بيانات MySQL من لوحة التحكم

---

### 2. **InfinityFree** ⭐⭐⭐
- ✅ **مجاني 100%** - لا بطاقة ائتمان
- ✅ يدعم PHP/Laravel
- ✅ قاعدة بيانات MySQL مجانية
- ✅ SSL مجاني
- ✅ 5GB storage
- ⚠️ **القيود:** إعلانات، أبطأ قليلاً
- **الموقع:** [infinityfree.net](https://www.infinityfree.net)

**الخطوات:**
1. سجل في [infinityfree.net](https://www.infinityfree.net)
2. اختر "Create Account"
3. أنشئ موقع جديد
4. ارفع الملفات عبر FTP
5. أنشئ قاعدة بيانات MySQL

---

### 3. **Freehostia** ⭐⭐
- ✅ **250MB storage** مجاني
- ✅ يدعم PHP/Laravel
- ✅ قاعدة بيانات MySQL
- ✅ لا بطاقة ائتمان
- **الموقع:** [freehostia.com](https://www.freehostia.com)

---

### 4. **Fly.io** ⭐⭐⭐ (الأسرع - لكن يحتاج CLI)
- ✅ **3 VMs مجانية** (3GB RAM)
- ✅ لا ينام
- ✅ سريع جداً
- ✅ قاعدة بيانات مجانية
- ⚠️ **يحتاج:** تثبيت flyctl على جهازك
- **الموقع:** [fly.io](https://fly.io)

**الخطوات:**
```bash
# 1. ثبت flyctl
winget install flyctl

# 2. سجل دخول
flyctl auth login

# 3. أنشئ المشروع
flyctl launch
```

---

### 5. **Heroku** (بديل - لكن يحتاج بطاقة ائتمان للـ Postgres)

---

## مقارنة سريعة:

| الخدمة | مجاني؟ | بطاقة ائتمان؟ | سهولة | سرعة |
|--------|--------|----------------|-------|------|
| **000webhost** | ✅ نعم | ❌ لا | ⭐⭐⭐⭐⭐ | ⭐⭐ |
| **InfinityFree** | ✅ نعم | ❌ لا | ⭐⭐⭐⭐ | ⭐⭐ |
| **Freehostia** | ✅ نعم | ❌ لا | ⭐⭐⭐ | ⭐⭐ |
| **Fly.io** | ✅ نعم | ❌ لا | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Render.com** | ✅ نعم | ⚠️ نعم (للتحقق) | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

---

## التوصية:

### للمبتدئين:
**000webhost** أو **InfinityFree** - الأسهل والأسرع في الإعداد

### للمحترفين:
**Fly.io** - الأسرع والأقوى (لكن يحتاج CLI)

---

## خطوات النشر على 000webhost (مثال):

### 1. سجل حساب:
- اذهب إلى [000webhost.com](https://www.000webhost.com)
- اضغط "Free Hosting"
- أدخل اسم الموقع: `jobby`
- سجل حساب جديد

### 2. ارفع الملفات:
- استخدم **File Manager** من لوحة التحكم
- أو استخدم **FileZilla** (FTP):
  - Host: `files.000webhost.com`
  - Username: (من لوحة التحكم)
  - Password: (من لوحة التحكم)
  - Port: `21`

### 3. أنشئ قاعدة بيانات:
- من لوحة التحكم → **MySQL Databases**
- أنشئ قاعدة بيانات جديدة
- انسخ: Host, Database name, Username, Password

### 4. عدّل `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jobby.000webhostapp.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=(اسم قاعدة البيانات)
DB_USERNAME=(اسم المستخدم)
DB_PASSWORD=(كلمة المرور)
```

### 5. شغّل migrations:
- عبر **phpMyAdmin** أو **Terminal** (إذا متوفر)
- أو استخدم **cPanel Terminal**

---

## ملاحظات مهمة:

⚠️ **على 000webhost/InfinityFree:**
- ارفع كل الملفات إلى `public_html`
- تأكد من وجود `vendor/` (أو شغّل `composer install` على السيرفر)
- تأكد من permissions على `storage/` و `bootstrap/cache`

⚠️ **Storage Link:**
```bash
php artisan storage:link
```

---

## الدعم:
- 000webhost: [help.000webhost.com](https://help.000webhost.com)
- InfinityFree: [forum.infinityfree.net](https://forum.infinityfree.net)
- Fly.io: [fly.io/docs](https://fly.io/docs)



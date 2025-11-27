# دليل النشر على Railway 🚂

## خطوات النشر على Railway:

### 1. سجل في Railway:
- اذهب إلى [railway.app](https://railway.app)
- سجل حساب جديد (يمكن استخدام GitHub)

### 2. أنشئ Project جديد:
1. اضغط `New Project`
2. اختر `Deploy from GitHub repo`
3. اختر repository: `aimanziatdev/Jooby`
4. Railway سيبدأ النشر تلقائياً

### 3. أضف PostgreSQL Database:
1. في Project → اضغط `+ New`
2. اختر `Database` → `Add PostgreSQL`
3. Railway سينشئ قاعدة بيانات تلقائياً
4. انسخ `DATABASE_URL` من Environment Variables

### 4. أضف Environment Variables:
في Project → `Variables` → أضف:

```
APP_NAME=Jobby
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
```

**لـ APP_KEY:**
```bash
php artisan key:generate --show
```
انسخ المفتاح وأضفه:
```
APP_KEY=base64:...
```

**لـ Database:**
Railway يضيف `DATABASE_URL` تلقائياً، لكن تأكد من:
```
DB_CONNECTION=pgsql
```

أو استخدم `DATABASE_URL` مباشرة (Railway يضيفه تلقائياً).

### 5. إعدادات إضافية:

**في Settings → Deploy:**
- Build Command: (سيستخدم من `railway.json`)
- Start Command: (سيستخدم من `railway.json`)

**أو يمكنك إضافة في Variables:**
```
RAILWAY_ENVIRONMENT=production
```

### 6. Deploy:
- Railway سيبدأ النشر تلقائياً بعد ربط GitHub
- انتظر حتى ينتهي (5-10 دقائق)

---

## بعد النشر:

### 1. شغّل Migrations:
في Railway Dashboard → Service → `Deployments` → `View Logs`:
- أو استخدم `Railway CLI`:
```bash
railway run php artisan migrate --force
```

### 2. Storage Link:
```bash
railway run php artisan storage:link
```

### 3. Cache Clear (اختياري):
```bash
railway run php artisan config:clear
railway run php artisan cache:clear
```

---

## ملاحظات مهمة:

✅ **Railway يستخدم `railway.json` تلقائياً**
- Build Command: `composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

✅ **Database:**
- Railway يضيف `DATABASE_URL` تلقائياً
- Laravel يقرأه تلقائياً من `.env`

✅ **Storage:**
- Railway يدعم persistent storage
- الملفات في `storage/` ستبقى

✅ **Custom Domain:**
- في Settings → `Generate Domain`
- أو أضف Custom Domain

---

## Troubleshooting:

### إذا فشل البناء:
1. تحقق من Logs في Railway Dashboard
2. تأكد من وجود `composer.json`
3. تأكد من وجود `railway.json`

### إذا فشل الاتصال بقاعدة البيانات:
1. تحقق من `DATABASE_URL` في Variables
2. تأكد من ربط Database بالـ Service

### إذا لم تعمل الصور (logos):
1. شغّل: `php artisan storage:link`
2. تأكد من permissions على `storage/`

---

## Railway CLI (اختياري):

```bash
# ثبت Railway CLI
npm i -g @railway/cli

# سجل دخول
railway login

# اربط المشروع
railway link

# شغّل migrations
railway run php artisan migrate --force
```

---

## الملفات المهمة:

- ✅ `railway.json` - إعدادات Railway
- ✅ `composer.json` - Laravel dependencies
- ✅ `.env` - Environment variables (لا ترفعه على GitHub!)

---

## الدعم:
- Railway Docs: [docs.railway.app](https://docs.railway.app)
- Railway Discord: [discord.gg/railway](https://discord.gg/railway)


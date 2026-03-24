# Deploying Jobby to Vercel & InfinityFree 🚀

## 🎯 Choose Your Platform

### **Vercel** (Recommended for beginners)
- ✅ Easiest setup
- ✅ Free tier (up to $100/month credits)
- ✅ Automatic deployments from GitHub
- ✅ Great for learning

### **InfinityFree** (Recommended for production)
- ✅ 100% free, no credit card
- ✅ 5GB storage
- ✅ MySQL database included
- ✅ Works for production sites

---

## 📋 Option 1: Deploy to Vercel

### Prerequisites:
- GitHub account with your Jobby repository
- Vercel account (free)

### Step 1: Push to GitHub ✅ (Already done!)

### Step 2: Create Vercel Account
1. Go to [vercel.com](https://vercel.com)
2. Click "Sign Up"
3. Choose "GitHub" and authorize Vercel
4. Vercel will import your GitHub repositories

### Step 3: Import Project
1. Click "Add New" → "Project"
2. Select your Jobby repository
3. Click "Import"

### Step 4: Configure Environment Variables
Before deploying, add these in Vercel Dashboard:

**Settings → Environment Variables:**

```
APP_NAME=Jobby
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_URL=https://your-domain.vercel.app

DB_CONNECTION=mysql
DB_HOST=db.infinityfree.net (or your database host)
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### Step 5: Build & Deploy
1. Vercel will auto-build on GitHub push
2. Click "Deploy"
3. Wait for build to complete (takes 2-3 minutes)

### Step 6: Get Your URL
- Your app will be at: `https://jobby.vercel.app` (or custom domain)

---

## 📋 Option 2: Deploy to InfinityFree

### Prerequisites:
- Email address
- No credit card needed

### Step 1: Create InfinityFree Account
1. Go to [infinityfree.net](https://infinityfree.net)
2. Click "Sign Up Now"
3. Fill in your details
4. Verify email

### Step 2: Create Website
1. Click "Create Account"
2. Choose domain (e.g., `jobby.infinityfree.app`)
3. Wait for account to be created (2-3 minutes)

### Step 3: Access Control Panel
1. Go to [cpanel.infinityfree.net](https://cpanel.infinityfree.net)
2. Login with your credentials
3. Look for "File Manager" or "FTP Access"

### Step 4: Get FTP Credentials
In Control Panel:
- **Host:** (shown in FTP section)
- **Username:** (shown in FTP section)
- **Password:** (shown in FTP section)
- **Port:** 21

### Step 5: Download/Prepare Files
```bash
# From your local machine:
cd c:/Users/Dell/Desktop/jobby/Jooby

# Install dependencies (if not done)
composer install

# Build assets
npm install
npm run build
```

### Step 6: Upload Files via FTP
Use **FileZilla** (free FTP client):

1. Download [FileZilla](https://filezilla-project.org/)
2. File → Site Manager → New Site
3. Enter FTP credentials:
   - **Protocol:** FTP
   - **Host:** (your FTP host)
   - **Username:** (your FTP username)
   - **Password:** (your FTP password)
4. Connect
5. Upload all files to `public_html/`

⚠️ **Important:**
- Upload everything EXCEPT `node_modules/` and `.git/`
- Make sure `.env` is included with correct database settings
- Upload `vendor/` folder (composer dependencies)

### Step 7: Create MySQL Database
In Control Panel:
1. Go to **MySQL Databases**
2. Create new database:
   - Database name: `jobby_db`
   - Username: `jobby_user`
   - Password: (generate strong password)
3. **Copy and save these credentials!**

### Step 8: Configure .env
1. Edit `.env` file on the server via File Manager:

```env
APP_NAME=Jobby
APP_ENV=production
APP_DEBUG=false
APP_URL=https://jobby.infinityfree.app

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jobby_db
DB_USERNAME=jobby_user
DB_PASSWORD=your_generated_password
```

### Step 9: Run Migrations
Option A (via phpMyAdmin):
1. Go to **phpMyAdmin** in Control Panel
2. Import SQL migrations manually

Option B (via Terminal - if available):
```bash
php artisan migrate --force
```

Option C (Simple - use Adminer):
1. Create tables manually using phpMyAdmin
2. Import the migration SQL files from `database/migrations/`

### Step 10: Create Storage Link
```bash
php artisan storage:link
```

### Step 11: Set Permissions
Via File Manager, change permissions:
- `storage/` → 755
- `bootstrap/cache/` → 755
- `public/` → 755

### Step 12: Test Your Site
1. Go to `https://jobby.infinityfree.app`
2. You should see the Jobby homepage
3. Try to register a test account
4. Test the chatbot and notifications

---

## 🔄 Option 3: Deploy to Both (Best Solution)

### Use InfinityFree as Database + Vercel as Frontend
1. Create MySQL database on InfinityFree
2. Deploy app to Vercel
3. Point Vercel to InfinityFree's database in `.env`

This gives you:
- ✅ Fast frontend (Vercel CDN)
- ✅ Free database (InfinityFree)
- ✅ Auto-scaling
- ✅ Best performance

---

## 🐛 Troubleshooting

### "500 Server Error"
- Check `.env` is correct
- Check database connection
- Check file permissions
- Run `php artisan migrate:reset && php artisan migrate`

### "Database Connection Error"
- Verify DB credentials in `.env`
- Check database exists in control panel
- Make sure database user can access it
- Use localhost for InfinityFree (not IP)

### "Storage/Cache Not Writable"
```bash
# On server via File Manager or SSH:
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### "Composer Dependencies Missing"
- Upload `vendor/` folder
- Or run `composer install` on server
- Make sure `composer.json` and `composer.lock` are uploaded

### "Assets Not Loading"
```bash
php artisan storage:link
npm run build
```

---

## 📊 Performance Tips

### For InfinityFree:
- Enable gzip compression (in `.htaccess`)
- Cache database queries
- Use CDN for images (Cloudflare free)
- Optimize images before upload

### For Vercel:
- Use Vercel Analytics
- Check build logs for errors
- Enable automatic deployments from GitHub

---

## 🔐 Security Checklist

- [ ] Change `APP_KEY` to random value
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong database passwords
- [ ] Keep `.env` file secure (not in git)
- [ ] Enable HTTPS (automatic on both platforms)
- [ ] Validate all user inputs
- [ ] Use rate limiting

---

## 📞 Support

**Vercel Issues:** [vercel.com/docs](https://vercel.com/docs)
**InfinityFree Issues:** [forum.infinityfree.net](https://forum.infinityfree.net)
**Laravel Issues:** [laravel.com/docs](https://laravel.com/docs)

---

## 🎉 Next Steps After Deployment

1. Test all features:
   - User registration
   - Job posting
   - Applications
   - Offers
   - Chatbot
   - Notifications

2. Monitor performance:
   - Check database queries
   - Monitor storage usage
   - Watch error logs

3. Get custom domain:
   - Buy domain on Namecheap
   - Point DNS to Vercel/InfinityFree
   - Enable SSL

4. Backup strategy:
   - Regular database backups
   - File backups
   - Git commits

---

**Good luck! 🚀 Your Jobby app is ready for the world!**

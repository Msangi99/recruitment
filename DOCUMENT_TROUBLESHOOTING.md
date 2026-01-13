# Document Access Troubleshooting

## ✅ Current Status:

**File EXISTS:** `c:\wamp64\www\recruitment\public\documents\4\1768256982_download.pdf`

**URL Should Be:** `http://127.0.0.1:8000/documents/4/1768256982_download.pdf`

---

## 🧪 Tests to Run:

### Test 1: Simple HTML Test Page
I created a test page for you. Open this in your browser:
```
http://127.0.0.1:8000/test-doc.html
```

This page will:
- ✅ Show a direct link to your document
- ✅ Try to embed the PDF in an iframe
- ✅ Show a test image from public folder

**If the image loads but PDF doesn't:** PDF file has an issue  
**If nothing loads:** Public folder has an issue  
**If link works but iframe doesn't:** Browser security blocking

---

### Test 2: Direct URL Test
Open this URL directly in your browser:
```
http://127.0.0.1:8000/documents/4/1768256982_download.pdf
```

**What to check:**
- Does browser show "Loading..."?
- Does it show "404 Not Found"?
- Does it download the file?
- Does it show a blank page?
- Does it show an error?

---

### Test 3: Check Browser Console
1. Press **F12** to open developer tools
2. Go to **Console** tab
3. Try to open the document URL
4. Look for any error messages

Common errors:
- `net::ERR_ABORTED` - Server blocked the request
- `Failed to load PDF document` - PDF file is corrupt
- `404 Not Found` - File path is wrong
- `403 Forbidden` - Permission issue

---

### Test 4: Check Network Tab
1. Press **F12** to open developer tools
2. Go to **Network** tab
3. Click the document link
4. Look at the request details:
   - **Status Code:** Should be `200 OK`
   - **Content-Type:** Should be `application/pdf`
   - **Content-Length:** Should show file size

---

## 🔍 Possible Issues:

### Issue 1: WAMP URL Rewriting
**Symptom:** File exists but URL returns 404

**Solution:** Check Apache configuration
```
# In httpd.conf, make sure mod_rewrite is enabled:
LoadModule rewrite_module modules/mod_rewrite.so

# Also check:
<Directory "c:/wamp64/www/">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

### Issue 2: File Permissions
**Symptom:** File exists but can't be read

**Solution:** Check file permissions
```powershell
icacls "c:\wamp64\www\recruitment\public\documents\4\1768256982_download.pdf"
```

Should show:
- Everyone: Read access
- IIS_IUSRS or IUSR: Read access

### Issue 3: .htaccess Blocking PDFs
**Symptom:** Images work but PDFs don't

**Solution:** Check if .htaccess has PDF rules

### Issue 4: Browser Caching
**Symptom:** Old URL works, new URL doesn't

**Solution:**
- Press **Ctrl + Shift + Delete**
- Clear cache and cookies
- Try in Incognito/Private mode

### Issue 5: Antivirus Blocking
**Symptom:** Random files don't load

**Solution:**
- Temporarily disable antivirus
- Add WAMP folder to exceptions

---

## 📝 What to Send Me:

Please try the tests above and send me:

1. **Test 1 Result:**
   - Does test-doc.html load?
   - Does the image show?
   - Does the PDF load in iframe?

2. **Test 2 Result:**
   - What happens when you open the direct URL?
   - Screenshot if possible

3. **Browser Console:**
   - Any error messages?

4. **Network Tab:**
   - Status code?
   - Response headers?

5. **Working Example:**
   - Does this work? `http://127.0.0.1:8000/logo.jpg`

---

## 🎯 Quick Fixes to Try:

### Fix 1: Restart WAMP
```
1. Stop all WAMP services
2. Start all WAMP services
3. Try the URL again
```

### Fix 2: Clear Laravel Cache
```powershell
cd c:\wamp64\www\recruitment
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### Fix 3: Check Apache Error Log
```
C:\wamp64\logs\apache_error.log
```
Look for recent errors related to your document path.

### Fix 4: Test with profile picture
Does this work?
```
http://127.0.0.1:8000/profile-pictures/profile_4_1768254853.jpeg
```

If profile picture works, documents should work too (same setup).

---

## ✅ Expected Behavior:

When everything works correctly:
1. You click document link
2. Browser opens PDF in new tab
3. PDF displays or downloads immediately
4. No errors in console

---

**Start with Test 1:** Open `http://127.0.0.1:8000/test-doc.html` and tell me what you see!

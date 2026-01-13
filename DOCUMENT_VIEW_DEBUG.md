# Document View Debugging Guide

## 🐛 Issue: "Can't reach this page" when viewing documents

### Quick Diagnosis Steps:

#### Step 1: Check if you're logged in as Admin
1. Open your browser's developer console (F12)
2. Go to: `http://localhost/recruitment/admin/dashboard`
3. If you see the admin dashboard, you're logged in correctly ✅
4. If you're redirected to login, you need to log in first ❌

#### Step 2: Check the Document View Link
1. Go to: `http://localhost/recruitment/admin/candidates/4`
2. Right-click on the "View Document" icon (🔗)
3. Select "Copy Link Address"
4. It should look like: `http://localhost/recruitment/admin/verification/document/1/view`
5. Paste the link in a NEW TAB and press Enter

#### Step 3: Check the Logs
After clicking the view link, check the logs immediately:

```powershell
Get-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log" -Tail 50
```

Look for messages like:
- `Admin viewing document` - ✅ Good, the route is being accessed
- `Document file not found` - ❌ File issue
- `404` or `403` - ❌ Route or permission issue

#### Step 4: Check Your User Role
Run this command to verify you're an admin:

```powershell
php c:\wamp64\www\recruitment\artisan tinker --execute="echo 'User ID: ' . auth()->id() . PHP_EOL; echo 'Role: ' . auth()->user()->role . PHP_EOL;"
```

Expected output:
```
User ID: 1
Role: admin
```

If role is NOT "admin", you can't access admin routes!

---

## 🔍 Common Issues and Solutions:

### Issue 1: "404 Not Found"
**Cause:** Route not found or document doesn't exist

**Solution:**
```powershell
# Check if route exists
php c:\wamp64\www\recruitment\artisan route:list --name=admin.verification.document.view

# Check if document exists in database
php c:\wamp64\www\recruitment\artisan tinker --execute="print_r(DB::table('documents')->where('id', 1)->first());"
```

### Issue 2: "403 Forbidden"
**Cause:** You're not logged in as admin

**Solution:**
1. Log out completely
2. Log in with an admin account
3. Your user in the `users` table MUST have `role = 'admin'`

### Issue 3: "500 Server Error"
**Cause:** File path or permission issue

**Solution:**
```powershell
# Check if file exists
Test-Path "c:\wamp64\www\recruitment\storage\app\private\documents\4\1768252163_download.pdf"

# Check file permissions
Get-Acl "c:\wamp64\www\recruitment\storage\app\private\documents\4\1768252163_download.pdf" | Format-List
```

### Issue 4: Blank Page / No Response
**Cause:** File is too large or browser issue

**Solution:**
1. Check file size:
   ```powershell
   Get-Item "c:\wamp64\www\recruitment\storage\app\private\documents\4\1768252163_download.pdf" | Select-Object Length
   ```
2. Try a different browser
3. Check PHP max execution time in `php.ini`

---

## 🧪 Test Document Viewing Manually:

### Test 1: Direct URL Access
1. Make sure you're logged in as admin
2. Go to: `http://localhost/recruitment/admin/verification/document/1/view`
3. You should see the PDF or get a download prompt

### Test 2: Check Browser Console
1. Open Developer Tools (F12)
2. Go to Network tab
3. Click the "View Document" link
4. Check the network request:
   - **Status 200** = Success ✅
   - **Status 302** = Redirect (probably not logged in) ⚠️
   - **Status 403** = Forbidden (not admin) ❌
   - **Status 404** = Not found (document doesn't exist) ❌
   - **Status 500** = Server error (file issue) ❌

### Test 3: Check if Link is Correct
In the candidate detail page, inspect the HTML:

```html
<a href="http://localhost/recruitment/admin/verification/document/1/view" 
   target="_blank" 
   class="p-2 text-gray-400 hover:text-blue-600 transition-colors" 
   title="View Document">
    <i data-lucide="external-link" class="w-4 h-4"></i>
</a>
```

The `href` should be a full URL starting with `http://localhost/recruitment/admin/verification/document/`

---

## 🎯 What I Added (Debugging):

I've added detailed logging to `VerificationController@viewDocument`:

```php
// Logs when admin tries to view a document
\Log::info('Admin viewing document', [
    'admin_id' => auth()->id(),
    'document_id' => $document->id,
    'document_path' => $document->file_path,
]);

// Logs if file is not found
\Log::error('Document file not found in storage', [
    'document_id' => $document->id,
    'file_path' => $document->file_path,
]);

// Logs when serving the file
\Log::info('Serving document file', [
    'document_id' => $document->id,
    'file_path' => $filePath,
    'mime_type' => $mimeType,
]);
```

After you click the "View Document" link, check the logs and send me the output!

---

## 📝 Next Steps:

1. **Try clicking the "View Document" link** on the candidate page
2. **Check what happens** (error message, blank page, redirect, etc.)
3. **Check the logs** immediately after:
   ```powershell
   Get-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log" -Tail 50
   ```
4. **Send me:**
   - What error/message you see
   - The last 50 lines from the log
   - Your browser console errors (if any)

---

## ✅ If Everything is Working:

You should:
1. Click "View Document" link
2. See the PDF open in a new tab
3. See logs showing:
   ```
   [timestamp] local.INFO: Admin viewing document {"admin_id":1,"document_id":1,...}
   [timestamp] local.INFO: Serving document file {"document_id":1,"file_path":"...","mime_type":"application/pdf",...}
   ```

**Last Updated:** January 13, 2026

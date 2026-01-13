# Profile Picture Upload Debugging Guide

## Current Status
✅ Directory exists: `c:\wamp64\www\recruitment\public\profile-pictures`
✅ Directory is writable (permissions: 0777)
✅ PHP file uploads enabled
✅ Upload max filesize: 2M
✅ Post max size: 8M

## Issue
Profile pictures are not being saved to the profile-pictures folder.

## Steps to Debug

### 1. Try uploading again and check:

After uploading, check the log file:
```powershell
Get-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log" -Tail 20
```

### 2. Common Issues & Solutions:

#### Issue A: File too large
**Symptoms:** No error message, file just doesn't upload
**Solution:** Ensure image is less than 2MB

#### Issue B: Wrong file type
**Symptoms:** Error message about file type
**Solution:** Use only JPEG, JPG, PNG, or GIF files

#### Issue C: Laravel PUT method with files
**Symptoms:** File shows as received but doesn't save
**Solution:** Already implemented - using POST with @method('PUT')

### 3. Manual Test:

Visit: `http://localhost/recruitment/test_upload.php`

This will show:
- Directory permissions
- PHP upload settings
- Test file creation

### 4. Check Browser Console:

1. Open browser Developer Tools (F12)
2. Go to Network tab
3. Upload a profile picture
4. Check the request details:
   - Request Method should be: POST
   - Content-Type should include: multipart/form-data
   - Check if file is in Form Data

### 5. Verify the form:

The form must have:
```html
<form method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="file" name="profile_picture" accept="image/*">
</form>
```

## What to Look For in Logs:

### Success Pattern:
```
Profile picture upload started
Profile picture uploaded successfully
```

### Error Patterns:
- "Invalid file uploaded" → File validation failed
- "Invalid file type" → Wrong MIME type
- "File size exceeds 2MB" → File too large
- "Failed to move uploaded file" → Permission issue
- "File was uploaded but could not be verified" → File didn't save

## Testing Instructions:

1. **Clear the log file first:**
   ```powershell
   Clear-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log"
   ```

2. **Try to upload a small image (< 500KB)**

3. **Check the log immediately:**
   ```powershell
   Get-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log"
   ```

4. **Check the directory:**
   ```powershell
   Get-ChildItem "c:\wamp64\www\recruitment\public\profile-pictures"
   ```

## Expected Behavior:

✅ After upload, you should see a file named like:
   `profile_4_1768252495.jpg` (where 4 is your user ID)

✅ The file should appear in:
   `c:\wamp64\www\recruitment\public\profile-pictures\`

✅ Your profile page should display the image

## Next Steps if Still Failing:

Run this command to get detailed file upload info:
```powershell
php -r "phpinfo();" | Select-String -Pattern "upload"
```

This will show all PHP upload-related settings.

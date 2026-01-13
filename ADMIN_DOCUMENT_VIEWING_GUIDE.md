# Admin Document Viewing Guide

## 📋 How to View Candidate Documents as Admin

### Method 1: From Pending Verifications Page ✅ (FIXED)

**Step 1:** Go to **Pending Verifications**
- URL: `/admin/verification/pending`
- Or click "Pending Verifications" in the sidebar

**Step 2:** You'll see a list of candidates waiting for approval with:
- ✅ **Candidate Name** (NOW CLICKABLE - click to view details)
- ✅ **Document Count** (NOW CLICKABLE - click to view documents)
- ✅ **"View Details" button** (NEW - takes you to candidate page)

**Step 3:** Click any of these:
- Click on the **candidate's name**
- Click on the **document count badge**
- Click the **"View Details" button**

**Step 4:** You'll be taken to the candidate detail page where you can:
- ✅ View all uploaded documents
- ✅ Click "View Document" icon to open each document
- ✅ Approve or Reject individual documents
- ✅ View profile information

---

### Method 2: From Candidates List

**Step 1:** Go to **Candidates Management**
- URL: `/admin/candidates`
- Or click "Candidates" in the sidebar

**Step 2:** Click "View Details" on any candidate

**Step 3:** Scroll down to "Uploaded Documents" section

**Step 4:** Click the "View Document" icon (external link icon) to open the document

---

## 📄 Document Viewing Interface

When you view a candidate's details, the **"Uploaded Documents"** section shows:

```
┌─────────────────────────────────────────────────────┐
│  Uploaded Documents                                  │
├─────────────────────────────────────────────────────┤
│  📄 CV/Resume                                        │
│     filename.pdf                                     │
│     [PENDING] [View] [Approve] [Reject]             │
├─────────────────────────────────────────────────────┤
│  📄 Passport                                         │
│     passport.jpg                                     │
│     [APPROVED] [View]                                │
└─────────────────────────────────────────────────────┘
```

**Actions Available:**
- 👁️ **View** - Opens document in new tab
- ✅ **Approve** - Marks document as verified (only for pending docs)
- ❌ **Reject** - Rejects document with reason (only for pending docs)

---

## 🔗 All Admin Document Routes

### View Documents:
```
GET  /admin/verification/pending                    → List pending verifications
GET  /admin/candidates                              → List all candidates
GET  /admin/candidates/{candidate}                  → View candidate details (with documents)
GET  /admin/verification/document/{document}/view   → View specific document
```

### Approve/Reject:
```
POST /admin/verification/document/{document}/approve  → Approve document
POST /admin/verification/document/{document}/reject   → Reject document with reason
POST /admin/verification/profile/{profile}/approve    → Approve entire profile
POST /admin/verification/profile/{profile}/reject     → Reject entire profile
```

---

## 📂 Where Documents Are Stored

**Path:** `c:\wamp64\www\recruitment\storage\app\private\documents\{user_id}\`

**Example:**
```
storage/app/private/documents/
├── 2/
│   └── 1768092573_COYZON website .pdf
└── 4/
    └── 1768252163_download.pdf
```

**Security:** 
- 🔒 Documents are in **private storage** (not web accessible)
- 🔒 Can only be viewed through authenticated routes
- 🔒 Admin authentication required

---

## 🎯 Quick Access Workflow

### To Review and Approve Documents:

1. **Go to:** `/admin/verification/pending`
2. **See candidate** with "2 document(s)" badge
3. **Click** on the candidate name OR document count OR "View Details"
4. **Review** all documents in the "Uploaded Documents" section
5. **Click** the view icon (🔗) next to each document to open it
6. **Action:**
   - If document is valid: Click **"Approve"**
   - If document is invalid: Click **"Reject"** and provide reason
7. **Approve Profile:** After all documents are verified, go back and approve the entire profile

---

## 🐛 Troubleshooting

### "Can't reach this page" Error:

**Possible Causes:**
1. ❌ Not logged in as admin
2. ❌ Document doesn't exist in database
3. ❌ File was deleted from storage
4. ❌ Route not defined

**Solutions:**
✅ Make sure you're logged in as admin (role: 'admin')
✅ Check if document exists in database
✅ Verify file exists at: `storage/app/private/documents/{user_id}/{filename}`
✅ Check logs: `storage/logs/laravel.log`

### Document Won't Open:

**Check:**
1. File exists in storage
2. File permissions are correct
3. Route exists: `php artisan route:list --name=admin.verification.document.view`

---

## ✅ What Was Fixed

### Before:
- ❌ No way to click on candidate from pending verification page
- ❌ Document count was just text, not clickable
- ❌ Had to manually type URL to view candidate details

### After (Now):
- ✅ Candidate name is now a clickable link
- ✅ Document count is now a clickable badge
- ✅ Added "View Details" button for each candidate
- ✅ All three options take you to the candidate detail page
- ✅ Can view and approve/reject documents from there

---

## 📧 Need More Help?

Check the logs for errors:
```powershell
Get-Content "c:\wamp64\www\recruitment\storage\logs\laravel.log" -Tail 50
```

List all admin routes:
```powershell
php artisan route:list --name=admin
```

Check if you're logged in as admin:
- Your user role should be: `admin`
- Check in database: `users` table, `role` column

---

**Last Updated:** January 13, 2026
**Status:** ✅ FIXED - All links working

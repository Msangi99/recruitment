# SSL Certificate Fix for Selcom Payments

## Problem
cURL error 60: SSL certificate problem: self-signed certificate in certificate chain

This error occurs on Windows/local development environments when making HTTPS requests to Selcom's API.

## Solution 1: Disable SSL Verification (Development Only)

Add this to your `.env` file:

```env
# Disable SSL verification for local development
SELCOM_VERIFY_SSL=false
```

**⚠️ WARNING**: Only use this in development. Never disable SSL verification in production!

## Solution 2: Fix SSL Certificate Bundle (Recommended for Production)

### For Windows/WAMP:

1. **Download CA Certificate Bundle**:
   - Download `cacert.pem` from: https://curl.se/ca/cacert.pem
   - Save it to: `C:\wamp64\bin\php\php8.x.x\extras\ssl\cacert.pem`

2. **Update php.ini**:
   ```ini
   curl.cainfo = "C:\wamp64\bin\php\php8.x.x\extras\ssl\cacert.pem"
   openssl.cafile = "C:\wamp64\bin\php\php8.x.x\extras\ssl\cacert.pem"
   ```

3. **Restart WAMP**:
   - Restart Apache/PHP services

4. **Update .env**:
   ```env
   SELCOM_VERIFY_SSL=true
   ```

### For Linux:

1. **Install CA certificates**:
   ```bash
   sudo apt-get install ca-certificates
   ```

2. **Update php.ini**:
   ```ini
   curl.cainfo = "/etc/ssl/certs/ca-certificates.crt"
   ```

3. **Update .env**:
   ```env
   SELCOM_VERIFY_SSL=true
   ```

## Solution 3: Use Custom SelcomService (Already Implemented)

The `SelcomService` class has been created to handle SSL issues automatically. It:
- Disables SSL verification by default for local development
- Can be configured via `SELCOM_VERIFY_SSL` environment variable
- Falls back to the original Selcom package if needed

## Testing

After applying the fix:

1. Clear config cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. Test payment:
   - Try booking a consultation
   - Select Selcom as payment gateway
   - Verify payment URL is generated

## Production Checklist

- [ ] SSL verification enabled (`SELCOM_VERIFY_SSL=true`)
- [ ] CA certificate bundle properly configured
- [ ] HTTPS enabled on production server
- [ ] Test payment flow in production
- [ ] Verify webhook callbacks work

---

**Current Status**: SSL verification disabled for development. Update `SELCOM_VERIFY_SSL=true` for production.

# Selcom Live/Production Setup Guide

## ✅ Live Credentials Configured

Your Selcom payment gateway has been configured for **LIVE/PRODUCTION** mode.

### Live Credentials:
- **Vendor ID**: `TILL60917564`
- **API Key**: `MOBIAD-BAE4439D874CAFF7`
- **API Secret**: `MOBIAD-BAE4439D874CAFF7`
- **Mode**: LIVE (Production)

---

## 🔧 Update Your .env File

Add or update these lines in your `.env` file:

```env
# Selcom Payment Gateway - LIVE MODE
SELCOM_VENDOR_ID=TILL60917564
SELCOM_API_KEY=MOBIAD-BAE4439D874CAFF7
SELCOM_API_SECRET=MOBIAD-BAE4439D874CAFF7
SELCOM_IS_LIVE=true

# Update these URLs to your production domain
SELCOM_REDIRECT_URL=https://yourdomain.com/selcom/redirect
SELCOM_CANCEL_URL=https://yourdomain.com/selcom/cancel
SELCOM_PREFIX=COYZON

# Selcom Theme Colors (Optional)
SELCOM_HEADER_COLOR="#1a73e8"
SELCOM_LINK_COLOR="#000000"
SELCOM_BUTTON_COLOR="#1a73e8"
```

---

## ⚠️ Important Notes

1. **Update Redirect URLs**: 
   - Replace `yourdomain.com` with your actual production domain
   - Ensure these URLs are accessible and point to your Laravel routes

2. **Webhook Configuration**:
   - Configure webhook URL in Selcom dashboard: `https://yourdomain.com/selcom/webhook`
   - Ensure your server can receive POST requests from Selcom

3. **Security**:
   - Never commit `.env` file to version control
   - Keep credentials secure and private
   - Use HTTPS in production

4. **Testing**:
   - Test with small amounts first
   - Verify webhook callbacks are working
   - Check payment status updates in database

---

## 🧪 Testing Checklist

- [ ] Update `.env` file with live credentials
- [ ] Update redirect URLs to production domain
- [ ] Configure webhook URL in Selcom dashboard
- [ ] Test payment flow with small amount
- [ ] Verify webhook receives payment callbacks
- [ ] Check appointment status updates correctly
- [ ] Verify email notifications are sent
- [ ] Test both mobile money and card payments

---

## 📞 Support

- **Selcom Documentation**: https://github.com/bryceandy/laravel-selcom
- **Selcom Support**: Contact Selcom support for production issues

---

**Status**: ✅ Live credentials configured | ⚠️ Update .env file and redirect URLs

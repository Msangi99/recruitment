# COYZON Recruitment Platform - Laravel Implementation Guide

## 📋 Project Overview
**COYZON** is a global recruitment gateway connecting skilled job seekers with trusted employers across multiple industries (Agriculture, Construction, Logistics, Hospitality, etc.).

---

## ✅ Completed Setup

### 1. **Payment Gateways Integration**

#### Selcom Integration
- ✅ Installed `bryceandy/laravel-selcom` package
- ✅ Published Selcom configuration
- ✅ Supports: M-Pesa, Tigo Pesa, Airtel Money, Halopesa, and Card payments

#### AzamPay Integration
- ✅ Created AzamPay service (`App\Services\AzamPayService`)
- ✅ AzamPay configuration file (`config/azampay.php`)
- ✅ AzamPay controller for webhooks and redirects
- ✅ Supports: M-Pesa, Tigo Pesa, Airtel, Bank Transfer, and Card payments
- ✅ Webhook handler for payment callbacks
- ✅ Payment verification system

### 2. **Database Structure**
All migrations created and executed successfully:

#### Tables Created:
1. **users** - Extended with role, phone, address, city, country, postcode, is_active
2. **categories** - Job categories (Agriculture, Construction, etc.)
3. **candidate_profiles** - Extended candidate information with verification
4. **documents** - Secure storage for IDs, Passports, CVs
5. **job_listings** - Job postings with full details (includes status: open/closed/urgent)
6. **appointments** - Booking system with payment tracking
7. **job_applications** - Application tracking
8. **selcom_payments** - Payment transaction records (from Selcom package)

### 3. **Models Created**
All models with relationships and helper methods:
- ✅ User (with role-based methods)
- ✅ Category
- ✅ CandidateProfile
- ✅ Document
- ✅ JobListing (with status field)
- ✅ Appointment
- ✅ JobApplication

---

## 🔧 Environment Configuration Needed

Add these to your `.env` file:

```env
# Application
APP_NAME="COYZON Recruitment"
APP_URL=http://localhost

# Selcom Payment Gateway (LIVE/PRODUCTION)
SELCOM_VENDOR_ID=TILL60917564
SELCOM_API_KEY=MOBIAD-BAE4439D874CAFF7
SELCOM_API_SECRET=MOBIAD-BAE4439D874CAFF7
SELCOM_IS_LIVE=true
SELCOM_VERIFY_SSL=false

# Optional Selcom Settings
# Update these URLs to your production domain
SELCOM_REDIRECT_URL=https://yourdomain.com/selcom/redirect
SELCOM_CANCEL_URL=https://yourdomain.com/selcom/cancel
SELCOM_PREFIX=COYZON

# Selcom Theme Colors (Optional)
SELCOM_HEADER_COLOR="#1a73e8"
SELCOM_LINK_COLOR="#000000"
SELCOM_BUTTON_COLOR="#1a73e8"

# AzamPay Payment Gateway
AZAMPAY_APP_NAME="COYZON Recruitment"
AZAMPAY_CLIENT_ID=your_client_id
AZAMPAY_CLIENT_SECRET=your_client_secret
AZAMPAY_ENVIRONMENT=sandbox
AZAMPAY_TOKEN=your_token
AZAMPAY_WEBHOOK_URL=/azampay/webhook
AZAMPAY_REDIRECT_URL=/azampay/redirect
AZAMPAY_CANCEL_URL=/azampay/cancel

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@coyzon.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🎯 User Roles

The system supports 4 user roles:

1. **Admin** - Full control over the platform
   - Verify candidates and documents
   - Manage job listings
   - View all appointments
   - Access analytics

2. **Employer** - Post jobs and hire candidates
   - Browse candidate pool
   - Post job listings
   - Review applications
   - Schedule interviews

3. **Candidate** - Find jobs and apply
   - Create profile
   - Upload documents (ID, Passport, CV)
   - Apply for jobs
   - Book consultations (with payment via Selcom or AzamPay)

4. **Guest** - Limited access
   - Browse jobs
   - View basic candidate info

---

## 💳 Payment Flow

### Appointment Booking Payment
**Amount**: TZS 30,000 or $12

#### Selcom Payment
```php
use Bryceandy\Selcom\Facades\Selcom;

// For mobile money (USSD)
Selcom::checkout([
    'name' => $user->name,
    'email' => $user->email,
    'phone' => $user->phone,
    'amount' => 30000,
    'transaction_id' => 'APPT-' . $appointment->id,
    'no_redirection' => true,
]);

// For card payments
return Selcom::cardCheckout([
    'name' => $user->name,
    'email' => $user->email,
    'phone' => $user->phone,
    'amount' => 30000,
    'transaction_id' => 'APPT-' . $appointment->id,
    'address' => $user->address,
    'postcode' => $user->postcode,
]);
```

#### AzamPay Payment
```php
use App\Services\AzamPayService;

$azampay = new AzamPayService();

// Mobile Money Checkout
$response = $azampay->mobileCheckout([
    'amount' => 30000,
    'currency' => 'TZS',
    'accountNumber' => '0625933171',
    'externalId' => 'APPT-' . $appointment->id,
    'provider' => 'Mpesa', // Mpesa, Tigo Pesa, Airtel, Azampay
]);

// Bank Checkout
$response = $azampay->bankCheckout([
    'amount' => 30000,
    'currency' => 'TZS',
    'merchantAccountNumber' => 'your_account',
    'merchantMobileNumber' => $user->phone,
    'externalId' => 'APPT-' . $appointment->id,
]);

// Card Checkout
$response = $azampay->cardCheckout([
    'amount' => 30000,
    'currency' => 'TZS',
    'cardNumber' => $cardNumber,
    'cardHolderName' => $user->name,
    'cardExpiry' => $expiry,
    'cardCvv' => $cvv,
    'externalId' => 'APPT-' . $appointment->id,
]);
```

### Payment Webhook Handlers

#### Selcom Webhook
Create a listener for `CheckoutWebhookReceived` event:

```php
// app/Listeners/ProcessAppointmentPayment.php
use Bryceandy\Selcom\Events\CheckoutWebhookReceived;

class ProcessAppointmentPayment
{
    public function handle(CheckoutWebhookReceived $event)
    {
        $orderId = $event->orderId;
        
        // Update appointment payment status
        $appointment = Appointment::where('order_id', $orderId)->first();
        
        if ($appointment) {
            $appointment->update([
                'payment_status' => 'completed',
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            
            // Send confirmation email/WhatsApp
            // Generate meeting link (Zoom/Google Meet)
        }
    }
}
```

#### AzamPay Webhook
The webhook is handled automatically at `/azampay/webhook` route. It processes payment callbacks and updates appointment status accordingly.

---

## 📝 Key Features Implemented

### 1. **5-Step Candidate Registration**
- Step 1: Basic registration (name, email, password)
- Step 2: Personal information (DOB, citizenship, etc.)
- Step 3: Professional details (skills, experience, education)
- Step 4: Document upload (ID/Passport, CV)
- Step 5: Admin verification & profile activation

### 2. **Job Search & Filter**
Advanced filtering by:
- Category
- Experience level
- Education
- Language
- Salary range
- Location
- Job status (Open/Closed/Urgent)

### 3. **Candidate Pool (Employer View)**
- Searchable database
- Profile cards with skills/experience
- Privacy: Hide contact info until employer requests

### 4. **Appointment Booking**
- Calendar scheduling
- Online (Zoom/Google Meet) or In-person
- Mandatory payment (TZS 30,000 or $12)
- Payment gateway selection (Selcom or AzamPay)
- Automated notifications (Email)
- Webhook handlers for both gateways

### 5. **Admin Dashboard**
- Candidate verification workflow
- Document approval/rejection
- Job listing management
- Appointment oversight
- Payment management

### 6. **Public Website Features**
- Hero section with fade/cross-fade image carousel
- Industry cards section
- Circular recruitment process visualization
- Interactive world map
- FAQ accordion
- Team section with real images

---

## 🔐 Security Considerations

1. **Document Storage**: Store sensitive files outside public directory
2. **Role-Based Access**: Use middleware to protect routes
3. **Payment Verification**: Always verify payment status via payment gateway APIs
4. **Data Privacy**: Hide candidate contact info from public profiles
5. **Webhook Security**: Verify webhook signatures from payment gateways

---

## 📦 Next Steps

1. **Install Additional Packages** (if needed):
   ```bash
   # For WhatsApp notifications
   composer require twilio/sdk
   
   # For Zoom integration
   composer require macsidigital/laravel-zoom
   ```

2. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

3. **Seed Categories**:
   ```bash
   php artisan db:seed --class=CategorySeeder
   ```

4. **Configure Payment Gateways**:
   - Add Selcom credentials to `.env`
   - Add AzamPay credentials to `.env`
   - Configure webhook URLs in payment gateway dashboards

5. **Test Payment Flows**:
   - Test Selcom payments in sandbox mode
   - Test AzamPay payments in sandbox mode
   - Verify webhook callbacks

---

## 📊 Database Relationships Summary

```
User
├── hasOne: CandidateProfile
├── hasMany: Documents
├── hasMany: Appointments
├── hasMany: JobListings (as employer)
└── hasMany: JobApplications (as candidate)

Category
└── hasMany: JobListings

JobListing
├── belongsTo: Category
├── belongsTo: User (employer)
└── hasMany: JobApplications

JobApplication
├── belongsTo: JobListing
├── belongsTo: User (candidate)
├── belongsTo: User (reviewer)
└── belongsTo: Appointment

Appointment
├── belongsTo: User (candidate)
└── belongsTo: User (employer)
```

---

## 🎨 Design Requirements

- **Modern, corporate, trustworthy** aesthetic
- **Hero section** with smooth fade/cross-fade transitions
- **Clean layouts** for complex filters
- **Wizard-style** multi-step forms
- **Responsive** design for mobile/tablet/desktop

---

## 📞 Support & Documentation

- **Selcom Documentation**: https://github.com/bryceandy/laravel-selcom
- **AzamPay Documentation**: https://developerdocs.azampay.co.tz/redoc
- **Laravel Documentation**: https://laravel.com/docs
- **Project Proposal**: `COYZON website.pdf`

---

**Status**: ✅ Database & Models Complete | ✅ Controllers & Views Complete | ✅ Payment Gateways Integrated | ✅ Frontend Complete

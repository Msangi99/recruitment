# COYZON Recruitment Platform - Laravel Implementation Guide

## 📋 Project Overview
**COYZON** is a global recruitment gateway connecting skilled job seekers with trusted employers across multiple industries (Agriculture, Construction, Logistics, Hospitality, etc.).

---

## ✅ Completed Setup

### 1. **Payment Gateway - Selcom Integration**
- ✅ Installed `bryceandy/laravel-selcom` package
- ✅ Published Selcom configuration
- ✅ Supports: M-Pesa, Tigo Pesa, Airtel Money, Halopesa, and Card payments

### 2. **Database Structure**
All migrations created and executed successfully:

#### Tables Created:
1. **users** - Extended with role, phone, address, city, country, postcode, is_active
2. **categories** - Job categories (Agriculture, Construction, etc.)
3. **candidate_profiles** - Extended candidate information with verification
4. **documents** - Secure storage for IDs, Passports, CVs
5. **job_listings** - Job postings with full details
6. **appointments** - Booking system with payment tracking
7. **job_applications** - Application tracking
8. **selcom_payments** - Payment transaction records (from Selcom package)

### 3. **Models Created**
All models with relationships and helper methods:
- ✅ User (with role-based methods)
- ✅ Category
- ✅ CandidateProfile
- ✅ Document
- ✅ JobListing
- ✅ Appointment
- ✅ JobApplication

---

## 🔧 Environment Configuration Needed

Add these to your `.env` file:

```env
# Application
APP_NAME="COYZON Recruitment"
APP_URL=http://localhost

# Selcom Payment Gateway
SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_secret_key
SELCOM_IS_LIVE=false

# Optional Selcom Settings
SELCOM_REDIRECT_URL=http://localhost/selcom/redirect
SELCOM_CANCEL_URL=http://localhost/selcom/cancel
SELCOM_PREFIX=COYZON

# Selcom Theme Colors (Optional)
SELCOM_HEADER_COLOR="#1a73e8"
SELCOM_LINK_COLOR="#000000"
SELCOM_BUTTON_COLOR="#1a73e8"

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
   - Book consultations (with payment)

4. **Guest** - Limited access
   - Browse jobs
   - View basic candidate info

---

## 💳 Payment Flow (Selcom)

### Appointment Booking Payment
**Amount**: TZS 30,000 or $12

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

### Payment Webhook Handler
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

---

## 📝 Key Features to Implement

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

### 3. **Candidate Pool (Employer View)**
- Searchable database
- Profile cards with skills/experience
- Privacy: Hide contact info until employer requests

### 4. **Appointment Booking**
- Calendar integration
- Online (Zoom/Google Meet) or In-person
- Mandatory payment (TZS 30,000 or $12)
- Automated notifications (Email + WhatsApp)

### 5. **Admin Dashboard**
- Candidate verification workflow
- Document approval/rejection
- Job listing management
- Appointment oversight

---

## 🔐 Security Considerations

1. **Document Storage**: Store sensitive files outside public directory
2. **Role-Based Access**: Use middleware to protect routes
3. **Payment Verification**: Always verify payment status via Selcom API
4. **Data Privacy**: Hide candidate contact info from public profiles

---

## 📦 Next Steps

1. **Install Additional Packages**:
   ```bash
   # For WhatsApp notifications
   composer require twilio/sdk
   
   # For Zoom integration
   composer require macsidigital/laravel-zoom
   
   # For file uploads
   composer require spatie/laravel-medialibrary
   ```

2. **Create Seeders** for categories:
   ```bash
   php artisan make:seeder CategorySeeder
   ```

3. **Create Controllers**:
   - CandidateController
   - JobListingController
   - AppointmentController
   - AdminController

4. **Create Views** (Blade templates):
   - Homepage with hero section
   - Job search page
   - Candidate registration wizard
   - Employer dashboard
   - Admin panel

5. **Set up Routes** with role-based middleware

6. **Configure Notifications**:
   - Email templates
   - WhatsApp integration
   - SMS alerts

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
- **Laravel Documentation**: https://laravel.com/docs
- **Project Proposal**: `COYZON website.pdf`

---

**Status**: ✅ Database & Models Complete | 🔄 Controllers & Views Pending | 🔄 Frontend Pending

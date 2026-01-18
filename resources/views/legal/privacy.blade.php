<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - {{ config('app.name', 'COYZON') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="COYZON Logo" class="h-14 w-auto">
                        <span class="ml-3 text-xl font-bold text-gray-900">COYZON</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-900">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Privacy Policy</h1>

        <div class="bg-white rounded-lg shadow-md p-8 prose prose-lg max-w-none">
            <p class="text-sm text-gray-500 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <h2>1. Introduction</h2>
            <p>COYZON ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how
                we collect, use, disclose, and safeguard your information when you use our recruitment platform.</p>

            <h2>2. Information We Collect</h2>
            <h3>2.1 Personal Information</h3>
            <ul>
                <li>Name, email address, phone number</li>
                <li>Date of birth, citizenship, residency status</li>
                <li>Gender, marital status</li>
                <li>Educational qualifications and work experience</li>
                <li>Skills, languages, and professional certifications</li>
                <li>Resume/CV and supporting documents</li>
                <li>Profile pictures and application videos</li>
            </ul>

            <h3>2.2 Payment Information</h3>
            <p>Payment processing is handled by third-party payment gateways (Selcom, AzamPay). We do not store complete
                credit card information on our servers.</p>

            <h3>2.3 Usage Data</h3>
            <ul>
                <li>IP address, browser type, operating system</li>
                <li>Pages visited, time spent on pages</li>
                <li>Search queries and job applications</li>
                <li>Interaction with platform features</li>
            </ul>

            <h2>3. How We Use Your Information</h2>
            <p>We use collected information to:</p>
            <ul>
                <li>Create and manage user accounts</li>
                <li>Facilitate job matching between candidates and employers</li>
                <li>Process consultation bookings and payments</li>
                <li>Verify candidate profiles for employer visibility</li>
                <li>Send notifications about applications, interviews, and appointments</li>
                <li>Improve our services and user experience</li>
                <li>Comply with legal obligations</li>
            </ul>

            <h2>4. Information Sharing</h2>
            <h3>4.1 With Employers</h3>
            <p>Verified candidate profiles are visible to employers. However, contact details are hidden until an
                interview request is made and accepted.</p>

            <h3>4.2 With Service Providers</h3>
            <p>We share information with trusted third parties who assist in operating our platform:</p>
            <ul>
                <li>Payment processors (Selcom, AzamPay)</li>
                <li>Email service providers</li>
                <li>Cloud hosting services</li>
                <li>Analytics providers</li>
            </ul>

            <h3>4.3 Legal Requirements</h3>
            <p>We may disclose information when required by law, court order, or government request.</p>

            <h2>5. Data Security</h2>
            <p>We implement appropriate technical and organizational measures to protect your personal information:</p>
            <ul>
                <li>Encrypted data transmission (SSL/TLS)</li>
                <li>Secure password storage (hashing)</li>
                <li>Regular security audits</li>
                <li>Access controls and authentication</li>
                <li>Regular backups</li>
            </ul>

            <h2>6. Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li><strong>Access:</strong> Request a copy of your personal data</li>
                <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                <li><strong>Deletion:</strong> Request deletion of your account and data</li>
                <li><strong>Portability:</strong> Receive your data in a machine-readable format</li>
                <li><strong>Objection:</strong> Object to certain processing of your data</li>
                <li><strong>Withdrawal:</strong> Withdraw consent at any time</li>
            </ul>

            <h2>7. Profile Visibility Control</h2>
            <p>Candidates can control profile visibility through the <code>is_public</code> setting. Only verified and
                public profiles are visible to employers.</p>

            <h2>8. Data Retention</h2>
            <p>We retain your information for as long as your account is active or as needed to provide services. After
                account deletion, data may be retained for legal or backup purposes for up to 90 days.</p>

            <h2>9. Cookies and Tracking</h2>
            <p>We use cookies and similar technologies to:</p>
            <ul>
                <li>Maintain user sessions</li>
                <li>Remember preferences</li>
                <li>Analyze platform usage</li>
                <li>Improve user experience</li>
            </ul>

            <h2>10. Children's Privacy</h2>
            <p>Our platform is not intended for individuals under 18 years of age. We do not knowingly collect
                information from minors.</p>

            <h2>11. International Data Transfers</h2>
            <p>Your information may be transferred to and processed in countries other than Tanzania. We ensure
                appropriate safeguards are in place for such transfers.</p>

            <h2>12. Changes to Privacy Policy</h2>
            <p>We may update this Privacy Policy periodically. Changes will be posted on this page with an updated
                revision date.</p>

            <h2>13. Contact Us</h2>
            <p>For questions or concerns about this Privacy Policy or our data practices:</p>
            <ul>
                <li>Email: info@coyzon.com</li>
                <li>Phone: +255 625 933 171</li>
                <li>Address: Dar es Salaam, Tanzania</li>
            </ul>

            <div class="bg-gray-100 border-l-4 border-indigo-600 p-4 mt-8">
                <p class="text-sm text-gray-700">
                    <strong>Your Privacy Matters</strong><br>
                    COYZON is committed to transparency and maintaining the highest standards of data protection and
                    privacy compliance.
                </p>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - {{ config('app.name', 'COYZON') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <nav class="sticky top-0 z-50 bg-gray-900 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('logo-removed-background.png') }}" alt="COYZON Logo" class="h-16 w-auto">
                        <span class="ml-3 text-xl font-bold text-white">COYZON</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-white hover:text-blue-400 transition-colors">Home</a>
                    <a href="{{ route('contact') }}"
                        class="text-white hover:text-blue-400 transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Terms & Conditions</h1>

        <div class="bg-white rounded-lg shadow-md p-8 prose prose-lg max-w-none">
            <p class="text-sm text-gray-500 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <h2>1. Legal & Compliance</h2>
            <p>Welcome to COYZON. By accessing and using our recruitment platform, you agree to comply with and be bound
                by the following terms and conditions.</p>

            <h2>2. Acceptance of Terms</h2>
            <p>By registering for an account or using our services, you acknowledge that you have read, understood, and
                agree to be bound by these Terms & Conditions and our Privacy Policy.</p>

            <h2>3. User Accounts</h2>
            <h3>3.1 Registration</h3>
            <p>Users must provide accurate, current, and complete information during the registration process. You are
                responsible for maintaining the confidentiality of your account credentials.</p>

            <h3>3.2 Account Types</h3>
            <ul>
                <li><strong>Candidates:</strong> Job seekers looking for overseas employment opportunities</li>
                <li><strong>Employers:</strong> Companies seeking to recruit qualified candidates</li>
                <li><strong>Administrators:</strong> Platform administrators with oversight responsibilities</li>
            </ul>

            <h2>4. Services Provided</h2>
            <h3>4.1 For Candidates</h3>
            <ul>
                <li>Job search and application services</li>
                <li>Profile creation and management</li>
                <li>Career consultation services (paid)</li>
                <li>Document verification and management</li>
            </ul>

            <h3>4.2 For Employers</h3>
            <ul>
                <li>Job posting and management</li>
                <li>Candidate browsing and search</li>
                <li>Interview request services</li>
                <li>Free consultation services</li>
            </ul>

            <h2>5. Payment Terms</h2>
            <h3>5.1 Consultation Fees</h3>
            <p>Candidate consultation services are charged at TZS 30,000 or $12 per session. Payment must be completed
                before the consultation is confirmed.</p>

            <h3>5.2 Payment Methods</h3>
            <p>We accept payments through Selcom and AzamPay gateways, including mobile money, card payments, and bank
                transfers.</p>

            <h3>5.3 Refund Policy</h3>
            <p>Refunds may be granted in case of service cancellation by the platform. Requests must be made within 24
                hours of payment.</p>

            <h2>6. User Conduct</h2>
            <p>Users agree to:</p>
            <ul>
                <li>Provide truthful and accurate information</li>
                <li>Not misrepresent qualifications or experience</li>
                <li>Not engage in fraudulent activities</li>
                <li>Respect intellectual property rights</li>
                <li>Maintain professional conduct in all interactions</li>
            </ul>

            <h2>7. Privacy & Data Protection</h2>
            <p>We are committed to protecting your privacy. Please review our <a href="{{ route('privacy') }}"
                    class="text-indigo-600 hover:text-indigo-700">Privacy Policy</a> to understand how we collect, use,
                and protect your personal information.</p>

            <h2>8. Intellectual Property</h2>
            <p>All content on the COYZON platform, including text, graphics, logos, and software, is the property of
                COYZON and protected by copyright laws.</p>

            <h2>9. Limitation of Liability</h2>
            <p>COYZON shall not be liable for any indirect, incidental, special, or consequential damages arising out of
                or in connection with the use of our services.</p>

            <h2>10. Termination</h2>
            <p>We reserve the right to suspend or terminate accounts that violate these terms or engage in prohibited
                activities.</p>

            <h2>11. Governing Law</h2>
            <p>These terms shall be governed by and construed in accordance with the laws of Tanzania.</p>

            <h2>12. Contact Information</h2>
            <p>For questions about these Terms & Conditions, please contact us:</p>
            <ul>
                <li>Email: info@coyzon.com</li>
                <li>Phone: +255 625 933 171</li>
                <li>Address: Dar es Salaam, Tanzania</li>
            </ul>

            <div class="bg-gray-100 border-l-4 border-indigo-600 p-4 mt-8">
                <p class="text-sm text-gray-700">
                    <strong>© {{ date('Y') }} Coyzon. All Rights Reserved.</strong><br>
                    NOTE: This is a public professional trade site. We maintain the highest standards of professionalism
                    and compliance in all career & development services.
                </p>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>
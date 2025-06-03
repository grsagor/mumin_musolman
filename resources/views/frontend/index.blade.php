<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মুমিন মুসলমান - প্রিমিয়াম সেবাসমূহ</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <style>
        .service-card {
            border-radius: 15px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 80px 0;
        }

        .btn-premium {
            background: #E2136E;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-premium:hover {
            background: #c11061;
            color: white;
            transform: translateY(-2px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #E2136E;
            margin-bottom: 1rem;
        }

        .footer {
            background: #1e3c72;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #E2136E;
        }
    </style>
</head>

<body>
    <div class="hero-section mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="display-4 fw-bold">প্রিমিয়াম ইসলামিক কনটেন্ট</h1>
                    <p class="lead">আপনার আধ্যাত্মিক যাত্রা আরও সমৃদ্ধ করুন আমাদের প্রিমিয়াম সেবার মাধ্যমে</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Premium Videos Service -->
            <div class="col-md-4">
                <div class="service-card h-100 p-4 bg-white">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h2 class="h3 mb-4">প্রিমিয়াম ভিডিও</h2>
                        <div class="mb-4">
                            <h4 class="h5 mb-3">যা যা পাবেন:</h4>
                            <ul class="list-unstyled text-start">
                                <li>✓ প্রিমিয়াম ভিডিও</li>
                                <li>✓ প্রিমিয়াম আমল ভিডিও</li>
                            </ul>
                        </div>
                        <a href="/bkash?for=premium" class="btn btn-premium">
                            প্রিমিয়াম ভিডিও সাবস্ক্রাইব করুন
                        </a>
                    </div>
                </div>
            </div>

            <!-- Premium Chat Service -->
            <div class="col-md-4">
                <div class="service-card h-100 p-4 bg-white">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h2 class="h3 mb-4">প্রিমিয়াম চ্যাট</h2>
                        <div class="mb-4">
                            <h4 class="h5 mb-3">যা পাবেন:</h4>
                            <ul class="list-unstyled text-start">
                                <li>✓ সরাসরি হুজুরের সাথে কথা বলার সুযোগ।</li>
                            </ul>
                        </div>
                        <a href="/bkash?for=chat" class="btn btn-premium">
                            প্রিমিয়াম চ্যাট সাবস্ক্রাইব করুন
                        </a>
                    </div>
                </div>
            </div>

            <!-- Premium Chat Service -->
            <div class="col-md-4">
                <div class="service-card h-100 p-4 bg-white">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h2 class="h3 mb-4">ডোনেশন করুন</h2>
                        <div class="mb-4">
                            {{-- <h4 class="h5 mb-3">যা যা পাবেন:</h4> --}}
                            <ul class="list-unstyled text-start">
                                <li>✓ আপনি কি ডোনেট করতে চান?</li>
                            </ul>
                        </div>
                        <a href="#" class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#donationModal">
                            ডোনেশন করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    {{-- <div class="container mb-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2>আমাদের প্রিমিয়াম সেবা কেন বেছে নেবেন?</h2>
                <p class="text-muted">আমাদের প্রিমিয়াম ফিচারগুলোর মাধ্যমে সেরা ইসলামিক শিক্ষার অভিজ্ঞতা নিন</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <h4>উন্নত মানের কনটেন্ট</h4>
                    <p>নির্ভরযোগ্য সূত্র থেকে যাচাই করা ইসলামিক কনটেন্ট</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <h4>এক্সপার্ট সহযোগিতা</h4>
                    <p>জ্ঞানী স্কলার এবং শিক্ষকদের সরাসরি সহযোগিতা</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <h4>সহজ এক্সেস</h4>
                    <p>যেকোনো সময়, যেকোনো স্থান থেকে প্রিমিয়াম কনটেন্ট দেখুন</p>
                </div>
            </div>
        </div>
    </div> --}}

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">
                        যোগাযোগ করুন: 
                        <a href="mailto:muminmusolmanapps@gmail.com">
                            <i class="fas fa-envelope me-1"></i>muminmusolmanapps@gmail.com
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Donation Modal -->
    <div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donationModalLabel">ডোনেশন পরিমাণ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donationForm" action="/bkash" method="GET">
                        <input type="hidden" name="for" value="donation">
                        <div class="mb-3">
                            <label for="amount" class="form-label">টাকার পরিমাণ</label>
                            <input type="number" class="form-control" id="amount" name="amount" required
                                min="1">
                        </div>
                        <button type="submit" class="btn btn-premium">পেমেন্ট করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/backend/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>

    <script>
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const amount = document.getElementById('amount').value;
            window.location.href = `/bkash?for=donation&amount=${amount}`;
        });
    </script>
</body>

</html>

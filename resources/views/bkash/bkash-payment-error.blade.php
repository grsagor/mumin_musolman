<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট ব্যর্থ - মুমিন মুসলমান</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <style>
        .error-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
            display: flex;
            align-items: center;
        }
        .error-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            padding: 3rem;
            text-align: center;
        }
        .error-icon {
            width: 100px;
            height: 100px;
            background: #dc3545;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
        .error-icon i {
            color: white;
            font-size: 50px;
        }
        .error-message {
            background: #fff0f0;
            border: 2px solid #ffcdd2;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            color: #dc3545;
            font-size: 1.1rem;
        }
        .btn-home {
            background: #E2136E;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: #c11061;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="error-card">
                        <div class="error-icon">
                            <i class="fas fa-times"></i>
                        </div>
                        <h1 class="display-5 mb-4">পেমেন্ট ব্যর্থ হয়েছে</h1>
                        <div class="error-message">
                            {{ $message }}
                        </div>
                        <p class="text-muted mb-4">
                            দুঃখিত, আপনার পেমেন্ট প্রসেস করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন অথবা সহায়তার জন্য আমাদের সাথে যোগাযোগ করুন।
                        </p>
                        <div class="d-grid gap-2">
                            <a href="/" class="btn btn-home">
                                হোম পেজে ফিরে যান
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backend/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেমেন্ট সফল - মুমিন মুসলমান</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <style>
        .success-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
        }
        .success-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            padding: 3rem;
            text-align: center;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
        .success-icon i {
            color: white;
            font-size: 50px;
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
    <div class="success-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="success-card">
                        <div class="success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h1 class="display-5 mb-4">পেমেন্ট সফল হয়েছে!</h1>
                        <div class="alert alert-success mb-4">
                            আপনার পেমেন্ট সফলভাবে সম্পন্ন হয়েছে। সাবস্ক্রাইব করার জন্য ধন্যবাদ!
                        </div>
                        <p class="text-muted mb-4">
                            আপনি এখন আমাদের প্রিমিয়াম কন্টেন্ট অ্যাক্সেস করতে পারবেন। এখনই আপনার নতুন ফিচারগুলো এক্সপ্লোর করুন!
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
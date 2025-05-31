<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment - Mumin Musolman</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .payment-container {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .payment-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 2rem;
        }
        .payment-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .bkash-btn {
            background: #E2136E;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .bkash-btn:hover {
            background: #c11061;
            transform: translateY(-2px);
        }
        .bkash-logo {
            max-height: 40px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="payment-container py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="payment-card">
                        <h2 class="text-center mb-4">Complete Your Payment</h2>
                        
                        <div class="payment-summary">
                            <h4>Order Summary</h4>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="text-muted">Package</p>
                                    <p class="text-muted">Duration</p>
                                    <p class="text-muted">Amount</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="fw-bold">Premium Subscription</p>
                                    <p class="fw-bold">1 Month</p>
                                    <p class="fw-bold">৳500</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0">Total Amount</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="fw-bold mb-0">৳500</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-4">Please click the button below to proceed with your payment</p>
                            <button class="bkash-btn" id="bKash_button" onclick="BkashPayment()">
                                <img src="https://raw.githubusercontent.com/bKash-developer/bKash-for-woocommerce/master/assets/images/bkash-logo.png" 
                                     alt="bKash" class="bkash-logo">
                                Pay with bKash
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    @include('bkash.bkash-script')
</body>
</html>
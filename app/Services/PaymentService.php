<?php

namespace App\Services;

use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent($amount, $currency = 'USD')
    {
        return PaymentIntent::create([
            'amount' => $amount * 100, // Stripe usa centavos
            'currency' => $currency,
        ]);
    }

    public function processPayment($paymentData)
    {
        try {
            $payment = Payment::create([
                'user_id' => $paymentData['user_id'],
                'appointment_id' => $paymentData['appointment_id'],
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'payment_method' => $paymentData['payment_method'],
                'transaction_id' => $paymentData['transaction_id'],
                'status' => 'pending',
                'commission' => $this->calculateCommission($paymentData['amount']),
                'payment_details' => $paymentData['details'] ?? null,
            ]);

            // Procesar el pago con Stripe
            $paymentIntent = $this->createPaymentIntent(
                $paymentData['amount'],
                $paymentData['currency']
            );

            return [
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret
            ];
        } catch (\Exception $e) {
            \Log::error('Error processing payment: ' . $e->getMessage());
            throw $e;
        }
    }

    private function calculateCommission($amount)
    {
        // 10% de comisión
        return $amount * 0.10;
    }
} 
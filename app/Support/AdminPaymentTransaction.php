<?php

namespace App\Support;

use App\Models\Appointment;
use App\Models\ConsultationRequest;
use Carbon\Carbon;

class AdminPaymentTransaction
{
    public function __construct(
        public string $source,
        public int $id,
        public string $customer_name,
        public string $customer_email,
        public string $type_label,
        public float $amount,
        public string $currency,
        public string $payment_status,
        public string $raw_payment_status,
        public ?string $transaction_id,
        public ?string $order_id,
        public ?string $payment_gateway,
        public ?string $phone,
        public Carbon $created_at,
    ) {}

    public static function fromAppointment(Appointment $appointment): self
    {
        return new self(
            source: 'appointment',
            id: $appointment->id,
            customer_name: $appointment->user?->name ?? 'Unknown',
            customer_email: $appointment->user?->email ?? 'N/A',
            type_label: ucfirst(str_replace('_', ' ', $appointment->appointment_type)),
            amount: (float) $appointment->amount,
            currency: $appointment->currency ?? 'TZS',
            payment_status: self::normalizeAppointmentStatus($appointment->payment_status),
            raw_payment_status: $appointment->payment_status,
            transaction_id: $appointment->transaction_id,
            order_id: $appointment->order_id,
            payment_gateway: null,
            phone: $appointment->user?->phone,
            created_at: $appointment->created_at,
        );
    }

    public static function fromConsultationRequest(ConsultationRequest $request): self
    {
        $meta = is_array($request->meta_data) ? $request->meta_data : (json_decode($request->meta_data ?? '[]', true) ?? []);

        return new self(
            source: 'consultation',
            id: $request->id,
            customer_name: $request->name,
            customer_email: $request->email,
            type_label: self::consultationTypeLabel($request->type),
            amount: (float) $request->amount,
            currency: $request->currency ?? 'TZS',
            payment_status: self::normalizeConsultationStatus($request->payment_status),
            raw_payment_status: $request->payment_status ?? 'pending',
            transaction_id: $meta['transid'] ?? $request->transaction_reference,
            order_id: $meta['order_id'] ?? null,
            payment_gateway: $request->payment_gateway,
            phone: $request->phone,
            created_at: $request->created_at,
        );
    }

    public function showRoute(): string
    {
        return route('admin.payments.show', [
            'source' => $this->source,
            'id' => $this->id,
        ]);
    }

    public static function normalizeAppointmentStatus(?string $status): string
    {
        return match ($status) {
            'completed' => 'completed',
            'failed', 'refunded' => 'failed',
            default => 'pending',
        };
    }

    public static function normalizeConsultationStatus(?string $status): string
    {
        return match ($status) {
            'paid' => 'completed',
            'failed' => 'failed',
            default => 'pending',
        };
    }

    public static function appointmentStatusFilter(?string $filter): ?array
    {
        return match ($filter) {
            'completed' => ['completed'],
            'failed' => ['failed', 'refunded'],
            'pending' => ['pending'],
            default => null,
        };
    }

    public static function consultationStatusFilter(?string $filter): ?array
    {
        return match ($filter) {
            'completed' => ['paid'],
            'failed' => ['failed'],
            'pending' => ['pending', 'processing'],
            default => null,
        };
    }

    protected static function consultationTypeLabel(?string $type): string
    {
        return match ($type) {
            'job_seeker' => 'Career Consultation',
            'employer' => 'Employer Consultation',
            'partnership' => 'Partnership',
            default => ucfirst(str_replace('_', ' ', (string) $type)),
        };
    }
}

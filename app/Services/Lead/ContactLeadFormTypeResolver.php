<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Support\LeadFormType;

final class ContactLeadFormTypeResolver
{
    public function resolve(?string $subject): string
    {
        return match ($subject) {
            'Vehicle availability' => LeadFormType::VEHICLE_INQUIRY,
            'Delivery question' => LeadFormType::DELIVERY,
            'Warranty or return question' => LeadFormType::WARRANTY,
            'Finance question' => LeadFormType::FINANCE,
            'Trade-in question' => LeadFormType::TRADE_IN,
            default => LeadFormType::CONTACT,
        };
    }
}

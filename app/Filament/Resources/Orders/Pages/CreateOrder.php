<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Log;
use App\Models\Customer;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['address']) || $data['address'] == '') {
            $customer_id = $data['customer_id'];
            $customer = Customer::find($customer_id);
            if ($customer) {
                $data['address'] = $customer->address;
            }
        }

        return $data;
    }
}

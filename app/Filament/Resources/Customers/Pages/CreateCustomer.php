<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\Facades\Log;

class CreateCustomer extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = CustomerResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Customer created')
            ->body('The customer has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Detail')
                ->description('Fill customer data')
                ->schema([
                    Section::make('Detail')->schema([
                        CustomerForm::getNameFormField(),
                        CustomerForm::getEmailFormField(),
                    ]),
                ]),
            Step::make('Info')
                ->description('Fill customer info')
                ->schema([
                    Section::make('Info')->schema([
                        CustomerForm::getPhoneFormField(),
                        CustomerForm::getAddressFormField(),
                    ]),
                ]),
        ];
    }

    protected function afterCreate(): void
    {
        Log::info('Customer created', [
            'customer_id' => $this->record->id,
            'customer_name' => $this->record->name,
        ]);
    }

    // Can only if page not using Wizard
    // protected function getFormActions(): array
    // {
    //     return [
    //         ...parent::getFormActions(),
    //         Action::make('createAndClose')->action('createAndClose'),
    //     ];
    // }

    // protected function createAndClose(): void
    // {
    //     $this->create();
    //     $this->redirect($this->getResource()::getUrl('index'));
    // }
}

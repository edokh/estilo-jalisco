<?php

namespace App\Services;

use App\Models\Order;
use App\Models\RestaurantSetting;
use Vonage\Client;
use Vonage\Client\Credentials\Keypair;
use Vonage\Messages\Channel\WhatsApp\WhatsAppText;

class WhatsAppService
{
    protected ?string $privateKey;
    protected ?string $applicationId;
    protected ?string $fromNumber;
    protected ?string $restaurantNumber;
    protected string $apiUrl;
    protected string $restaurantTemplate;
    protected string $customerTemplate;
    protected bool $sendCustomer;

    public function __construct()
    {
        $this->privateKey = config('services.vonage.private_key');
        $this->applicationId = config('services.vonage.application_id');
        $this->fromNumber = config('services.whatsapp.from_number');
        $this->restaurantNumber = RestaurantSetting::get('whatsapp_restaurant_number', config('services.whatsapp.restaurant_number'));
        $this->apiUrl = config('services.vonage.api_url', 'https://messages-sandbox.nexmo.com/v1/messages');
        $this->restaurantTemplate = RestaurantSetting::get('whatsapp_restaurant_template', "New order received!!\nOrder: {{order_number}}\nName: {{customer_name}}\nPhone: {{customer_phone}}\nTotal: \${{final_price}}\nItems: {{items}}");
        $this->customerTemplate = RestaurantSetting::get('whatsapp_customer_template', "Thanks {{customer_name}}! Your order {{order_number}} has been received. Total: \${{final_price}}. We will contact you if there are any questions.");
        $this->sendCustomer = filter_var(config('services.whatsapp.send_customer', false), FILTER_VALIDATE_BOOLEAN);
    }

    public function isConfigured(): bool
    {
        return filled($this->privateKey)
            && filled($this->applicationId)
            && filled($this->fromNumber);
    }

    protected function createClient(): Client
    {
        $credential = new Keypair(
            file_get_contents(base_path($this->privateKey)),
            $this->applicationId
        );
        $client = new Client($credential);
        $client->messages()->getAPIResource()->setBaseUrl($this->apiUrl);
        return $client;
    }

    public function sendMessage(?string $recipientPhone, string $message): bool
    {
        if (! $this->isConfigured() || ! filled($recipientPhone)) {
            return false;
        }

        $recipient = ltrim($recipientPhone, '+');
        $from = ltrim($this->fromNumber, '+');

        try {
            $client = $this->createClient();
            $whatsApp = new WhatsAppText($recipient, $from, $message);
            $client->messages()->send($whatsApp);


            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }

    public function notifyOrderCreated(Order $order): void
    {
        $order->loadMissing('items.foodItem');

        $order->items->each(function ($item) {
            $item->description = "{$item->quantity}x {$item->foodItem->name}";
        });

        $restaurantMessage = $this->renderTemplate($order, $this->restaurantTemplate);
        $customerMessage = $this->renderTemplate($order, $this->customerTemplate);

        if (filled($this->restaurantNumber)) {
            $this->sendMessage($this->restaurantNumber, $restaurantMessage);
        }
        if ($this->sendCustomer && filled($order->customer_phone)) {
            $this->sendMessage($order->customer_phone, $customerMessage);
        }
    }

    protected function renderTemplate(Order $order, string $template): string
    {
        $items = $order->items
            ->map(fn($item) => $item->description)
            ->implode(', ');

        return str_replace([
            '{{order_number}}',
            '{{customer_name}}',
            '{{customer_phone}}',
            '{{final_price}}',
            '{{items}}',
        ], [
            $order->order_number,
            $order->customer_name,
            $order->customer_phone,
            number_format($order->final_price, 2),
            $items,
        ], $template);
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\BorrowedItem;
use App\Models\IncomingItem;
use App\Models\OutgoingItem;

class ItemSentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $item;
    public $type;

    public function __construct($item)
    {
        $this->item = $item;
        if ($item instanceof BorrowedItem) {
            $this->type = 'borrowed';
        } elseif ($item instanceof IncomingItem) {
            $this->type = 'incoming';
        } elseif ($item instanceof OutgoingItem) {
            $this->type = 'outgoing';
        } else {
            $this->type = 'unknown';
        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('A Borrowed Item Has Been Sent to Admin')
            ->line('A borrowed item has been sent to admin.')
            ->line('Borrower: ' . $this->item->borrower_name)
            ->line('Equipment: ' . $this->item->equipment_name)
            ->line('Product: ' . $this->item->product_name)
            ->action('View All Tables', url('/all-tables'));
    }

    public function toArray($notifiable)
    {
        $data = [
            'type' => $this->type,
            'id' => $this->item->id,
        ];
        if ($this->type === 'borrowed') {
            $data = array_merge($data, [
                'borrower_name' => $this->item->borrower_name,
                'equipment_name' => $this->item->equipment_name,
                'product_name' => $this->item->product_name,
            ]);
        } elseif ($this->type === 'incoming') {
            $data = array_merge($data, [
                'serial_number' => $this->item->serial_number,
                'model' => $this->item->model,
                'brand' => $this->item->brand,
                'item_description' => $this->item->item_description,
                'quantity' => $this->item->quantity,
            ]);
        } elseif ($this->type === 'outgoing') {
            $data = array_merge($data, [
                'client' => $this->item->client,
                'location' => $this->item->location,
                'purpose' => $this->item->purpose,
                'item_description' => $this->item->item_description,
                'quantity' => $this->item->quantity,
            ]);
        }
        return $data;
    }
}

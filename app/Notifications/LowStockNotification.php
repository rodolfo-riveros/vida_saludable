<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Crear una nueva instancia de notificación.
     *
     * @param  mixed  $product
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Obtener los canales de entrega de la notificación.
     *
     * @param  object  $notifiable
     * @return array<string>
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Obtener la representación de correo de la notificación.
     *
     * @param  object  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alerta de Stock Bajo')
            ->line("El producto {$this->product->name} ha alcanzado un stock bajo de {$this->product->stock} (mínimo: {$this->product->stock_minimo}).")
            ->action('Ver Producto', url('/admin/producto/' . $this->product->id))
            ->line('Por favor, considera reabastecer el inventario.');
    }

    /**
     * Obtener la representación en base de datos de la notificación.
     *
     * @param  object  $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'stock' => $this->product->stock,
            'stock_minimo' => $this->product->stock_minimo,
            'message' => "El producto {$this->product->name} ha alcanzado un stock bajo de {$this->product->stock} (mínimo: {$this->product->stock_minimo}).",
        ];
    }

    /**
     * Obtener la representación en array de la notificación.
     *
     * @param  object  $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}

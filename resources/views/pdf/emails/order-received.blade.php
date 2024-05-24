<x-mail::message>
  # You've just purchased our swag, order reference number is: {{ $order->reference_code }}!

  ## We've attached the invoice to this email.<br>

  <x-mail::button :url="route('orders.index')">
    View Dashboard
  </x-mail::button>

  Thanks,<br>
  {{ config('app.name') }}
</x-mail::message>

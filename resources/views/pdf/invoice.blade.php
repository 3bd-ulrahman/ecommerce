<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ $invoice->name }}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>{{ file_get_contents('assets/pdf.css') }}</style>
</head>
<body>
  {{-- Header --}}
  @if ($invoice->logo)
    <img src="{{ $invoice->getLogo() }}" alt="logo" height="100">
  @endif

  <div style="padding-top: 50px"></div>

  <table class="table mt-5">
    <tbody>
      <tr>
        <td class="border-0 pl-0" width="55%">
          <h4 class="text-uppercase">
            <strong>invoice</strong>
          </h4>
        </td>
        <td class="border-0 pl-0">
          @if ($invoice->status)
            <h4 class="text-uppercase cool-gray">
              <strong>{{ $invoice->status }}</strong>
            </h4>
          @endif
          <p>{{ __('invoices::invoice.serial') }} <strong>{{ $invoice->reference_code }}</strong></p>
          <p>{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->created_at }}</strong></p>
        </td>
      </tr>
    </tbody>
  </table>

  {{-- Seller - Buyer --}}
  <table class="table">
    <thead>
      <tr>
        <th class="border-0 pl-0 party-header" width="48.5%">
          {{ __('invoices::invoice.seller') }}
        </th>
        <th class="border-0" width="3%"></th>
        <th class="border-0 pl-0 party-header">
          {{ __('invoices::invoice.buyer') }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="px-0">
          <strong>{{ config('app.name') }}</strong>
        </td>
        <td class="border-0"></td>
        <td class="px-0">
          @if ($invoice->user->name)
            <p class="buyer-name">
              <strong>{{ __('invoices::invoice.name') }}:</strong> {{ $invoice->user->name }}
            </p>
          @endif

          @if ($invoice->user->email)
            <p class="buyer-code">
              <strong>{{ __('invoices::invoice.email') }}:</strong> {{ $invoice->user->email }}
            </p>
          @endif

          @if ($invoice->address)
            <p class="buyer-address">
              <strong>{{ __('invoices::invoice.address') }}:</strong> {{ $invoice->address }}
            </p>
          @endif
        </td>
      </tr>
    </tbody>
  </table>

  {{-- Table --}}
  <table class="table table-items">
    <thead>
      <tr>
        <th scope="col" class="border-0 pl-0">
          {{ __('invoices::invoice.description') }}
        </th>
        <th scope="col" class="text-center border-0">
          {{ __('invoices::invoice.quantity') }}
        </th>
        <th scope="col" class="text-right border-0">
          {{ __('invoices::invoice.price') }}
        </th>
        <th scope="col" class="text-right border-0 pr-0">
          {{ __('invoices::invoice.sub_total') }}
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($invoice->products as $item)
        <tr>
          <td class="pl-0">
            <strong>{{ $item->name }}</strong>
            {{-- <p class="cool-gray">{{ $item->description }}</p> --}}
          </td>
          <td class="text-center">{{ $item->pivot->quantity }}</td>
          <td class="text-right">
            {{ $item->pivot->price }}
          </td>

          {{-- @if ($invoice->hasItemTax)
            <td class="text-right">
              {{ $invoice->formatCurrency($item->tax) }}
            </td>
          @endif --}}

          <td class="text-right pr-0">
            {{ $invoice->sub_total }}
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
        <td class="text-right pr-0">
          {{ $invoice->tax }}%
        </td>
      </tr>
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
        <td class="text-right pr-0">
          Free
        </td>
      </tr>
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right pl-0">{{ __('invoices::invoice.total_amount') }}</td>
        <td class="text-right pr-0 total-amount">
          {{ $invoice->total }}
        </td>
      </tr>
    </tbody>
  </table>

  <p>
    {{ __('invoices::invoice.amount_in_words') }}: {{ getAmountInWords($invoice->total) }}
  </p>

  <p>
    {{ __('invoices::invoice.pay_until') }}: {{ $invoice->created_at->addDays(3)->format('Y-m-d') }}
  </p>
</body>
</html>

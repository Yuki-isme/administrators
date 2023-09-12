<div class="d-flex justify-content-between">
    <p class="mb-2">Total price:</p>
    <p class="mb-2">{{ number_format($total + $discount, 0, ',', '.') }} đ</p>
</div>
<div class="d-flex justify-content-between">
    <p class="mb-2">Discount:</p>
    <p class="mb-2 text-success">{{ number_format($discount, 0, ',', '.') }} đ</p>
</div>
{{-- <div class="d-flex justify-content-between">
    <p class="mb-2">TAX:</p>
    <p class="mb-2">{{ $tax ?? 0 }} đ</p>
</div>
<div class="d-flex justify-content-between">
    <p class="mb-2">Shipping Cost:</p>
    <p class="mb-2">{{ $ship ?? 0 }} ₫</p>
</div> --}}
<hr />
<div class="d-flex justify-content-between">
    <p class="mb-2">Total price:</p>
    <p class="mb-2 fw-bold text-danger">{{ number_format($total, 0, ',', '.') }} VND</p>
    {{-- + $ship + $tax - $discount --}}
</div>

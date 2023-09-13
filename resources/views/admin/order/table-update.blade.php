<table class="table">
    <thead>
        <tr>
            <th>Product name</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Amount</th>
            <th>Total</th>
            <th>Total discount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sumTotal = 0;
        @endphp
        @if (isset($products_selected))
            @foreach ($products_selected as $product)
                <tr>
                    <td class="productimgname">
                        <a href="{{ route('products.show', ['id' => $product->id]) }}"class="product-img"><img
                                src="{{ asset('storage/' . $product->thumbnail->url) }}"alt="product"></a>
                        <a href="{{ route('products.show', ['id' => $product->id]) }}">{{ $product->name }}</a>
                    </td>
                    <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->price - $product->cart_price, 0, ',', '.') }}</td>
                    <td>
                        @php
                            foreach ($product_ids as $id => $product_id) {
                                if ($product_id == $product->id) {
                                    $amount_selected = $amounts[$id];
                                }
                            }
                        @endphp
                        <select class="disabled-results form-control form-small product-amount" name="amounts[]"
                            data-product-id="{{ $product->id }}" data-price="{{ $product->price }}"
                            data-discount="{{ $product->price - $product->cart_price }}">
                            @for ($i = 1; $i <= $product->stock; $i++)
                                <option value="{{ $i }}"
                                    {{ isset($amount_selected) ? ($i == $amount_selected ? 'selected' : '') : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    <td class="total-price">
                        {{ number_format($product->price * ($amount_selected ?? 1), 0, ',', '.') }}
                    </td>
                    <td class="total-discount">
                        {{ number_format($product->price * ($amount_selected ?? 1) - $product->cart_price * ($amount_selected ?? 1), 0, ',', '.') }}
                    </td>
                    @php
                        $sumTotal += $product->cart_price * ($amount_selected ?? 1);
                    @endphp
                    <td class="last-total">
                        {{ number_format($product->cart_price * ($amount_selected ?? 1), 0, ',', '.') }}</td>
                    @php
                        $amount_selected = null;
                    @endphp
                    <td>
                        <a class="me-3"href="{{ route('products.show', ['id' => $product->id]) }}">
                            <img src="{{ asset('admin/assets/img/icons/eye.svg') }}"alt="img"></a>
                        <a href="#" class="delete-product" data-product-id="{{ $product->id }}"><img
                                src="{{ asset('admin/assets/img/icons/delete.svg') }}"alt="img"></a>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="6" style="font-weight: bold;">Sum</td>
            <td id="sum-total">{{ number_format($sumTotal, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tbody>
</table>

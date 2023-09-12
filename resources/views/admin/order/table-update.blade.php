<table class="table">
    <thead>
        <tr>
            <th>Product name</th>
            <th>Price</th>
            <th>Discount</th>
            @if (isset($order))
                <th>Price Order</th>
                <th>Discount Order</th>
            @endif
            <th>Amount</th>
            <th>Total</th>
            <th>Total discount</th>
            @if (isset($order))
                <th>Total Order</th>
                <th>Total Discount Order</th>
            @endif
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sumTotal = 0;
        @endphp
        @if ($order)
            @foreach ($order->items as $item)
                @if (in_array($item->product_id, $items_id))
                    <tr>
                        <td class="productimgname">
                            <a href="{{ route('products.show', ['id' => $item->product_id]) }}"class="product-img"><img
                                    src="{{ asset('storage/' . $item->product->thumbnail->url) }}"alt="product"></a>
                            <a
                                href="{{ route('products.show', ['id' => $item->product_id]) }}">{{ $item->product_name }}</a>
                        </td>
                        <td>{{ number_format($item->product->price, 0, ',', '.') }}
                        </td>
                        <td>{{ number_format($item->product->price - $item->product->cart_price, 0, ',', '.') }}
                        </td>
                        @if (isset($order))
                            <td>{{ number_format($item->price + $item->discount, 0, ',', '.') }}
                            </td>
                            <td>{{ number_format($item->discount, 0, ',', '.') }}</td>
                        @endif
                        <td>
                            @php
                                foreach ($product_ids as $id => $product_id) {
                                    if ($product_id == $item->product_id) {
                                        $amount_selected = $amounts[$id];
                                    }
                                }
                            @endphp
                            <select class="disabled-results form-control form-small product-amount" name="amounts[]"
                                data-product-id="{{ $item->product_id }}" data-price="{{ $item->product->price }}"
                                data-discount="{{ $item->product->price - $item->product->cart_price }}"
                                data-amount-order="{{ $item->amount }}" data-price-order="{{ $item->price }}"
                                data-discount-order="{{ $item->discount }}">
                                @if ($item->product->stock > 0)
                                    @for ($i = 1; $i <= $item->product->stock + $item->amount; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == ($amount_selected ?? $item->amount) ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                @else
                                    @for ($i = 1; $i <= $item->amount; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == ($amount_selected ?? $item->amount) ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                @endif
                            </select>
                        </td>
                        <td class="total-price">
                            {{ number_format($item->product->price * (isset($amount_selected) ? $amount_selected - $item->amount : 0), 0, ',', '.') }}
                        </td>
                        <td class="total-discount">
                            {{ number_format($item->product->price * (isset($amount_selected) ? $amount_selected - $item->amount : 0) - $item->product->cart_price * (isset($amount_selected) ? $amount_selected - $item->amount : 0), 0, ',', '.') }}
                        </td>
                        @if (isset($order))
                            <td class="total-price-order">
                                {{ number_format($item->price * $item->amount + $item->discount * $item->amount, 0, ',', '.') }}
                            </td>
                            <td class="total-discount-order">
                                {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                            </td>
                        @endif
                        @php
                            $sumTotal += $item->price * ($amount_selected ?? $item->amount);
                        @endphp
                        <td class="last-total">
                            {{ number_format($item->price * ($amount_selected ?? $item->amount), 0, ',', '.') }}
                        </td>
                        @php
                            $amount_selected = null;
                        @endphp
                        <td>
                            <a class="me-3"href="{{ route('products.show', ['id' => $item->product_id]) }}">
                                <img src="{{ asset('admin/assets/img/icons/eye.svg') }}"alt="img"></a>
                            <a href="#" class="delete-product" data-product-id="{{ $item->product_id }}"><img
                                    src="{{ asset('admin/assets/img/icons/delete.svg') }}"alt="img"></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
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
                    @if (isset($order))
                        <td>0
                        </td>
                        <td>0
                    @endif
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
                            data-discount="{{ $product->price - $product->cart_price }}" data-amount-order="0"
                            data-price-order="0" data-discount-order="0">
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
                    @if (isset($order))
                        <td class="total-price-order">
                            0
                        </td>
                        <td class="total-discount-order">
                            0
                        </td>
                    @endif
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
            <td colspan="{{ $order ? 10 : 6 }}" style="font-weight: bold;">Sum</td>
            <td id="sum-total">{{ number_format($sumTotal, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tbody>
</table>

@if (cart()->getContent() && count(cart()->getContent()) > 0)
    @foreach (cart()->getContent() as $id => $item)
        <div class="row gy-3 mb-4">
            <div class="col-lg-5">
                <div class="me-lg-5">
                    <div class="d-flex">
                        <img src="{{ asset('storage/' . $item['img']) }}" class="border rounded me-3"
                            style="width: 96px; height: 96px" />
                            <div class="">
                                <span class="nav-link"
                                    style="color: #4f4f4f">{{ $item['name'] }}</span>
                                <p class="text-muted">
                                    @if ($item['stock'] > 0)
                                        Còn hàng
                                    @else
                                        Hết hàng
                                    @endif
                                </p>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                <div class="">
                    <select style="width: 100px" class="form-select me-4 update-amount-select"
                        data-product-id="{{ $id }}" value={{ $item['amount'] }}>
                        @for ($i = 1; $i <= $item['stock']; $i++)
                            <option {{ $i == $item['amount'] ? 'Selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="">
                    <span class="h6">{{ number_format($item['price'] * $item['amount'], 0, ',', '.') }}
                        VND</span>
                    <br />
                    <small class="text-muted text-nowrap">
                        {{ number_format($item['price'], 0, ',', '.') }} VND / per item
                    </small>
                </div>
            </div>
            <div
                class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                <div class="float-md-end">
                    <a href="" class="btn btn-light border px-2 icon-hover-primary wishlistButton"
                        data-product-id="{{ $id }}"
                        data-current-action="{{ $wishlists ? (in_array($id, $wishlists) ? 'remove' : 'add') : 'add' }}"><i
                            class="fas fa-heart fa-lg px-1 {{ $wishlists ? (in_array($id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}"></i></a>
                    <a href="{{ route('deleteItem', ['id' => $id]) }}"
                        class="btn btn-light border text-danger icon-hover-danger deleteItem">Remove</a>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div style="color:black">
    <h1 style="color:black">Order Success</h1>
    <p style="color:black">Code order: {{ str_pad($order->id, 10, '0', STR_PAD_LEFT)}}</p>
    <p style="color:black">Name: {{ $order->name}}</p>
    <p style="color:black">Phone: {{ $order->phone_number}}</p>
    <p style="color:black">Payment method: {{ $order->payment_method}}</p>
    <p style="color:black">Address: {{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name}}</p>
    <p style="color:black">Note: {{ $order->note}}</p>
    <p style="color:black">Status: {{ $order->status}}</p>
    <h3 style="color:black">All Products</h3>
    <div style="color:black">
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th style="width: 150px; text-align: left;">Name Product</th>
                <th style="width: 150px; text-align: left;">Price / item</th>
                <th style="width: 150px; text-align: left;">Amout item</th>
                <th style="width: 150px; text-align: left;">Total price item</th>
            </tr>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align: right;">{{ $item->price }}</td>
                    <td style="text-align: right;">{{ $item->amount }}</td>
                    <td style="text-align: right;">{{ $item->price * $item->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;">Total: </td>
                <td style="text-align: right;">{{ $order->total }}</td>
            </tr>
        </table>
    </div>
</div>

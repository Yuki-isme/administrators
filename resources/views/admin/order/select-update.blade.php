@php
    $statusDisabledMap = [
        1 => [3, 4, 5, 6],
        2 => [1, 4, 5, 6],
        3 => [1, 2, 5, 6, 7, 8],
        4 => [1, 2, 3, 6, 7, 8],
        5 => [1, 2, 3, 4, 7, 8],
        6 => [1, 2, 3, 4, 5, 7, 8],
        7 => [1, 2, 3, 4, 5, 6],
        8 => [1, 2, 3, 4, 5, 6, 7, 8],
    ];
@endphp
@foreach ($statuses as $status)
    @php
        // Kiểm tra xem status_id hiện tại có nằm trong danh sách cần disable không
        $isDisabled = in_array($status->id, $statusDisabledMap[$status_id]);

        // Kiểm tra xem status_id hiện tại có phải là status_id của đơn hàng không
        $isSelected = $status->id == $status_id;
    @endphp

    <option value="{{ $status->id }}" {{ $isSelected ? 'selected' : '' }} {{ $isDisabled ? 'disabled' : '' }}>
        {{ $status->name }}
    </option>
@endforeach

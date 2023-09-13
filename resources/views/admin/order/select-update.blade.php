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

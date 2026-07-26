<div class="reservation-actions">
    @if($reservation->status === 'pending')
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="confirmed"><button class="btn btn-sm btn-success quick-action" type="submit">Accept</button></form>
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="btn btn-sm btn-danger quick-action" type="submit">Cancel</button></form>
    @endif
    <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')<select name="status" class="form-select form-select-sm"><option value="pending" @selected($reservation->status === 'pending')>Pending</option><option value="confirmed" @selected($reservation->status === 'confirmed')>Accepted</option><option value="completed" @selected($reservation->status === 'completed')>Completed</option><option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option></select><button class="btn btn-sm luxury-btn" type="submit">Save</button></form>
</div>

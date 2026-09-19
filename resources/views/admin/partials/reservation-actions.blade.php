<div class="reservation-actions">
    @if($reservation->status === 'pending')
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="confirmed"><button class="btn btn-sm btn-success quick-action" type="submit">Accept</button></form>
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="btn btn-sm btn-danger quick-action" type="submit">Cancel</button></form>
    @endif
    <div class="reservation-action-group">
        <span class="reservation-action-label">Status</span>
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')
            <select name="status" class="form-select form-select-sm">
                <option value="pending" @selected($reservation->status === 'pending')>Pending</option>
                <option value="confirmed" @selected($reservation->status === 'confirmed')>Accepted</option>
                <option value="completed" @selected($reservation->status === 'completed')>Completed</option>
                <option value="cancelled" @selected($reservation->status === 'cancelled')>Cancelled</option>
            </select>
            <button class="btn btn-sm luxury-btn" type="submit">Save</button>
        </form>
    </div>
    <div class="reservation-action-group">
        <span class="reservation-action-label">Payment</span>
        <form method="POST" action="{{ route('admin.reservations.status', $reservation) }}">@csrf @method('PATCH')
            <input type="hidden" name="status" value="{{ $reservation->status }}">
            <select name="payment_type" class="form-select form-select-sm">
                <option value="Unpaid" @selected(($reservation->payment_type ?? $reservation->payment_status) === 'Unpaid')>Unpaid</option>
                <option value="Downpayment" @selected(($reservation->payment_type ?? $reservation->payment_status) === 'Downpayment')>Downpayment</option>
                <option value="Full Payment" @selected(($reservation->payment_type ?? $reservation->payment_status) === 'Full Payment')>Full Payment</option>
            </select>
            <input type="number" name="amount_paid" min="0" step="1" value="{{ old('amount_paid', (int) ($reservation->amount_paid ?? 0)) }}" class="form-control form-control-sm" placeholder="Amount">
            <button class="btn btn-sm luxury-btn" type="submit">Save</button>
        </form>
    </div>
</div>

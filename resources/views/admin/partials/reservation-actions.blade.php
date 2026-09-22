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
            <label class="payment-field-label">Total</label>
            <input type="number" name="estimated_budget" min="0" step="1" value="{{ old('estimated_budget', (int) ($reservation->estimated_budget ?? 0)) }}" class="form-control form-control-sm" placeholder="0">
            <label class="payment-field-label">Down payment</label>
            <input type="number" name="amount_paid" min="0" step="1" value="{{ old('amount_paid', (int) ($reservation->amount_paid ?? 0)) }}" class="form-control form-control-sm" placeholder="0">
            <div class="payment-actions-inline">
                <button class="btn btn-sm luxury-btn" type="submit">Save</button>
                <button class="btn btn-sm btn-success" type="submit" name="mark_fully_paid" value="1">Fully paid</button>
            </div>
        </form>
    </div>
</div>

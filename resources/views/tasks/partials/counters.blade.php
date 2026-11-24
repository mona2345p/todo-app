<section class="counters" aria-label="Task counters">
    <article class="counter-card counter-total">
        <span class="counter-label">Total tasks</span>
        <strong class="counter-value" data-counter="total">{{ $total }}</strong>
    </article>
    <article class="counter-card counter-pending">
        <span class="counter-label">Pending</span>
        <strong class="counter-value" data-counter="pending">{{ $pending }}</strong>
    </article>
    <article class="counter-card counter-completed">
        <span class="counter-label">Completed</span>
        <strong class="counter-value" data-counter="completed">{{ $completed }}</strong>
    </article>
</section>

<div id="investment-list">
<div class="title">
    Mis Contribuciones
</div>
<div class="info items">
    @foreach ($investments as $investment)
        @include('front.panel.investment')
    @endforeach
    @if($investments->isEmpty())
        <div class="item">No posees contribuciones activas.</div>
    @endif
</div>
</div>
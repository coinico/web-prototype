<div id="voting-list">
<div class="title">
    Mis votos
</div>
<div class="info items">
    @foreach ($votes as $vote)
        @include('front.panel.vote')
    @endforeach
    @if($votes->isEmpty())
        <div class="item">No has participado en ninguna votación.</div>
    @endif
</div>
</div>
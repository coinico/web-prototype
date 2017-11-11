@extends('front.layout')

@section('main')

   <section id="welcome">
       <div class="row">
           <h1>Hola {{$user->name}}! Cómo estás? Bienvenido a la plataforma CasaToken (version DEMO).</h1>
           <div class="message">
               Déjanos contarte algunas novedades:
               Hemos depositado 100 ETH y 10000 CTF virtuales en tu billetera (puedes encontrarla en el panel de usuarios).
               Hemos creado una propiedad a tu nombre, la misma será sometida a votación entre los miembros de la plataforma. De ser aprobada, podrás verla en el panel de inversión.
               Te cuento que también podrás interactuar con tus crypto-monedas virtuales en nuestro exchange o invirtiendo en alguna de las propiedades disponibles en la página de inversiones.
               Algunos detalles:
               <ul>
                <li>Sólo por esta vez, si votas positivamente sobre una propiedad, automáticamente pasará al panel de inversión, caso contrario, de ser tu voto negativo, la propiedad se desestimará.</li>
                <li>Sólo por esta vez, si inviertes 100 ETH en tu propiedad, se tokenizará. Si inviertes menos, podrás observar en el gráfico el porcentaje faltante para hacer efectiva la tokenización.</li>
                <li>Podrás ver tu propiedad en el exchange si el proceso de tokenización se logra con éxito.</li>
                <li>Nuestra base de datos se reinicia todos los días, no te asustes si tu cuenta desaparece mañana!</li>
               </ul>
           </div>
       </div>
   </section>

@endsection

@section('scripts')

@stop
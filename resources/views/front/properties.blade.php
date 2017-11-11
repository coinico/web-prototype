@extends('front.layout')

@section('main')

   <section id="properties">
       <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:35%; text-align: center">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div id="modaldata" class="modal-body" style="text-align: center">
                   </div>
               </div>
           </div>
       </div>

       <div class="row">
            <div class="info-results">
                <div class="results">
                    @lang('Mostrando ') {{count($properties)}} @lang('resultados')
                </div>
                <div class="actions">
                    <a href="#" id="horizontal-view-btn">
                        <i class="fa fa-list" aria-hidden="true"></i>
                    </a>
                    <a href="#" id="normal-view-btn">
                        <i class="fa fa-th" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
           @foreach ($properties as $property)
               @include('front.properties.detail')
           @endforeach

        </div>
   </section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/plugins/modal.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/pages/properties.js') }}" ></script>
@stop
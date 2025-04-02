@extends('layouts.app')

@section('title', $utakmica->domacin->naziv . ' - ' . $utakmica->gost->naziv)

@section('content')
@include('partials.utakmice.header')
@include('partials.utakmice.sastavi')
@include('partials.utakmice.selektori')
@include('partials.utakmice.golovi')
@include('partials.utakmice.izmene')
@include('partials.utakmice.kartoni')

@if(Auth::check() && Auth::user()->hasEditAccess())
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicijalizacija Sortable za domaći tim
        const domaciSastavEl = document.getElementById('domaci-sastav-lista');
        if (domaciSastavEl) {
            const domaciSortable = new Sortable(domaciSastavEl, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    // Direktno pozovemo updateSortOrder nakon što se završi prevlačenje
                    updateSortOrder('domaci');
                }
            });
        }
        
        // Inicijalizacija Sortable za gostujući tim
        const gostujuciSastavEl = document.getElementById('gostujuci-sastav-lista');
        if (gostujuciSastavEl) {
            const gostujuciSortable = new Sortable(gostujuciSastavEl, {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    // Direktno pozovemo updateSortOrder nakon što se završi prevlačenje
                    updateSortOrder('gostujuci');
                }
            });
        }
        
        function updateSortOrder(timTip) {
            const listId = timTip + '-sastav-lista';
            const items = Array.from(document.querySelectorAll(`#${listId} .sortable-item`));
            
            // Jasno definisana konverzija u niz objekata sa novim redosledom
            const sastavi = items.map((item, index) => {
                return {
                    id: item.dataset.id,
                    redosled: index
                };
            });
            
            console.log('Ažuriranje redosleda', {
                timTip,
                sastavi: sastavi
            });
            
            // Indikator za operaciju u toku
            const indicator = document.createElement('div');
            indicator.className = 'alert alert-info position-fixed top-0 start-50 translate-middle-x mt-2';
            indicator.style.zIndex = '9999';
            indicator.innerHTML = 'Ažuriranje redosleda...';
            document.body.appendChild(indicator);
            
            // Priprema podataka za slanje
            const jsonData = {
                sastavi: sastavi,
                utakmica_id: {{ $utakmica->id }},
                tim_tip: timTip
            };
            
            // Slanje AJAX zahteva za ažuriranje redosleda
            fetch('{{ route("sastavi.updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Mrežna greška');
                }
                return response.json();
            })
            .then(data => {
                console.log('Odgovor sa servera:', data);
                
                if (data.success) {
                    indicator.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-2';
                    indicator.innerHTML = 'Redosled uspešno ažuriran';
                } else {
                    throw new Error(data.message || 'Nepoznata greška');
                }
                
                setTimeout(() => {
                    indicator.remove();
                }, 2000);
            })
            .catch(error => {
                console.error('Greška pri ažuriranju redosleda:', error);
                indicator.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-2';
                indicator.innerHTML = `Greška: ${error.message || 'Mrežna greška'}`;
                
                setTimeout(() => {
                    indicator.remove();
                }, 3000);
            });
        }
    });
</script>
@endsection
@endif
@endsection
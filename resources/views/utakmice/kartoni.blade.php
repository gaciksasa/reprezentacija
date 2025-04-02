<!-- Kartoni -->
<div class="card mb-4">
   <div class="card-header text-center">
       <h2 class="card-title mb-0">Kartoni</h2>
       @if(Auth::check() && Auth::user()->hasEditAccess())
       <div class="btn-group">
           @php
               // Proveri da li je domaćin naš tim
               $glavniTim = \App\Models\Tim::glavniTim()->first();
               $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
               $domacinJeNasTim = in_array($utakmica->domacin_id, $glavniTimIds);
               $gostJeNasTim = in_array($utakmica->gost_id, $glavniTimIds);
           @endphp
           
           
            @if($domacinJeNasTim)
                <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Domaćin
                </a>
            @else
                <a href="{{ route('protivnicki-kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Domaćin
                </a>
            @endif
            
            @if($gostJeNasTim)
                <a href="{{ route('kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Gost
                </a>
            @else
                <a href="{{ route('protivnicki-kartoni.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Gost
                </a>
            @endif  
       </div>
       @endif
   </div>
   <div class="card-body">
       @php
           // Grupiši kartone po timu
           $domaciKartoni = $utakmica->kartoni->where('tim_id', $utakmica->domacin_id)->sortBy('minut');
           $gostujuciKartoni = $utakmica->kartoni->where('tim_id', $utakmica->gost_id)->sortBy('minut');
           
           // Grupiši protivničke kartone po timu
           $domaciProtivnickiKartoni = $utakmica->protivnickiKartoni->where('tim_id', $utakmica->domacin_id)->sortBy('minut');
           $gostujuciProtivnickiKartoni = $utakmica->protivnickiKartoni->where('tim_id', $utakmica->gost_id)->sortBy('minut');
       @endphp
       
       @if($utakmica->kartoni->count() > 0 || $utakmica->protivnickiKartoni->count() > 0)
           <div class="row">
               <div class="col-md-6">
                   <h3 class="mb-3">{{ $utakmica->domacin->naziv }}</h3>
                   <ul class="list-group">
                       <!-- Regulatni kartoni -->
                       @foreach($domaciKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               
                               @if($domacinJeNasTim)
                                   <a href="{{ route('igraci.show', $karton->igrac) }}" class="text-decoration-none">
                                       <span class="text-danger fw-bold">{{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}</span>
                                   </a>
                               @else
                                   {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                               @endif
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       <!-- Protivnički kartoni -->
                       @foreach($domaciProtivnickiKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('protivnicki-kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       @if($domaciKartoni->count() == 0 && $domaciProtivnickiKartoni->count() == 0)
                           <li class="list-group-item text-center text-muted">Nema evidentiranih kartona.</li>
                       @endif
                   </ul>
               </div>
               <div class="col-md-6">
                   <h3 class="mb-3">{{ $utakmica->gost->naziv }}</h3>
                   <ul class="list-group">
                       <!-- Regulatni kartoni -->
                       @foreach($gostujuciKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               
                               @if($gostJeNasTim)
                                   <a href="{{ route('igraci.show', $karton->igrac) }}" class="text-decoration-none">
                                       <span class="text-danger fw-bold">{{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}</span>
                                   </a>
                               @else
                                   {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                               @endif
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       <!-- Protivnički kartoni -->
                       @foreach($gostujuciProtivnickiKartoni as $karton)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div>
                               <span class="text-muted">{{ $karton->minut }}' </span>
                               @if($karton->tip == 'zuti')
                                   <i class="fas fa-square text-warning"></i>
                               @elseif($karton->tip == 'crveni' && $karton->drugi_zuti)
                                   <i class="fas fa-square text-warning"></i><i class="fas fa-square text-danger ms-1"></i>
                               @else
                                   <i class="fas fa-square text-danger"></i>
                               @endif
                               {{ $karton->igrac->prezime }} {{ $karton->igrac->ime }}
                           </div>
                           @if(Auth::check() && Auth::user()->hasEditAccess())
                           <form action="{{ route('protivnicki-kartoni.destroy', $karton->id) }}" method="POST" class="d-inline">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                   <i class="fas fa-times"></i>
                               </button>
                           </form>
                           @endif
                       </li>
                       @endforeach
                       
                       @if($gostujuciKartoni->count() == 0 && $gostujuciProtivnickiKartoni->count() == 0)
                           <li class="list-group-item text-center text-muted">Nema evidentiranih kartona.</li>
                       @endif
                   </ul>
               </div>
           </div>
       @else
           <p class="text-center text-muted">Nema evidentiranih kartona za ovu utakmicu.</p>
       @endif
   </div>
</div>
@endsection
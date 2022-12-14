@extends('template.template')
@section('content')
    <section class="menu" id="menu">
        <div class="container" data-aos="fade-up">
            <div class="p-3 p-md-4">
                {{-- PESAN --}}
                @if (session('pesan'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="bi bi-check2-all"></i>&nbsp;{{ session('pesan') }}.</strong>
                    </div>
                @endif
            </div>
            <div class="section-header p-3 p-md-4">
                <h2>Our Menu</h2>
            </div>
            @if (auth()->user()->level == 1)
                <a href="{{ route('menu.create') }}" class="btn btn-danger btn-sm">Tambah Menu</a>
            @endif
            <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <li class="nav-item">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-starters">
                        <h4>Makanan</h4>
                    </a>
                </li><!-- End tab nav item -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-breakfast">
                        <h4>Minuman</h4>
                    </a><!-- End tab nav item -->
            </ul>
            <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
                <div class="tab-pane fade active show" id="menu-starters">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Makanan</h3>
                    </div>

                    <div class="row gy-5">

                        @foreach ($menu as $item)

                            <div class="col-lg-4 menu-item">
                                <a href="{{ url('picture/' . $item->gambar) }}" class="glightbox">
                                    <img src="{{ url('picture/' . $item->gambar) }}" class="card-img-fluid"
                                        alt="" width="250" height="350">
                                </a><div>&nbsp;</div>
                                <form action="{{ route('menu.destroy', $item->id_menu) }}" method="post">
                                    @if (auth()->user()->level == 1)
                                        <a href="{{ route('menu.edit', $item->id_menu) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil-square"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                    @elseif (auth()->user()->level == 2)
                                        <button type="button" class="btn btn-success" onClick="bukamodal('{{$item->id_menu}}', '{{ $item->nama_makanan }}')">
                                            Tambah Pesanan
                                        </button>
                                    @endif
                                </form><div>&nbsp;</div>
                                <h4>{{ $item->nama_makanan }}</h4>
                                <center>
                                    <p class="ingredients" style="width: 250px">
                                        {{ $item->keterangan }}
                                    </p>
                                </center>
                                <p class="price">
                                    Rp.{{ $item->harga }}
                                </p>
                            </div><!-- Menu Item -->
                        @endforeach
                    </div>
                </div><!-- End Starter Menu Content -->

                <div class="tab-pane fade" id="menu-breakfast">

                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3>Minuman</h3>
                    </div>

                    <div class="row gy-5">

                        @foreach ($menuMinuman as $item)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ url('picture/' . $item->gambar) }}" class="glightbox">
                                    <img src="{{ url('picture/' . $item->gambar) }}" class="card-img-fluid"
                                        alt="" width="250" height="350">
                                </a><div>&nbsp;</div>
                                <form action="{{ route('menu.destroy', $item->id_menu) }}" method="post">
                                    @if (auth()->user()->level == 1)
                                        <a href="{{ route('menu.edit', $item->id_menu) }}" class="btn btn-warning"><i
                                                class="bi bi-pencil-square"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="bi bi-trash-fill"></i></button>
                                    @elseif (auth()->user()->level == 2)
                                        <button type="button" class="btn btn-success" onClick="bukamodal('{{$item->id_menu}}', '{{ $item->nama_makanan }}')">
                                            Tambah Pesanan
                                        </button>
                                        {{-- <a href="{{ route('add.to.cart', $item->id_menu) }}" class="btn btn-success"><i
                                                class="bi bi-plus-circle-fill"></i>&nbsp;Tambah pesanan</a> --}}
                                    @endif
                                </form><div>&nbsp;</div>
                                <h4>{{ $item->nama_makanan }}</h4>
                                <center>
                                    <p class="ingredients" style="width: 250px">
                                        {{ $item->keterangan }}
                                    </p>
                                </center>
                                <p class="price">
                                    Rp.{{ $item->harga }}
                                </p>
                            </div><!-- Menu Item -->
                        @endforeach

                    </div>
                </div><!-- End Starter Menu Content -->

            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Masukkan Jumlah Pesanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modal-menu" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <div class="modal-footer">
                            {{-- <button type="button" class="decrease-btn" style="width: 30px" height="30px">-</button>
                                <input type="text" class="quantity" style="width: 40px" height="40px"  value="1">
                            <button type="button" class="increase-btn" style="width: 30px" height="30px">+</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                            <input type=button value='-' onclick='javascript:process(-1)'>
                            <input type=test size=1 id='v' name='v' value='&nbsp; 1'>
                            <input type=hidden id='modal_id_menu' name='modal_id_menu'>
                            <input type=button value='+' onclick='javascript:process(1)'>
                            <a id="id_menu_herf" type="button" class="btn btn-success">
                                Tambah
                            </a>
                        </div>
                        {{-- <a href="{{ route('add.to.cart', $item->id_menu) }}" class="btn btn-success"><i
                            class="bi bi-plus-circle-fill"></i>&nbsp;Tambah pesanan</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script language=javascript>
    // $("#qty").click(function() {
    //     alert ("ok");
    // });
    function bukamodal(id, nama_makanan){
        $("#exampleModal").modal('show');
        $("#modal_id_menu").val(id);
        $("#id_menu_herf").attr("href","/add-to-cart/" + id);
        $("#modal-menu").html(nama_makanan);
    }
    function process(v){
        var value = parseInt(document.getElementById('v').value);
        value+=v;
        document.getElementById('v').value = value;
    }
</script>

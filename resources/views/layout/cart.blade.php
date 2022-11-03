@extends('template.template')
@section('content')
    <section id="contact" class="contact">
        <div class="container " data-aos="fade-up">
            <div class="p-3 p-md-4">
                {{-- PESAN --}}
                @if (session('pesan'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="bi bi-check2-all"></i>&nbsp;{{ session('pesan') }}.</strong>
                    </div>
                @endif
            </div>
            <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
                <div class="tab-pane fade active show" id="menu-starters">
                    <div class="tab-header text-center">
                        <h3><strong>Keranjang Pesanan</strong></h3>
                        <br><br>
                    </div>
                </div>
            </div>
            <table class="table table-hover" id="cart">
                <thead>
                    <th scope="col">Nama Pesanan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Hapus</th>
                </thead>
                <tbody>
                    @php $total = 0 @endphp
                    @if (session('cart'))
                        @foreach (session('cart') as $id_menu => $details)
                            @php $total += $details['harga'] * $details['quantity'] @endphp
                            <tr data-id="{{ $id_menu }}">
                                <td>
                                    {{ $details['nama_makanan'] }}
                                </td>
                                <td>Rp.{{ $details['harga'] }}</td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $details['quantity'] }}"
                                        class="form-control quantity update-cart" />
                                </td>
                                <td class="text-center">Rp.{{ $details['harga'] * $details['quantity'] }}</td>
                                <td class="actions">
                                    <button class="btn btn-danger btn-sm remove-from-cart"><i
                                            class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">
                            <h3><strong>Total Rp.{{ $total }}</strong></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <a href="{{ route('menu.index') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>
                                Kembali kemenu</a>
                            @if (session('cart') >= 1)
                                <a href="{{ route('transaksi') }}" class="btn btn-success">Checkout</a>
                            @else
                            @endif
                            {{-- <a href="{{ route('deleteCart') }}">delete</a> --}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    <script type="text/javascript">
        $(".update-cart").change(function(e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_menu: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_menu: ele.parents("tr").attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection

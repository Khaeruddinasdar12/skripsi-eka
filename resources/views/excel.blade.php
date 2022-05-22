<table>
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Kode Transaksi</th>
                          <th>Nama Penerima</th>
                          <th>No. Hp</th>
                          <th>Total Harga</th>
                          <th>Jenis Pembayaran</th>
                          <th>Akun</th>
                        </tr>
                      </thead>

                      <tbody>
                        @php $no = 1; @endphp
                        @foreach($data as $datas)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$datas->transaksi_code}}</td>
                          <td>{{$datas->penerima}}</td>
                          <td>{{$datas->nohp}}</td>
                          <td>Rp. {{format_uang($datas->total)}}</td>
                          <td>Cash On Delivery
                          </td>
                          <td>{{$datas->users->name}}</td>
                        </tr>
                        <thead>
                        <tr>
                          <td></td>
                          <td></td>
                          <th>nama barang</th>
                          <th>Jenis barang</th>
                          <th>harga</th>
                          <th>jumlah</th>
                          <th>subtotal</th>
                        </tr>
                        </thead>
                        @foreach($datas->items as $items)
                        <tr>
                          <td></td>
                          <td></td>
                          <td>{{$items->nama}}</td>
                          <td>{{$items->jenis}}</td>
                          <td>Rp. {{format_uang($items->harga)}}</td>
                          <td>{{$items->jumlah}}</td>
                          <td>Rp. {{format_uang($items->subtotal)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                          <th></th>
                          <th></th>
                          <th>Total</th>
                          <th>Rp. {{format_uang($datas->total)}}</th>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
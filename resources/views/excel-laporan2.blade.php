<table>
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nama Pemohon</th>
                          <th>Jenis</th>
                          <th>Luas Lahan</th>
                          <th>Periode</th>
                          <th>Harga</th>
                        </tr>
                      </thead>

                      <tbody>
                        @php $no = 1; $total = 0;@endphp
                        @foreach($data as $datas)
                        <tr class="table">
                          <td>{{$no++}}</td>
                          <td>{{$datas->users->name}}</td>
                          <td>Gadail Lahan</td>
                          <td>{{$datas->luas_lahan}}</td>
                          <td>{{$datas->periode}}</td>
                          <td>Rp. {{format_uang($datas->harga)}}</td>
                          @php $total = $total + $datas->harga; @endphp
                        </tr>
                        @endforeach
                        <tr>
                          <th colspan="4"></th>
                          <th>Total</th>
                          <th>Rp. {{format_uang($total)}}</th>
                        </tr>
                      </tbody>
                    </table>
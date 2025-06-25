    <table class="table table-bordered table-hover table-striped table-sm">
        <thead class="thead-dark">   
        <tr>
            <th width="50px">No</th>
            <th width="100px">Kode Acc</th>
            <th width="260px">Nama Account</th>
            <th width="450px">Uraian</th>
            <th width="150px" class="text-right">Nilai</th>
            <th width="160px" class="text-center"></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($bankd as $data)
            <tr>
                <td class="text-right">{{ $loop->iteration }}</td>
                <td>{{ $data->kode }}</td>
                <td>{{ $data->nama}}</td>
                <td>{{ $data->uraian}}</td>
                <td  class="text-right">{{ FormatAngka($data->nilai)}}</td>
                <td width="120">
                        @if($hak_akses['edit'])
                            <button type="button" class="btn btn-primary btn-sm" onclick="edit_detail({{$data->id}})"><i class="fa fa-pencil"></i> Edit</button>
                        @endif 
                        @if($hak_akses['hapus'])
                            <button class="btn btn-danger btn-sm" type="button" onclick="return hapus_detail({{$data->id}})" title="Hapus">
                                <i class="fa fa-trash"></i> Hapus</button>
                        @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table cellpadding="6">
        @foreach ($bankm as $data2)
        <tr><td width="750px"></td>
            <td width="250px" class="text-right">Total</td>
            <td width="150px" class="text-right" style="border:1px solid #d3d3d3;background:#c9c9c9;">{{ FormatAngka($data2->nilai)}}</td>
        </tr>
        @endforeach
    </table>          
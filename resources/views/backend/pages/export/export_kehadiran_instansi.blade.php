<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Instansi</th>
            <th>Registrasi</th>
            <th>Registrasi Offline</th>
            <th>Registrasi Online</th>
            <th>Terverifikasi</th>
            <th>Belum Terverifikasi</th>
            <th>Partisipan Online</th>
            <th>Partisipan Offline</th>
            <th>Partisipan Hadir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($instansis as $instansi)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $instansi->name }}</td>
            <td>{{ $instansi->participants->where('status',1)->count() }}</td>
            <td>{{ $instansi->participants->where('kehadiran', 'onsite')->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('kehadiran', 'online')->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('verification', 1)->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('verification', 2)->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'online')->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->where('status', 1)->count() }}</td>
            <td>{{ $instansi->participants->where('verification', 1)->where('kehadiran', 'onsite')->where('attendance', 1)->where('status', 1)->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table style="width: 100%; border-collapse: collapse;">
  <thead>
      <tr>
          <th style="border: 1px black solid; text-align: center;">ID</th>
          <th style="border: 1px black solid; text-align: center;">Token</th>
          <th style="border: 1px black solid; text-align: center;">Name</th>
          <th style="border: 1px black solid; text-align: center;">Instansi</th>
          <th style="border: 1px black solid; text-align: center;">Jabatan</th>
          <th style="border: 1px black solid; text-align: center;">Email</th>
          <th style="border: 1px black solid; text-align: center;">Phone Number</th>
          <th style="border: 1px black solid; text-align: center;">Point</th>
          <th style="border: 1px black solid; text-align: center;">Status Verifikasi</th>
          <th style="border: 1px black solid; text-align: center;">Status Kehadiran</th>
          <th style="border: 1px black solid; text-align: center;">Kehadiran</th>
          <th style="border: 1px black solid; text-align: center;">Kendaraan</th>
      </tr>
  </thead>
  <tbody>
      @foreach($participants as $participant)
      <tr>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->qrcode ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->token ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->name ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->instansi->name ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->jabatan ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->email ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->phone_number ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $participant->point ?? '' }}</td>
          @if($participant->verification == 1)
          <td style="border: 1px black solid; text-align: center;">Terverifikasi</td>
          @else
          <td style="border: 1px black solid; text-align: center;">Belum Terverifikasi</td>
          @endif
          @if($participant->attendance == 1)
          <td style="border: 1px black solid; text-align: center;">Hadir</td>
          @else
          <td style="border: 1px black solid; text-align: center;">Tidak Hadir</td>
          @endif
          @if($participant->kehadiran == 'onsite')
          <td style="border: 1px black solid; text-align: center;">Onsite</td>
          @else
          <td style="border: 1px black solid; text-align: center;">Online</td>
          @endif
          <td style="border: 1px black solid; text-align: center;">{{ $participant->kendaraan ?? '' }}</td>
      </tr>
      @endforeach
  </tbody>
</table>
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
          <th style="border: 1px black solid; text-align: center;">Point Earned</th>
          <th style="border: 1px black solid; text-align: center;">Point Left</th>
          <th style="border: 1px black solid; text-align: center;">Kehadiran</th>
          <th style="border: 1px black solid; text-align: center;">Kendaraan</th>
      </tr>
  </thead>
  <tbody>
      @foreach($userParticipants as $userParticipant)
      <tr>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->qrcode ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->token ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->name ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->instansi->name ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->jabatan ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->email ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->phone_number ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">1</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->point ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->kehadiran ?? '' }}</td>
          <td style="border: 1px black solid; text-align: center;">{{ $userParticipant->participant->kendaraan ?? '' }}</td>
      </tr>
      @endforeach
  </tbody>
</table>
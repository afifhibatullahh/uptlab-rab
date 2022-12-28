<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UPT Laboratorium ITERA</title>
</head>

<body>


    <h3>Rencana Anggaran Belanja</h3>
    <p>{{$data['message']}}</p>

    <table>
        <tr>
            <td>Judul Pengadaan </td>
            <td>:</td>
            <td>{{$data['body'][0]->title}} </td>
        </tr>
        <tr>
            <td>Nomor Akun </td>
            <td>:</td>
            <td>{{$data['body'][0]->nomor_akun}} </td>
        </tr>
        <tr>
            <td>Jenis RAB </td>
            <td>:</td>
            <td>{{$data['body'][0]->jenis}} </td>
        </tr>
        <tr>
            <td>Laboratorium </td>
            <td>:</td>
            <td>{{$data['body'][0]->laboratoriumname}} </td>
        </tr>
        <tr>
            <td>Waktu Pelaksanaan </td>
            <td>:</td>
            <td>{{$data['body'][0]->waktu_pelaksanaan}} </td>
        </tr>
    </table>
    {{-- <p>test</p> --}}
</body>

</html>
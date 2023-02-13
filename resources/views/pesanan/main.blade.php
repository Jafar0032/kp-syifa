<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <hr>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>
                    <a href="{{ url('/pesan/detail/'.$item->id) }}" class="btn btn-warning">Detail</a>
                    <a href="{{ url('/pesan/updateView/'.$item->id) }}" class="btn btn-warning">Ubah</a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</html>
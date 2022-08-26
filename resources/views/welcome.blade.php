<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
    </head>
    <body style="background-color: rgb(44, 62, 80);">
        <style>
            .putih {
                color: white;
            }
        </style>
        <div class="container">
            <br>
            <center><h5 class="putih">Geekseat Witch Saga</h5></center>
            <br>
            <form class="form" method="POST">
                @for ($i = 0; $i < 2; $i++)
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="putih">Person Name</label>
                            <input type="text" class="form-control" name="person_name[]" placeholder="Person Name">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="putih">Age of Death</label>
                            <input type="text" class="form-control" name="age_of_death[]" placeholder="Age of Death">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="putih">Year of Death</label>
                            <input type="text" class="form-control" name="year_of_death[]" placeholder="Year of Death">
                        </div>
                    </div>
                @endfor
                <button type="button" class="btn btn-primary btn-submit">Process</button><br>
                <br><div class="content-results"></div>
            </form>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.btn-submit').on('click', function(){
                var _form = $('.form').serializeArray()
                $.ajax({
                    url: 'saga',
                    method: 'POST',
                    data: _form,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var _results = response.results
                        var _averages = response.averages
                        $.each(_results, function(index, value) {
                            $('.content-results').append(`
                                <p class="putih">Person ${value.person} born on Year = ${value.year} - ${value.age} = ${value.selisih}, number of people killed on year ${value.selisih} is ${value.killed}</p>
                            `)
                        });
                        $('.content-results').append(`<p class="putih">So the average is ${_averages}</p>`)
                    }
                })
            })
        })
    </script>
</html>

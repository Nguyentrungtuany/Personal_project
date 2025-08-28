<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    

    <!-- jQuery + jQuery UI (phải load jQuery trước) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>

    <!-- Scripts Laravel -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS cho sortable -->
    <style>
        .ui-state-highlight {
            height: 50px;
            background-color: #f0f0f0 !important;
            border: 2px dashed #ccc !important;
        }
        .order_position tr {
            cursor: move;
        }
        .order_position tr:hover {
            background-color: #f8f9fa;
        }
        .ui-sortable-helper {
            background: #fff !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')
        @include('layouts.navbar')
        
        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- JavaScript cho DataTable -->
    <script>
        $(document).ready(function () {
            $('#tablephim').DataTable();
        });
    </script>

    <!-- JavaScript cho Slug -->
    <script>
        function ChangeToSlug() {
            var slug = document.getElementById("slug").value.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                       .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                       .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                       .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                       .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                       .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                       .replace(/đ/gi, 'd')
                       .replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '')
                       .replace(/ /gi, "-")
                       .replace(/\-+/gi, '-')
                       .replace(/^\-+|\-+$/g, '');
            document.getElementById('convert_slug').value = slug;
        }
    </script>
            
    <!-- JavaScript cho Sortable -->
    <script>
        
            $('.select-movie').change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ route('select-movie') }}",
                    method: "GET",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#show_movie').html(data);
                    }
                });
            });
        $('.select-year').change(function() {
        var year = $(this).find(':selected').val();
        var id_phim = $(this).attr('id');
            $.ajax({
                url: "{{ url('/update-year-phim') }}",
                method: "GET",
                data: {
                    year: year,
                    id_phim: id_phim
                },
                success: function() {
                    alert('Thay đổi phim năm' + year + 'thành công');
                }
            });
        });
        $('.select-topview').change(function() {
        var topview = $(this).find(':selected').val();
        var id_phim = $(this).attr('id');
        if(topview==0){
            var text = 'Ngày'
        }else if(topview==1){
            var text = 'Tuần'
        }else{
            var text = 'Tháng'
        }
            $.ajax({
                url: "{{ url('/update-topview-phim') }}",
                method: "GET",
                data: {
                    topview: topview,
                    id_phim: id_phim
                },
                success: function() {
                    alert('Thay đổi phim năm' + text + 'thành công');
                }
            });
        });
        
        $('.select-season').change(function() {
        var season = $(this).find(':selected').val();
        var id_phim = $(this).attr('id');
        var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/update-season-phim') }}",
                method: "POST",
                data: {
                    season: season,
                    id_phim: id_phim,
                    _token: _token
                },
                success: function() {
                    alert('Thay đổi phim season' + season + 'thành công');
                }
            });
        });

        

            $('.order_position').sortable({
                placeholder: 'ui-state-highlight',
                update: function () {
                    var array_id = [];
                    $('.order_position tr').each(function () {
                        array_id.push($(this).attr('id'));
                    });

                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: "{{ route('resorting') }}",
                        method: "POST",
                        data: { array_id: array_id },
                        success: function (data) {
                            alert("Sắp xếp thứ tự thành công");
                        },
                        error: function (xhr) {
                            alert("Có lỗi xảy ra: " + xhr.responseText);
                        }
                    });
                }
            });
    </script>
    
</body>
</html>

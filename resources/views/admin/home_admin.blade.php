@extends('layouts.app_admin')

@section('content')
    <style>
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            background: #FFFBEF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #843902;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="file"] {
            display: block;
        }

        button {
            background-color: #843902;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }


        .preview {
            margin-top: 10px;
        }

        .preview img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>

    <div class="form-container">
        <h2>Edit Home Images</h2>
        <form action="{{ route('home.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="banner_image">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" accept="image/*">
                @if($home && $home->banner_image)
                    <div class="preview">
                        <p>Current Banner:</p>
                        <img src="{{ asset('storage/' . $home->banner_image) }}" alt="Banner Image">
                    </div>
                @endif
            </div>

            @for ($i = 1; $i <= 4; $i++)
                <div class="form-group">
                    <label for="upcoming_image_{{ $i }}">Upcoming Image {{ $i }}</label>
                    <input type="file" name="upcoming_image_{{ $i }}" id="upcoming_image_{{ $i }}" accept="image/*">
                    @php $field = 'upcoming_image_' . $i; @endphp
                    @if($home && $home->$field)
                        <div class="preview">
                            <p>Current Upcoming Image {{ $i }}:</p>
                            <img src="{{ asset('storage/' . $home->$field) }}" alt="Upcoming Image {{ $i }}">
                        </div>
                    @endif
                </div>
            @endfor

            <div class="form-group">
                <label for="what_image_1">What Image 1</label>
                <input type="file" name="what_image_1" id="what_image_1" accept="image/*">
                @if($home && $home->what_image_1)
                    <div class="preview">
                        <p>Current What Image 1:</p>
                        <img src="{{ asset('storage/' . $home->what_image_1) }}" alt="What Image 1">
                    </div>
                @endif
            </div>

            <button type="submit">Update Images</button>
        </form>
    </div>

    <div class="form-container" style="margin-top: 40px;">
        <h2>Edit About Us Images</h2>
        <form action="{{ route('admin.about_us_images.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="header_image">About Us Header Image</label>
                <input type="file" name="header_image" id="header_image" accept="image/*">
                @if(isset($aboutUsImages) && $aboutUsImages->header_image)
                    <div class="preview">
                        <p>Current About Us Header Image:</p>
                        <img src="{{ asset('storage/' . $aboutUsImages->header_image) }}" alt="About Us Header Image">
                    </div>
                @endif
            </div>

            @for ($i = 1; $i <= 4; $i++)
                <div class="form-group">
                    <label for="series_image_{{ $i }}">Series Image {{ $i }}</label>
                    <input type="file" name="series_image_{{ $i }}" id="series_image_{{ $i }}" accept="image/*">
                    @php $field = 'series_image_' . $i; @endphp
                    @if(isset($aboutUsImages) && $aboutUsImages->$field)
                        <div class="preview">
                            <p>Current Series Image {{ $i }}:</p>
                            <img src="{{ asset('storage/' . $aboutUsImages->$field) }}" alt="Series Image {{ $i }}">
                        </div>
                    @endif
                </div>
            @endfor

            @for ($i = 1; $i <= 3; $i++)
                <div class="form-group">
                    <label for="why_image_{{ $i }}">Why Image {{ $i }}</label>
                    <input type="file" name="why_image_{{ $i }}" id="why_image_{{ $i }}" accept="image/*">
                    @php $field = 'why_image_' . $i; @endphp
                    @if(isset($aboutUsImages) && $aboutUsImages->$field)
                        <div class="preview">
                            <p>Current Why Image {{ $i }}:</p>
                            <img src="{{ asset('storage/' . $aboutUsImages->$field) }}" alt="Why Image {{ $i }}">
                        </div>
                    @endif
                </div>
            @endfor

            <button type="submit">Update About Us Images</button>
        </form>
    </div>
@endsection
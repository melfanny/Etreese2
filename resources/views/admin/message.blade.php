@extends('layouts.app_admin')

@section('content')
    <style>
        .message-body * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .message-body html,
        .message-body body {
            height: 100%;
        }

        .message-body body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .message-body .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            flex-grow: 1;
            background: #EBC4AE;
        }

        .message-body .form-container {
            width: 1200px;
            max-width: 100%;
            background: #843902;
            border-radius: 10px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            flex-direction: column;
            padding: 20px;
        }

        .message-body h1 {
            font-size: 36px;
            font-weight: 300;
            color: #FFFBEF;
            margin-bottom: 30px;
            text-align: center;
        }

        .message-body .message-card {
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #FFFBEF;
            margin-bottom: 1rem;
        }

        .message-body .message-text {
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-size: 18px;
        }

        .message-body .message-meta {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .message-body .message-meta span {
            font-weight: 600;
        }

        .message-body .no-messages {
            color: #6b7280;
            font-size: 16px;
        }
    </style>


    <div class="message-body">
        <div class="content-wrapper">
            <div class="form-container">
                <h1>Messages</h1>

                @if($messages->count() > 0)
                    <div>
                        @foreach($messages as $message)
                            <div class="message-card">
                                <p class="message-text">{{ $message->message }}</p>
                                <div class="message-meta">
                                    <span>From:</span> {{ $message->user ? $message->user->email : 'Unknown' }}<br>
                                    <span>Received:</span> {{ $message->created_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="no-messages">No messages found.</p>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection
<style>
        .notif-section {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fdf6f0;
        }

        .logo {
            font-weight: bold;
            font-size: 20px;
        }

        .notif-icon {
            font-size: 24px;
        }

        .container {
            background-color: #893b0d;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .notif-box {
            background-color: #f5c6b7;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #3b1806;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .notif-text {
            max-width: 80%;
        }

        .notif-time {
            font-size: 14px;
            white-space: nowrap;
        }

        .notif-date {
            font-weight: bold;
            margin-bottom: 5px;
        }

        @media (max-width: 600px) {
            .notif-box {
                flex-direction: column;
                gap: 10px;
            }

            .notif-text {
                max-width: 100%;
            }

            .notif-time {
                align-self: flex-end;
            }
        }
    </style>

<section class="notif-section">
    <div class="container">
        @forelse ($notifications as $notif)
            <div class="notif-box {{ $notif->is_read ? 'opacity-70' : '' }}">
                <div class="notif-text">
                    <div class="notif-date">{{ \Carbon\Carbon::parse($notif->created_at)->translatedFormat('l, j F Y') }}</div>
                    <div>{!! nl2br(e($notif->message)) !!}</div>
                </div>
                <div class="notif-time">{{ \Carbon\Carbon::parse($notif->created_at)->format('h:i A') }}</div>
            </div>
        @empty
            <div class="text-white text-center">Belum ada notifikasi.</div>
        @endforelse
    </div>
</section>

<script>
    // anggap semua notifikasi sudah dibaca ketika pengguna peri ke notification page
    fetch("{{ route('notifications.readAll') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
</script>

<style>
    .about-contact-section {
        background-color: #873f06;
        padding: 50px 20px;
        text-align: center;
        font-family: 'Arial', sans-serif;
    }

    .about-contact-title {
        font-size: 28px;
        font-weight: bold;
        color: white;
        margin-bottom: 10px;
    }

    .about-contact-description {
        font-size: 18px;
        color: white;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .about-contact-form {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .about-contact-textarea {
        width: 100%;
        padding: 20px;
        border: none;
        border-radius: 10px;
        background-color: white;
        color: #5e5e5e;
        font-size: 16px;
        resize: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        outline: none;
    }

    .about-contact-button {
        margin-top: 10px;
        background-color: #EBC4AE;
        color: #873f06;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        padding: 5px;
    }

    body p {
        color: white;

    }
</style>

<body>
    <div class="about-contact-section">
        <h2 class="about-contact-title">CONTACT US!</h2>
        <p class="about-contact-description">
            Kirimkan pesan kepada kami, dan kami akan segera menghubungi Anda.
        </p>

        @auth
            @if(session('success'))
                <div style="color: lime; margin-bottom: 40px;">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="color: red; margin-bottom: 10px;">
                    {{ $errors->first() }}
                </div>
            @endif
            <form class="about-contact-form" method="POST" action="{{ route('contact.store') }}">
                @csrf
                <textarea class="about-contact-textarea" placeholder="Type your message here...." name="message"
                    rows="4"></textarea>
                <button type="submit" class="about-contact-button">SEND</button>
            </form>
        @else
            <p>Harap <a href="{{ route('login') }}">melakukan login</a> untuk kirim pesan.</p>
        @endauth
    </div>
</body>
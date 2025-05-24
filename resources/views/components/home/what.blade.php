<style>
    .name-what {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 100vh;
        background-color: #F4CBB2;
        font-family: 'Poppins', sans-serif;
        padding: 0;
    }

    .name-what .left-image {
        flex: 1 1 50%;
    }

    .name-what .left-image img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
    }

    .name-what .right-content {
        flex: 1 1 50%;
        padding: 40px;
        position: relative;
        color: #000;
        text-align: center;
    }

    .name-what .title {
        font-size: 65px;
        font-weight: 900;
        z-index: 1;
        position: relative;
    }

    .name-what .title span {
        background-color: white;
        padding: 5px 10px;
        display: inline-block;
        transform: rotate(-2deg);
        margin-bottom: 10px;
    }

    .name-what .btn-learn {
        background-color: #843902;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .name-what {
            flex-direction: column;
        }

        .name-what .left-image img {
            height: auto;
        }

        .name-what .right-content {
            text-align: center;
        }

        .name-what .right-content::before {
            display: none;
        }
    }
</style>

<div class="name-what">
    <div class="left-image">
        @if($home && $home->what_image_1)
            <img src="{{ asset('storage/' . $home->what_image_1) }}" alt="Etree Introduction Image">
        @else
            <img src="https://i.pinimg.com/736x/b9/46/0b/b9460b24d46c83643a359426230061b7.jpg"
                alt="Etree Introduction Image">
        @endif
    </div>
    <div class="right-content">
        <div class="title">
            <span>WHAT IS</span><br>
            <strong>ETREESE ?</strong>
        </div>
        <a href="{{ route('aboutus') }}" class="btn-learn">Learn More</a>
    </div>
</div>
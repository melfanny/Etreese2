<style>
    .about-why-container {
        background-color: #edcfc0;
        padding: 40px 20px;
        text-align: center;
        font-family: 'Arial', sans-serif;
    }

    .about-why-title {
        font-size: 28px;
        font-weight: bold;
        color: #873f06;
        margin-bottom: 40px;
    }

    .about-why-cards {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: center;
    }

    @media (min-width: 768px) {
        .about-why-cards {
            flex-direction: row;
            justify-content: center;
        }
    }

    .about-why-card {
        background-color: #fffaf0;
        border-radius: 8px;
        width: 400px;
        /* diperbesar */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px;
        /* padding diperbesar juga */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .about-why-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 20px rgba(135, 63, 6, 0.3);
    }

    .about-why-icon {
        background-color: #fbe1d2;
        width: 160px;
        /* diperbesar */
        height: 160px;
        /* diperbesar */
        border-radius: 50%;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .about-why-card:hover .about-why-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .about-why-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .about-why-heading {
        background-color: #873f06;
        color: white;
        width: 100%;
        padding: 12px 0;
        font-size: 18px;
        font-weight: bold;
        border-radius: 4px;
        margin-bottom: 12px;
    }

    .about-why-text {
        color: #3a1e0b;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
    }
</style>

<body>
    <div class="about-why-container">
        <h2 class="about-why-title">KENAPA ETREESE?</h2>
        <div class="about-why-cards">
            <div class="about-why-card">
                <div class="about-why-icon">
                    @if(isset($aboutUsImages) && $aboutUsImages->why_image_1)
                        <img src="{{ asset('storage/' . $aboutUsImages->why_image_1) }}" alt="Indonesia Asset">
                    @else
                        <img src="/images/rafflesia hitam.png" alt="Indonesia Asset">
                    @endif
                </div>
                <h3 class="about-why-heading">Indonesia Asset</h3>
                <p class="about-why-text">
                    Kami selalu memadukan fashion dengan unsur-unsur khas nusantara sebagai tujuan pengenalan dan
                    pelestarian.
                </p>
            </div>
            <div class="about-why-card">
                <div class="about-why-icon">
                    @if(isset($aboutUsImages) && $aboutUsImages->why_image_2)
                        <img src="{{ asset('storage/' . $aboutUsImages->why_image_2) }}" alt="Eco Friendly">
                    @else
                        <img src="/images/melati hitam.png" alt="Eco Friendly">
                    @endif
                </div>
                <h3 class="about-why-heading">Eco Friendly</h3>
                <p class="about-why-text">
                    Kami menggunakan kemasan yang ramah lingkungan dan mudah didaur ulang untuk mendukung Go Green.
                </p>
            </div>
            <div class="about-why-card">
                <div class="about-why-icon">
                    @if(isset($aboutUsImages) && $aboutUsImages->why_image_3)
                        <img src="{{ asset('storage/' . $aboutUsImages->why_image_3) }}" alt="Customer">
                    @else
                        <img src="/images/kenanga hitam.png" alt="Customer">
                    @endif
                </div>
                <h3 class="about-why-heading">Customer</h3>
                <p class="about-why-text">
                    Kami mengutamakan kepuasan customer dengan menggunakan bahan yang nyaman dan respon yang
                    komunikatif.
                </p>
            </div>
        </div>
    </div>
</body>
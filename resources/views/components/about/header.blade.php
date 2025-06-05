<style>
    .about-header * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .about-header {
        font-family: 'Poppins', sans-serif;
        background-color: #EBC4AE;
        color: #843902;
        overflow-x: hidden;
    }

    .about-header header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 20px 40px;
        background-color: #EBC4AE;
    }

    .about-header .button-box {
        width: 150px;
        height: 50px;
        background: #EBC4AE;
        border-radius: 20px;
        margin-right: 20px;
    }

    .about-header .icon-group {
        display: flex;
        gap: 10px;
    }

    .about-header .icon-group img {
        width: auto;
        height: 60px;
    }

    .about-header .section {
        display: flex;
        flex-wrap: wrap;
        padding-left: 10%;
        padding-right: 10%;
        padding-top: 50px;
        padding-bottom: 50px;
        gap: 40px;
        background-color: #EBC4AE;
    }

    .about-header .image-container {
        flex: 1;
        min-width: 300px;
        max-width: 450px;
    }

    .about-header .image-container img {
        width: 100%;
        height: 600px;
        object-fit: cover;
        border-radius: 5%;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .about-header .content-container {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .about-header .box {
        background-color: #FFFBEF;
        padding: 30px;
        border-radius: 10px;
        display: block;
        transition: all 0.3s ease;
    }

    .about-header .heading {
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .about-header .text {
        font-size: 20px;
        font-weight: 700;
        line-height: 1.5;
        text-align: justify;
    }

    .about-header .right-align {
        text-align: right;
    }

    @media (max-width: 768px) {
        .about-header .heading {
            font-size: 40px;
        }

        .about-header .text {
            font-size: 20px;
        }
    }

    /* Hover Effects */
    .about-header .image-container img:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .about-header .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
</style>

</head>

<body>
    <div class="about-header">
        <section class="section">
            <div class="image-container">
                @if(isset($aboutUsImages) && $aboutUsImages->header_image)
                    <img src="{{ asset('storage/' . $aboutUsImages->header_image) }}" alt="About Image">
                @else
                    <img src="/images/etreese logo.jpg" alt="About Image">
                @endif
            </div>
            <div class="content-container">
                <div class="box">
                    <div class="heading">Kami Adalah Etreese</div>
                    <div class="text">
                        Etreese - UMKM fesyen inovatif yang menghadirkan kolaborasi sempurna antara modernitas dan
                        kekayaan
                        budaya Nusantara. Setiap produk kami dirancang dengan filosofi 'Contemporary Heritage',
                        memadukan
                        teknik modern dengan motif, tekstil, dan nilai-nilai tradisional Indonesia. Lebih dari sekadar
                        pakaian, setiap koleksi Etreese adalah ekspresi kecintaan akan warisan budaya dalam gaya hidup
                        kontemporer.
                    </div>
                </div>
                <div class="box">
                    <div class="heading">Indonesia Pride</div>
                    <div class="text">
                        Indonesia memiliki potensi luar biasa, baik dari segi sumber daya alam maupun kreativitas. Salah
                        satu cara untuk mengembangkan hal ini adalah dengan memperkuat branding produk lokal, seperti
                        yang
                        kami lakukan melalui desain unik dengan memadukan elemen khas Indonesia.
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
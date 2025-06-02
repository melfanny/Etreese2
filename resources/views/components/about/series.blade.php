<style>
    .about-series {
        /* Tidak perlu styling khusus di level ini, hanya pembungkus */
    }

    .about-series-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 50px 10%;
        background-color: #FFFBEF;
        gap: 40px;
        min-height: 100vh;
    }

    .left-content {
        flex: 1 1 60%;
    }

    .right-content {
        flex: 1 1 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding-left: 5%;
        gap: 20px;
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
        color: #843902;
    }

    .right-content h2 {
        font-size: 2rem;
    }

    .right-content mark {
        background-color: #E6B597;
        color: #843902;
        padding: 0 5px;
    }

    .about-series-box {
        background-color: #843902;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        color: white;
        transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
    }

    .about-series-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        background-color: #a44e0c;
    }

    .about-series-box img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .about-series-box:hover img {
        transform: scale(1.05);
    }

    .about-series-box h4 {
        font-size: 1rem;
        color: white;
    }

    .box-footer {
        margin-top: 15px;
    }

    .about-series-box-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
    }

    @media (max-width: 768px) {
        .about-series-section {
            flex-direction: column;
            align-items: center;
        }

        .right-content {
            align-items: center;
            text-align: center;
            padding-left: 0;
        }

        .about-series-box-container {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }
</style>

</head>

<body>
    <div class="about-series">
        <section class="about-series-section">
            <div class="left-content">
                <div class="about-series-box-container">
                    <div class="about-series-box">
                        <img src="/images/anggrek bulan realistis.png"
                            alt="Anggrek Bulan">
                        <div class="box-footer">
                            <h4>Anggrek Bulan</h4>
                        </div>
                    </div>
                    <div class="about-series-box">
                        <img src="/images/melati realistis.png" alt="Melati">
                        <div class="box-footer">
                            <h4>Melati</h4>
                        </div>
                    </div>
                    <div class="about-series-box">
                        <img src="/images/rafflesia realistis.png"
                            alt="Rafflesia Arnoldi">
                        <div class="box-footer">
                            <h4>Rafflesia Arnoldi</h4>
                        </div>
                    </div>
                    <div class="about-series-box">
                        <img src="/images/kenanga realistis.png"
                            alt="Kenanga">
                        <div class="box-footer">
                            <h4>Kenanga</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-content">
                <h2><mark>BLOOM SERIES</mark></h2>
                <h2>OUR SIGNATURE</h2>
                <h2>FLOWER</h2>
            </div>
        </section>
    </div>
</body>